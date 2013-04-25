<?php
namespace Phactory;

use Phactory\Exception\SetupException,
    Phactory\Exception\RuntimeException;

/**
 * Abstract base class that all factories should extend
 *
 * @author Espen Volden <voldern@hoeggen.net>
 * @package Phactory
 */
abstract class Phactory {
    /**
     * Holds field config
     *
     * @var array
     */
    private $fields;

    /**
     * Get field config
     *
     * @return array
     */
    abstract protected function getFieldsConfig();

    /**
     * Constructor
     *
     * @throws SetupException
     * @return \Phactory\Phactory
     */
    public function __construct() {
        $fields = $this->getFieldsConfig();

        if (count($fields) === 0) {
            throw new SetupException('Empty fields config');
        }

        $this->fields = $fields;
    }

    /**
     * Generate items
     *
     * @param int $count Number of rows to generate
     * @return boolean
     */
    public function generate($count) {
        $rows = array();

        for ($i = 0; $i < $count; $i++) {
            $rows[] = $this->generateRow();
        }

        return $rows;
    }

    /**
     * Generate row
     *
     * @return array
     */
    private function generateRow() {
        $row = array();

        foreach ($this->fields as $field => $config) {
            $row = $row + $this->generateField($field, $config);
        }

        return $row;
    }

    /**
     * Generate field
     *
     * @throws RuntimeException
     * @param string $field Field name
     * @param string $config Field config
     * @return array
     */
    private function generateField($field, $config) {
        if (!isset($config['type'])) {
            throw new RuntimeException('Type is missing on the following field: ' .
                $field);
        }

        $fieldGenerator = new $config['type']();

        $out = $fieldGenerator->setup($config)->generate();

        return array($field => $out);
    }
}