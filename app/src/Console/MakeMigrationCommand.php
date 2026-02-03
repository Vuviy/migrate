<?php

namespace App\Console;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class MakeMigrationCommand extends Command
{
    protected function configure(): void
    {
        $this
            ->setName('migrate:make')
            ->setDescription('Create a new migration')
            ->addArgument('name', InputArgument::REQUIRED, 'Migration name');
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $name = $input->getArgument('name');

        $data = new \DateTime();

        $timestamp =  $data->format('Y_m_d_His');
        $filename = "{$timestamp}_{$name}.php";

        $path = __DIR__ . '/../../database/migrations/' . $filename;

        if (file_exists($path)) {
            $output->writeln('<error>Migration already exists</error>');
            return Command::FAILURE;
        }

        file_put_contents($path, $this->template());

        $output->writeln("<info>Created migration:</info> {$filename}");

        return Command::SUCCESS;
    }

    private function template(): string
    {
        return <<<'PHP'
<?php

use App\DB\Migration;

return new class extends Migration {

    public function up(): void
    {
         $sql = $this->schema->create('table', function ($table) {
            $table->id();
       
        });

        $this->db->query($sql);
    }

    public function down(): void
    {
        $this->db->query('DROP TABLE table');
    }
};
PHP;
    }
}
