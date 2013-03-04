<?php
namespace Phactory\Console\Command;

use Phactory\Exception\ConsoleException,
    Symfony\Component\Console\Command\Command,
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
                'dir',
                null,
                InputOption::VALUE_OPTIONAL,
                "Folder to look for factory in if it couldn't be autoloaded",
                'factories'
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
        $file = $input->getOption('file');
        $rowCount = (int) $input->getArgument('count');

        try {
            $factory = $this->getFactory($input);
        } catch (ConsoleException $exception) {
            $output->writeln('<error>' . $exception->getMessage() . '</error>');
            return false;
        }

        $dbConfig = array(
            'hostname' => $input->getOption('host'),
            'db' => $input->getOption('database'),
            'collection' => $input->getArgument('table')
        );

        $rows = $this->populateDB($dbConfig, $factory->generate($rowCount));

        $output->writeln('<info>Inserted ' . count($rows) . ' rows</info>');

        if ($input->getOption('verbose')) {
            foreach ($rows as $row) {
                $output->writeln(print_r($row, true));
            }
        }
    }

    /**
     * Look for the given factory
     *
     * @throws ConsoleException
     * @param InputInterface $input Input
     * @return Phactory
     */
    private function getFactory(InputInterface $input) {
        $factoryName = $input->getArgument('factory');

        if (!class_exists($factoryName)) {
            $file = $input->getOption('file');
            $dir = $input->getOption('dir');

            if (!empty($file) && file_exists($file)) {
                require_once($file);
            } else if (file_exists($dir . '/' . $factoryName . '.php')) {
                require_once($dir . '/' . $factoryName . '.php');
            } else {
                throw new ConsoleException('Could not find factory. '.
                    'Try suppling --file or --directory');
            }
        }

        return new $factoryName();
    }

    /**
     * Populate database with the given rows
     *
     * @param array $config DB config
     * @param array $rows Rows
     * @return array
     */
    private function populateDB(array $config, array $rows) {
        $db = new \Phactory\Database\MongoDB();

        $db->connect($config);

        $db->insertRows($rows);

        return $db->getInsertedRows();
    }
}
