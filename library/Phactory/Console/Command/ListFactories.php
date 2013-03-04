<?php
namespace Phactory\Console\Command;

use Phactory\Exception\ConsoleException,
    Symfony\Component\Console\Command\Command,
    Symfony\Component\Console\Input\InputInterface,
    Symfony\Component\Console\Input\InputOption,
    Symfony\Component\Console\Output\OutputInterface;

/**
 * CLI command used to list all factories in a folder
 *
 * @author Espen Volden <voldern@hoeggen.net>
 * @package Command
 */
class ListFactories extends Command {
    /**
     * {@inheritdoc}
     */
    protected function configure() {
        $this->setName('phactory:list')
            ->setDescription('List all available factories')
            ->addOption(
                'dir',
                'd',
                InputOption::VALUE_REQUIRED,
                'Folder to look for factories in',
                'factories'
            );
    }

    /**
     * {@inheritdoc}
     */
    protected function execute(InputInterface $input, OutputInterface $output) {
        $dirName = $input->getOption('dir');

        if (!is_dir($dirName)) {
            $output->writeln('<error>' . $dirName . ' is not a directory. ' .
                'Supply a valid directory using --dir.</error>');
            return false;
        }

        $dir = dir($dirName);

        $output->writeln('<info>Available factories:</info>');

        while (false !== ($file = $dir->read())) {
            if ($file != '.' && $file != '..') {
                $this->printFactoryNames($dirName, $file, $output);
            }
        }
    }

    /**
     * Lists the factories in the given file. Prints nothing if there are none
     *
     * @param string $dir Directory
     * @param string $file Filename
     * @param OutputInterface $output Output
     * @return void
     */
    private function printFactoryNames($dir, $file, OutputInterface $output) {
        $fileCode = file_get_contents($dir . '/' . $file);

        $factories = $this->getClasses($fileCode);

        if (count($factories) === 0) {
            return;
        }

        $output->writeln('<comment>' . $dir . '/' . $file . ': ' .
            implode(', ', $factories) . '</comment>');
    }

    /**
     * Returns classes in the given PHP code by analysing the AST
     *
     * @param string $code PHP code to analyze
     * @return array
     */
    private function getClasses($code) {
        $classes = array();
        $tokens = token_get_all($code);
        $tokenCount = count($tokens);

        // First two tokens are always <?php
        for ($i = 2; $i < count($tokens); $i++) {
            if (!is_array($tokens[$i - 2]) || !is_array($tokens[$i - 1]) ||
                !is_array($tokens[$i])) {
                continue;
            }

            if ($tokens[$i - 2][0] === T_CLASS && $tokens[$i - 1][0] === T_WHITESPACE &&
                $tokens[$i][0] === T_STRING) {
                $classes[] = $tokens[$i][1];
            }
        }

        return $classes;
    }
}
