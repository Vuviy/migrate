<?php

namespace App\Console;

use App\Repository\MigrationRepository;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class StatusCommand extends Command
{
    protected function configure(): void
    {
        $this->setName('migrate:status')->setDescription('status migration');
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $repo = new MigrationRepository();
        $executed = array_column($repo->all(), 'migration');

        $files = glob(__DIR__ . '/../../database/migrations/*.php');

        foreach ($files as $file) {
            $name = basename($file);
            $status = in_array($name, $executed) ? '✔' : '✘';

            $output->writeln("$status $name");
        }

        return Command::SUCCESS;
    }
}
