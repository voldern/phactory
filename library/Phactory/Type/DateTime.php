<?php
namespace Phactory\Type;

use Phactory\Generator\RandomInterface;

/**
 * DateTime field type
 *
 * @author Espen Volden <voldern@hoeggen.net>
 * @package Type
 */
class DateTime extends Type implements RandomInterface {
    /**
     * {@inheritdoc}
     * @return \DateTime
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

        return new \DateTime('@' . $dateTime);
    }

    /**
     * {@inheritdoc}
     * @return \DateTime
     */
    public function generateStatic() {
        $dateTime = parent::generateStatic();

        if (!($dateTime instanceof \DateTime)) {
            $dateTime = new \DateTime($dateTime);
        }

        return $dateTime;
    }

    /**
     * {@inheritdoc}
     * @return \DateTime
     */
    protected function randomStaticValue() {
        $dateTime = parent::randomStaticValue();

        if (!($dateTime instanceof \DateTime)) {
            $dateTime = new DateTime($dateTime);
        }

        return $dateTime;
    }
}