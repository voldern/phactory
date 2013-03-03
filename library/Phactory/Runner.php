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
        'count' => 5,
        'repeat' => false
    );

    /**
     * Constructor
     *
     * @param Phactory $factory
     * @param array $config
     */
    public function __construct(Phactory $factory, DatabaseInterface $db,
        array $config = array()) {
        $this->factory = $factory;

        $this->db = $db;

        foreach ($config as $key => $value) {
            $this->config[$key] = $value;
        }
    }

    /**
     * Start generating rows
     *
     * @throws RuntimeException
     * @return array
     */
    public function run() {
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
        $rows = $this->factory->generate($count);

        array_walk($rows, array($this->db, 'insertRows'));

        return $rows;
    }
}