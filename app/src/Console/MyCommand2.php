<?php

namespace App\Console;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class MyCommand2 extends Command
{
    protected function configure(): void
    {
        $this
            ->setName('hello2')
            ->setDescription('Say hello2')
            ->addArgument('name', InputArgument::OPTIONAL);
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $output->writeln('Hello2 ' . ($input->getArgument('name') ?? 'Guest'));
        return Command::SUCCESS;
    }
}