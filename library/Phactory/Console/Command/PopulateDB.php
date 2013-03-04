<?php
namespace Phactory\Console\Command;

use Symfony\Component\Console\Command\Command,
    Symfony\Component\Console\Input\InputInterface,
    Symfony\Component\Console\Input\InputArgument,
    Symfony\Component\Console\Input\InputOption,
    Symfony\Component\Console\Output\OutputInterface;

/**
 * CLI command used to populate db
 *
 * @author Espen Volden <voldern@hoeggen.net>
 * @package Command
 */
class PopulateDB extends Command {
    /**
     * {@inheritdoc}
     */
    protected function configure() {
        $this->setName('phactory:populate')
            ->setDescription('Populate database using a factory')
            ->addArgument(
                'factory',
                InputArgument::REQUIRED,
                'Factory name'
            )
            ->addArgument(
                'table',
                InputArgument::REQUIRED,
                'Table/collection name'
            )
            ->addArgument(
                'count',
                InputArgument::OPTIONAL,
                'Number of rows to insert',
                1
            )
            ->addOption(
                'file',
                'f',
                InputOption::VALUE_OPTIONAL,
                'File that houses factory'
            )
            ->addOption(
                'host',
                null,
                InputOption::VALUE_OPTIONAL,
                'Database hostname',
                'localhost'
            )
            ->addOption(
                'database',
                'db',
                InputOption::VALUE_OPTIONAL,
                'Database name',
                'phactory'
            )
            ->addOption(
                'cleanup',
                'c',
                InputOption::VALUE_NONE,
                'Remove inserted rows when finished?'
            );
    }

    /**
     * {@inheritdoc}
     */
    protected function execute(InputInterface $input, OutputInterface $output) {
        $factory = $input->getArgument('factory');
        $file = $input->getOption('file');
        $rowCount = (int) $input->getArgument('count');

        if (!class_exists($factory) && empty($file)) {
            $output->writeln('<error>Could not find factory. Please set the path ' .
                'using --file</error>');

            return false;
        }

        require_once($file);

        if (!class_exists($factory)) {
            $output->writeln('<error>Could not find factory.</error>');
            return false;
        }

        $factory = new $factory();

        $dbConfig = array(
            'hostname' => $input->getOption('host'),
            'db' => $input->getOption('database'),
            'collection' => $input->getArgument('table')
        );

        $this->populateDB($dbConfig, $factory->generate($rowCount));
    }

    /**
     * Populate database with the given rows
     *
     * @param array $config DB config
     * @param array $rows Rows
     * @return void
     */
    private function populateDB(array $config, array $rows) {
        $db = new \Phactory\Database\MongoDB();

        $db->connect($config);

        $db->insertRows($rows);
    }
}
