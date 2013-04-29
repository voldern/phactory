<?php
namespace Phactory\Type;

use Phactory\Generator\RandomInterface;

/**
 * MongoDate field type
 *
 * @author Espen Volden <voldern@hoeggen.net>
 * @package Type
 */
class MongoDate extends Type implements RandomInterface {
    /**
     * {@inheritdoc}
     * @return \MongoDate
     */
    public function generateRandom() {
        if (isset($this->config['values'])) {
            return $this->randomStaticValue();
        }

        $min = new \DateTime('-1 year');
        $max = new \DateTime('+1 year');

        if (isset($this->config['range'])) {
            if (isset($this->config['range']['min'])) {
                $min = $this->config['range']['min'];

                if (!($min instanceof \DateTime)) {
                    $min = new \DateTime($min);
                }
            }

            if (isset($this->config['range']['max'])) {
                $max = $this->config['range']['max'];

                if (!($max instanceof \DateTime)) {
                    $max = new \DateTime($max);
                }
            }
        }

        $dateTime = mt_rand($min->getTimestamp(), $max->getTimestamp());

        $dateTime = new \DateTime('@' . $dateTime);

        return new \MongoDate($dateTime->getTimestamp());
    }

    /**
     * {@inheritdoc}
     * @throws Exception
     * @return \MongoDate
     */
    public function generateStatic() {
        $mongoDate = parent::generateStatic();

        if (is_string($mongoDate)) {
            $date = new \DateTime($mongoDate);
            $mongoDate = new \MongoDate($date->getTimestamp());
        }

        if (is_numeric($mongoDate)) {
            $mongoDate = new \MongoDate($mongoDate);
        }

        if (!($mongoDate instanceof \MongoDate)) {
            throw new \Exception('Uknown date format');
        }

        return $mongoDate;
    }

    /**
     * {@inheritdoc}
     * @return \MongoDate
     */
    protected function randomStaticValue() {
        $mongoDate = parent::randomStaticValue();

        if (!($mongoDate instanceof \MongoDate)) {
            $mongoDate = new \MongoDate($mongoDate);
        }

        return $mongoDate;
    }
}