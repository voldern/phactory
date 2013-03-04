<?php
class IntegerExample extends \Phactory\Phactory {
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