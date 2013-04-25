<?php
namespace Phactory\Generator;

/**
 * Function generator interface
 *
 * @author Espen Volden <voldern@hoeggen.net>
 * @package Generator
 */
interface CallableInterface {
    /**
     * Generate value from callable
     */
    public function generateCallable();
}
