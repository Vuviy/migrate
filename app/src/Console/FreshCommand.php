<?php

namespace App\Console;

use App\DB\DB;
use App\DB\MigrationLock;
use App\Repository\MigrationRepository;
use RuntimeException;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\ArrayInput;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class FreshCommand extends Command
{
    protected function configure(): void
    {
        $this->setName('migrate:fresh')->setDescription('fresh migration');
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $lock = new MigrationLock();

        try {
            $lock->acquire();

            $db = new DB();

            $db->query('SET FOREIGN_KEY_CHECKS=0');

            foreach ((new MigrationRepository())->all() as $row) {
                $file = __DIR__ . "/../../database/migrations/{$row['migration']}";
                $migration = require $file;
                $migration->down();
            }

            $db->query('TRUNCATE migrations');
            $db->query('SET FOREIGN_KEY_CHECKS=1');

            (new MigrateCommand())->run(
                new ArrayInput([]),
                $output
            );

            return Command::SUCCESS;
        } catch (RuntimeException $exception) {
            $output->writeln('<error>' . $exception->getMessage() . '</error>');
            return Command::FAILURE;
        } finally {
            $lock->release();
        }
    }
}
