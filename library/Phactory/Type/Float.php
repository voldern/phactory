<?php
namespace Phactory\Type;

use Phactory\Generator\RandomInterface,
    Phactory\Generator\CallableInterface,
    Phactory\Exception\RuntimeException;

/**
 * Float field type
 *
 * @author Espen Volden <voldern@hoeggen.net>
 * @package Type
 */
class Float extends Type implements RandomInterface, CallableInterface {
    /**
     * {@inheritdoc}
     * @return float
     */
    public function generateRandom() {
        if (isset($this->config['values'])) {
            return (float) $this->randomStaticValue();
        }

        return $this->generateRandomRange();
    }

    /**
     * {@inheritdoc}
     * @return float
     */
    public function generateStatic() {
        return (float) parent::generateStatic();
    }

    /**
     * {@inheritdoc}
     * @throws RuntimeException
     * @return float
     */
    public function generateCallable() {
        if (!isset($this->config['value'])) {
            throw new RuntimeException('Missing value');
        }

        $function = $this->config['value'];

        if (!is_callable($function)) {
            throw new RuntimeException('Value is not callable');
        }

        return (float) $function();
    }

    /**
     * Generate a random float
     *
     * @return float
     */
    private function generateRandomRange() {
        $min = 0;
        $max = getrandmax();

        if (isset($this->config['range'])) {
            if (isset($this->config['range']['min'])) {
                $min = $this->config['range']['min'];
            }

            if (isset($this->config['range']['max'])) {
                $max = $this->config['range']['max'];
            }
        }

        return mt_rand($min, $max);
    }
}
