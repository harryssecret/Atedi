<?php

namespace App\Command;

use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;
use PhpMyAdmin\SqlParser\Parser;
use PhpMyAdmin\SqlParser\Utils\Query;

#[AsCommand(
    name: 'atedi:import',
    description: 'Import SQL files from other app to Atedi.',
    hidden: false,
    aliases: ["at:i"]
)]
class ImportCommand extends Command
{
    protected function configure(): void
    {
        $this
            ->addArgument('db_file', InputArgument::OPTIONAL, 'location of the database file')
        ;
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $io = new SymfonyStyle($input, $output);
        $dbFile = $input->getArgument('db_file');

        if ($dbFile) {
            $output->writeln("Importation du fichier suivant: $dbFile");
        }

        $query = 'SELECT * FROM helico';
        $parser = new Parser($query);

        $output->writeln(Query::getFlags($parser->statements[0]->build()));

        $io->success('You have a new command! Now make it your own! Pass --help to see your options.');

        return Command::SUCCESS;
    }

    private function readSqlScript(string $filename) {
        $sqlScript = fopen($filename, 'r');
        $line = fgets($sqlScript);
        $parser = new Parser($line);
        $flags = Query::getFlags()
    }
}
