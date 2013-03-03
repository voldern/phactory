<?php
namespace Phactory\Type;

use Phactory\Generator\RandomInterface;

/**
 * Boolean field type
 *
 * @author Espen Volden <voldern@hoeggen.net>
 * @package Type
 */
class Boolean extends Type implements RandomInterface {
    /**
     * {@inheritdoc}
     * @return boolean
     */
    public function generateRandom() {
        return (bool) rand(0, 1);
    }

    /**
     * {@inheritdoc}
     * @return boolean
     */
    public function generateStatic() {
        return (bool) parent::generateStatic();
    }
}
