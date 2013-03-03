<?php
require_once __DIR__ . '/../library/autoloader.php';

spl_autoload_register('autoload');

class IntegerFactory extends \Phactory\Phactory {
    protected $fields = array(
        'randomField' => array(
            'type' => '\Phactory\Type\Integer',
            'generator' => 'random',
            'range' => array('min' => 5, 'max' => 30)
        ),
        'staticField' => array(
            'type' => '\Phactory\Type\Integer',
            'generator' => 'static',
            'value' => 15
        )
    );
}

$intfact = new IntegerFactory();
var_dump($intfact->generate(1));
