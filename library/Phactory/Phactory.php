<?php
namespace Phactory;

use Phactory\Exception\SetupException;

/**
 * Abstract base class that all factories should extend
 *
 * @author Espen Volden <voldern@hoeggen.net>
 * @package Phactory
 */
abstract class Phactory {
    /**
     * Fields configuration array
     *
     * @var array
     */
    protected $fields = array();

    /**
     * Constructor
     *
     * @throws SetupException
     * @return \Phactory\Phactory
     */
    public function __construct() {
        if (count($this->fields) === 0) {
            throw new SetupException('No field config found');
        }
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
            $rows = $rows + $this->generateRow();
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

        foreach ($this->fields AS $field => $config) {
            $row = $row + $this->generateField($field, $config);
        }

        return $row;
    }

    /**
     * Generate field
     *
     * @throws Exception
     * @param string $field Field name
     * @param string $config Field config
     * @return array
     */
    private function generateField($field, $config) {
        if (!isset($config['type'])) {
            throw new Exception('Type is missing on the following field: ' .
                $field);
        }

        $fieldGenerator = new $config['type']();

        $out = $fieldGenerator->setup($config)->generate();

        return array($field => $out);
    }
}