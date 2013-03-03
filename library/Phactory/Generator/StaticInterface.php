<?php
namespace Phactory\Generator;

/**
 * Static generator interface
 *
 * @author Espen Volden <voldern@hoeggen.net>
 * @package Generator
 */
interface StaticInterface {
    /**
     * Generate random value
     */
    public function generateStatic();
}
