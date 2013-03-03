<?php
namespace Phactory\Generator;

/**
 * Random generator interface
 *
 * @author Espen Volden <voldern@hoeggen.net>
 * @package Generator
 */
interface RandomInterface {
    /**
     * Generate a static value
     */
    public function generateRandom();
}