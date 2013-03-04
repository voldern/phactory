<?php
require_once __DIR__ . '/../vendor/autoload.php';

class DateTimeFactory extends \Phactory\Phactory {
    protected $fields = array(
        'staticField' => array(
            'type' => '\Phactory\Type\DateTime',
            'generator' => 'static',
            'value' => 'now'
        ),
        'randomField' => array(
            'type' => '\Phactory\Type\DateTime',
            'generator' => 'random',
            'range' => array('min' => 'now', 'max' => '+1 day')
        ),
        'randoStaticValues' => array(
            'type' => '\Phactory\Type\DateTime',
            'generator' => 'random',
            'static' => array('now', '+1 day', '+2 day', '+1 year')
        )
    );
}

$fact = new DateTimeFactory();
var_dump($fact->generate(1));
