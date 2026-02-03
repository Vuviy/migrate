<?php

namespace App\Console;

use App\DB\MigrationLock;
use App\Repository\MigrationRepository;
use RuntimeException;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class MigrateCommand extends Command
{
    protected function configure(): void
    {
        $this->setName('migrate')->setDescription('Run migration');
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $lock = new MigrationLock();

        try {
            $lock->acquire();

            $repo = new MigrationRepository();

            $batch = $repo->getLastBatch() + 1;
            $executed = $repo->getExecuted();

            $files = glob(__DIR__ . '/../../database/migrations/*.php');

            foreach ($files as $file) {
                $name = basename($file);

                if (in_array($name, $executed)) {
                    continue;
                }

                $migration = require $file;

                $migration->up();

                $repo->log($name, $batch);
                $output->writeln("✔ Migrated: $name");
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
