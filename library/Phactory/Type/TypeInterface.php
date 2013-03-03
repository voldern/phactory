<?php
namespace Phactory\Type;

/**
 * Field type interface
 *
 * @author Espen Volden <voldern@hoeggen.net>
 * @package Type
 */
interface TypeInterface {
    /**
     * Setup the field with given config
     *
     * @throws SetupException
     * @param array $config Field config
     * @return Phactory\Type
     */
    public function setup(array $config);

    /**
     * Generates a field
     *
     * @throws SetupException
     * @throws RuntimeException
     * @param array $config The config for the field
     * @return array
     */
    public function generate();
}