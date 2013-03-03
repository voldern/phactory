<?php
namespace Phactory\Type;

use Phactory\Generator\StaticInterface,
    Phactory\Exception\SetupException,
    Phactory\Exception\RuntimeException;

/**
 * Abstract base class for all field types
 *
 * @author Espen Volden <voldern@hoeggen.net>
 * @package Type
 */
abstract class Type implements TypeInterface, StaticInterface {
    /**
     * Field config
     *
     * @var array
     */
    protected $config = array();

    /**
     * The generator method
     *
     * @var method
     */
    protected $generatorMethod = null;

    /**
     * {@inheritdoc}
     */
    public function setup(array $config) {
        if (!isset($config['generator'])) {
            throw new SetupException('Generator is not set');
        }

        if (!method_exists($this, 'generate' . ucfirst($config['generator']))) {
            throw new SetupException('Does not implement ' .
                $config['generator'] . ' generator');
        }

        $this->generatorMethod = 'generate' . ucfirst($config['generator']);

        $this->config = $config;

        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function generate() {
        if ($this->generatorMethod === null) {
            throw new RuntimeException('Please run setup() first');
        }

        return call_user_func(array($this, $this->generatorMethod));
    }

    /**
     * {@inheritdoc}
     * @throws RuntimeException
     */
    public function generateStatic() {
        if (!isset($this->config['value'])) {
            throw new RuntimeException('Missing value');
        }

        return $this->config['value'];
    }
}