<?php
require_once __DIR__ . '/../vendor/autoload.php';

class MongoIdFactory extends \Phactory\Phactory {
    protected $fields = array(
        'staticField' => array(
            'type' => '\Phactory\Type\MongoId',
            'generator' => 'static',
            'value' => '5133b68b48336e08b0000000'
        ),
        'randomField' => array(
            'type' => '\Phactory\Type\MongoId',
            'generator' => 'random'
        ),
        'randomStaticValues' => array(
            'type' => '\Phactory\Type\MongoId',
            'generator' => 'random',
            'values' => array('5133b62d48336e37ae000000', '5133b64d48336e65ae000000',
                '5133b67b48336e3caf000000')
        )
    );
}

$fact = new MongoIdFactory();
var_dump($fact->generate(1));
