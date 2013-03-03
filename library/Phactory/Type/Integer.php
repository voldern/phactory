<?php
namespace Phactory\Type;

use Phactory\Exception\SetupException,
    Phactory\Generator\RandomInterface;

class Integer extends Type implements RandomInterface {
    /**
     * {@inheritdoc}
     * @return int
     */
    public function generateRandom() {
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

        return rand($min, $max);
    }
}
