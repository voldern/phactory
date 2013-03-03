<?php
namespace Phactory\Database;

use Phactory\Exception\SetupException,
    Phactory\Exception\RuntimeException;

/**
 * MongoDB database driver
 *
 * @author Espen Volden <voldern@hoeggen.net>
 * @package Database
 */
class MongoDB implements DatabaseInterface {
    /**
     * Database adapter
     *
     * @var \Mongo
     */
    private $adapter;

    /**
     * Mongo collection
     *
     * @var \MongoCollection
     */
    private $collection;

    /**
     * Rows inserted during this session
     *
     * @var array
     */
    private $insertedRows = array();

    /**
     * {@inheritdoc}
     */
    public function connect(array $config) {
        $requiredParams = array('hostname', 'db', 'collection');

        foreach ($requiredParams as $param) {
            if (!isset($config[$param])) {
                throw new SetupException('Missing config attribute "' . $param . '"');
            }
        }

        $port = isset($config['port']) ? (int) $config['port'] : 27017;

        $mongo = new \Mongo('mongodb://' . $config['hostname'] . ':' . $config['port']);

        $this->adapter = $mongo->selectDB($config['db']);

        $this->collecion = $this->adapter->selectCollection($config['collection']);

        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function insertRows(array $rows) {
        if ($this->collection === null) {
            throw new RuntimeException('You need to connect() first');
        }

        array_walk($rows, array($this, 'insertRow'));

        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function getInsertedRows() {
        return $this->insertedRows;
    }

    /**
     * {@inheritdoc}
     */
    public function removeInsertedRows() {
        if (count($this->insertedRows) === 0) {
            throw new RuntimeException('There are no rows to remove');
        }

        array_walk($this->insertedRows, array($this, 'removeRow'));

        $this->clearInsertedRows();

        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function clearInsertedRows() {
        $this->insertedRows = array();

        return $this;
    }

    /**
     * Insert row into database
     *
     * @param array $row Row to insert
     * @return boolean
     * @throws RuntimeException
     */
    private function insertRow(array $row) {
        // If the primaryId is missing set it automaticly
        if (!isset($row['_id'])) {
            $row['_id'] = new \MongoId();
        }

        $this->insertedRows[] = $row;

        $status = $this->collection->insert($row, array('w' => 1));

        if ($status['err'] !== null) {
            throw new RuntimeException('Failed to insert row with error: ' .
                $status['err']);
        }

        return true;
    }

    /**
     * Remove row
     *
     * @param array $row Row to remove
     * @return MongoDB
     * @throws RuntimeException
     */
    private function removeRow(array $row) {
        if (!isset($row['_id'])) {
            throw new RuntimeException('Could not delte. Missing _id attribute.');
        }

        $status = $this->collection->remove(array('_id' => $row['_id']),
            array('w' => 1));

        if ($status['err'] !== null) {
            throw new RuntimeException('Failed to remove row with error: ' .
                $status['err']);
        }

        return $this;
    }
}
