<?php
namespace Phactory;

use Phactory\Exception\RuntimeException,
    Phactory\Phactory;

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
    public function __construct(Phactory $factory, array $config = array()) {
        $this->factory = $factory;

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

        $rows = array();

        for ($i = 0; $i < $this->config['repeat']['count']; $i++) {
            $rows[] = $this->generate($this->config['count']);

            if (isset($this->config['repeat']['sleep'])) {
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
        return $this->factory->generate($count);
    }
}