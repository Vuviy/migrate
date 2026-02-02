<?php

namespace App\Console;

use App\DB\DB;
use App\DB\Migration;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class MyCommand extends Command
{
    protected function configure(): void
    {
        $this
            ->setName('migrate')
            ->setDescription('test migrate')
            ->addArgument('name', InputArgument::OPTIONAL);
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $migration = new Migration();

        $sql = $migration->up();


//        dd($sql);

        $db = new DB();

        $db->query($sql);


        return Command::SUCCESS;
    }
}