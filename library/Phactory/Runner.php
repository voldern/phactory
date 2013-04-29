<?php
namespace Phactory;

use Phactory\Phactory,
    Phactory\Database\DatabaseInterface,
    Phactory\Exception\RuntimeException;

/**
 * Factory runner
 *
 * @author Espen Volden <voldern@hoeggen.net>
 * @package Phactory
 */
class Runner {
    /**
     * Factory
     *
     * @var Phactory
     */
    private $factory;

    /**
     * Database driver
     *
     * @var DatabaseInterface
     */
    private $db;

    /**
     * Config
     *
     * @var array
     */
    private $config = array(
        'count' => 1,
        'sleep' => false,
        'repeat' => false
    );

    /**
     * Constructor
     *
     * @param Phactory $factory
     * @param DatabaseInterface $db
     */
    public function __construct(Phactory $factory, DatabaseInterface $db) {
        $this->factory = $factory;
        $this->db = $db;
    }

    /**
     * Start generating rows
     *
     * @throws RuntimeException
     * @param array $config
     * @return array
     */
    public function run(array $config = array()) {
        if (count($config) !== 0) {
            $this->config = array_merge($this->config, $config);
        }

        if (!is_array($this->config['repeat'])) {
            return $this->generate($this->config['count']);
        }

        if (!isset($this->config['repeat']['count'])) {
            throw new RuntimeException('Missing repeat count');
        }

        $repeatCount = $this->config['repeat']['count'];
        $rows = array();

        for ($i = 0; $i < $repeatCount; $i++) {
            $rows[] = $this->generate($this->config['count']);

            if (isset($this->config['repeat']['sleep']) && $repeatCount != ($i + 1)) {
                sleep($this->config['repeat']['sleep']);
            }
        }

        return $rows;
    }

    /**
     * Generate rows
     *
     * @param int $count Number of rows to generate
     */
    private function generate($count) {
        if ($count === 1 || !$this->config['sleep']) {
            $rows = $this->factory->generate($count);

            $this->db->insertRows($rows);
        } else {
            $rows = array();

            for ($i = 0; $i < $count; $i++) {
                $rows[] = $this->factory->generate(1);

                $this->db->insertRows($rows[$i]);

                sleep($this->config['sleep']);
            }
        }

        return $rows;
    }
}