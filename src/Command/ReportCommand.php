<?php
namespace App\Command;

use App\Repository\CommentRepository;
use App\Service\ReportService;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;
use Symfony\Component\Console\Attribute\AsCommand;

#[AsCommand(
    name: 'app:daily-report',
    description: 'Creating daily report.'
)]
class ReportCommand extends Command
{
    public function __construct(private ReportService $service)
    {
        parent::__construct();
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $io = new SymfonyStyle($input, $output);

        $file_name = $this->service->create();

        $io->success('Creating daily report in public/'. $file_name);

        return Command::SUCCESS;
    }
}