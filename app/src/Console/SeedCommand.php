<?php

namespace App\Console;

use App\DB\DB;
use App\DB\MigrationLock;
use App\Seeders\DatabaseSeeder;
use RuntimeException;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class SeedCommand extends Command
{
    protected function configure(): void
    {
        $this->setName('db:seed')->setDescription('Seed data');
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $lock = new MigrationLock();

        try {
            $lock->acquire();

            $seeder = new DatabaseSeeder();

            $seeder->run(new DB());

            return Command::SUCCESS;
        } catch (RuntimeException $exception) {
            $output->writeln('<error>' . $exception->getMessage() . '</error>');
            return Command::FAILURE;
        } finally {
            $lock->release();
        }
    }
}
