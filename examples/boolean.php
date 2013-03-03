<?php
require_once __DIR__ . '/../library/autoloader.php';

spl_autoload_register('autoload');

class BooleanFactory extends \Phactory\Phactory {
    protected $fields = array(
        'randomField' => array(
            'type' => '\Phactory\Type\Boolean',
            'generator' => 'random'
        ),
        'staticField' => array(
            'type' => '\Phactory\Type\Boolean',
            'generator' => 'static',
            'value' => true
        )
    );
}

$intfact = new BooleanFactory();
var_dump($intfact->generate(1));
