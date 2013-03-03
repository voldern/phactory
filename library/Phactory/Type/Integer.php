<?php
namespace Phactory\Type;

use Phactory\Generator\RandomInterface;

/**
 * Integer field type
 *
 * @author Espen Volden <voldern@hoeggen.net>
 * @package Type
 */
class Integer extends Type implements RandomInterface {
    /**
     * {@inheritdoc}
     * @return int
     */
    public function generateRandom() {
        if (isset($this->config['values'])) {
            return (int) $this->randomStaticValue();
        }

        return $this->generateRandomRange();
    }

    /**
     * {@inheritdoc}
     * @return int
     */
    public function generateStatic() {
        return (int) parent::generateStatic();
    }

    /**
     * Generate a random integer
     *
     * @return int
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
