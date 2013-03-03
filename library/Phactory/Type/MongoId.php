<?php
namespace Phactory\Type;

use Phactory\Generator\RandomInterface;

/**
 * MongoId field type
 *
 * @author Espen Volden <voldern@hoeggen.net>
 * @package Type
 */
class MongoId extends Type implements RandomInterface {
    /**
     * {@inheritdoc}
     * @return \MongoId
     */
    public function generateRandom() {
        return new MongoId();
    }

    /**
     * {@inheritdoc}
     * @return \MongoId
     */
    public function generateStatic() {
        $mongoId = parent::generateStatic();

        if (!($mongoId instanceof \MongoId)) {
            $mongoId = new MongoId($mongoId);
        }

        return $mongoId;
    }
}