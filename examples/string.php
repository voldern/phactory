<?php
require_once __DIR__ . '/../vendor/autoload.php';

class StringFactory extends \Phactory\Phactory {
    protected $fields = array(
        'staticString' => array(
            'type' => '\Phactory\Type\String',
            'generator' => 'static',
            'value' => 'Test'
        ),
        'randomField' => array(
            'type' => '\Phactory\Type\String',
            'generator' => 'random',
            'values' => array('Dette er en test', 'Test asd', 'Foobar', 'Foo')
        ),
        'randomWordsLorem' => array(
            'type' => '\Phactory\Type\String',
            'generator' => 'random',
            'words' => 3
        ),
        'randomSentencesLorem' => array(
            'type' => '\Phactory\Type\String',
            'generator' => 'random',
            'sentences' => 3
        )
    );
}

$intfact = new StringFactory();
var_dump($intfact->generate(1));
