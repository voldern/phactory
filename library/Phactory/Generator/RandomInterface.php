<?php
namespace Phactory\Generator;

use Phactory\Exception\SetupException,
    Phactory\Exception\RuntimeException;

interface RandomInterface {
    /**
     * Generate random value
     *
     * @throws SetupException
     * @throws RuntimeException
     */
    public function generateRandom();
}