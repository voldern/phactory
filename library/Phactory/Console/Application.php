<?php
namespace Phactory\Console;

use Symfony\Component\Console;

class Application extends Console\Application {
    public function __construct() {
        parent::__construct('PhactoryCli', '0.1');

        $this->add(new Command\ListFactories());
        $this->add(new Command\PopulateDB());
    }
}
