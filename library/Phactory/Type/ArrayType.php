<?php
namespace Phactory\Type;

use Phactory\Generator\RandomInterface;

/**
 * Array field type
 *
 * @author Espen Volden <voldern@hoeggen.net>
 * @package Type
 */
class ArrayType extends Type implements RandomInterface {
    /**
     * {@inheritdoc}
     * @return boolean
     */
    public function generateRandom() {
        if (!isset($this->config['values'])) {
            throw new RuntimeException('Missing values');
        }

        return (array) $this->randomStaticValue();
    }

    /**
     * {@inheritdoc}
     * @return boolean
     */
    public function generateStatic() {
        return (array) parent::generateStatic();
    }
}