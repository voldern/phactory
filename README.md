# PHP data factory

## Usage
### Installation
Add ```voldern/phactory``` as a dev dependency using composer.

```json
{
  "require-dev": {
    "voldern/phactory": "dev-master"
  }
}
```

### Defining a factory
By default factories should recide in a folder named ```factories``` and the filename should be the same as the factory name.

Create a class extending ```\Phactory\Phactory``` with the attributes configuration set on ```$fields```.

```php
class InteractionFactory extends \Phactory\Phactory {
    protected $fields = array(
        'feedModuleId' => array(
            'type' => '\Phactory\Type\MongoId',
            'generator' => 'random'
        ),
        'type' => array(
            'type' => '\Phactory\Type\String',
            'generator' => 'static',
            'value' => 'interaction'
        ),
        'title' => array(
            'type' => '\Phactory\Type\String',
            'generator' => 'random',
            'values' => array('Tittelen', 'Dette er en tittel', 'Nyhetssak',
                'VM 2013 Dag 1', 'EM 2012')
        ),
        'name' => array(
            'type' => '\Phactory\Type\String',
            'generator' => 'random',
            'values' => array('VM 2013', 'EM 2012', 'Navnet er langt', 'Dette er en test')
        ),
        'moderated' => array(
            'type' => '\Phactory\Type\Boolean',
            'generator' => 'static',
            'value' => false
        ),
        'permissions' => array(
            'type' => '\Phactory\Type\ArrayType',
            'generator' => 'static',
            'value' => array()
        ),
        'startDate' => array(
            'type' => '\Phactory\Type\DateTime',
            'generator' => 'static',
            'value' => 'now'
        ),
        'endDate' => array(
            'type' => '\Phactory\Type\DateTime',
            'generator' => 'random',
            'range' => array('min' => '+5 minutes', 'max' => '+20 minutes')
        ),
        'refreshRate' => array(
            'type' => '\Phactory\Type\Integer',
            'generator' => 'random',
            'range' => array('min' => 5, 'max' => 30)
        )
    );
}
```

### Running
Use the phactory CLI located in ```bin/``` or ```vendor/bin/```.

The currently supported commands are:

* List factories: ```phactory phactory:list```
* Populate DB using factory: ```phactory phactory:populate [--dir=] [-f|--file=] [--host=] [-db|--database=] [-c|--cleanup] factory table [count]```

## License
"THE BEER-WARE LICENSE":

Copyright (C) 2013 Espen Volden

As long as you retain this notice you can do whatever you want with this stuff.
If we meet some day, and you think this stuff is worth it, you can buy me one or more beers in return.
