<?php
namespace Phactory\Console\Command;

use Symfony\Component\Console\Command\Command,
    Symfony\Component\Console\Input\InputInterface,
    Symfony\Component\Console\Input\InputOption,
    Symfony\Component\Console\Output\OutputInterface;

class ListFactories extends Command {
    protected function configure() {
        $this->setName('phactory:list')
            ->setDescription('List all available factories')
            ->addOption(
                'dir',
                'd',
                InputOption::VALUE_REQUIRED,
                'Folder to look for factories in'
            );
    }

    protected function execute(InputInterface $input, OutputInterface $output) {
        $dir = $input->getOption('dir');

        if (empty($dir)) {
            throw new \Exception('Missing dir option');
        }

        if (!is_dir($dir)) {
            throw new \Exception('Invalid dir specified');
        }

        $dir = dir($dir);

        $output->writeln('<info>Available factories:</info>');

        while (false !== ($file = $dir->read())) {
            $this->printFactoryName($file, $output);
        }
    }

    private function printFactoryName($file, $output) {
        if ($file == '.' || $file == '..') {
            return;
        }

        $factoryName = substr($file, 0, strrpos($file, '.'));

        $output->writeln('<comment>' . $factoryName . '</comment>');
    }
}
