<?php

namespace App\Command;

use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;

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

        $io->success('You have a new command! Now make it your own! Pass --help to see your options.');

        return Command::SUCCESS;
    }
}
