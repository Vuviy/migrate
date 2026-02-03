<?php

namespace App\Console;

use App\DB\MigrationLock;
use App\Repository\MigrationRepository;
use RuntimeException;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\ArrayInput;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class RollbackCommand extends Command
{
    protected function configure(): void
    {
        $this->setName('migrate:rollback')->setDescription('Rollback migration');
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $lock = new MigrationLock();

        try {
            $lock->acquire();

            $repo = new MigrationRepository();
            $batch = $repo->getLastBatch();

            if ($batch === 0) {
                $output->writeln('Nothing to rollback');
                return Command::SUCCESS;
            }

            $migrations = $repo->getByBatch($batch);

            foreach ($migrations as $row) {
                $file = __DIR__ . "/../../database/migrations/{$row['migration']}";

                $migration = require $file;
                $migration->down();

                $repo->delete($row['migration']);

                $output->writeln("↩ Rolled back: {$row['migration']}");
            }

            return Command::SUCCESS;
        } catch (RuntimeException $exception) {
            $output->writeln('<error>' . $exception->getMessage() . '</error>');
            return Command::FAILURE;
        } finally {
            $lock->release();
        }
    }
}
