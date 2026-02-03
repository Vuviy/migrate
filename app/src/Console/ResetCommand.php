<?php

namespace App\Console;

use App\DB\MigrationLock;
use App\Repository\MigrationRepository;
use RuntimeException;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\ArrayInput;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class ResetCommand extends Command
{
    protected function configure(): void
    {
        $this->setName('migrate:reset')->setDescription('Reset migration');
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $lock = new MigrationLock();

        try {
            $lock->acquire();

            while ((new MigrationRepository())->getLastBatch() > 0) {
                (new RollbackCommand())->run(
                    new ArrayInput([]),
                    $output
                );
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
