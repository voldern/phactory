<?php
class BooleanExample extends \Phactory\Phactory {
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
