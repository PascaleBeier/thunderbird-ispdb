<?php

namespace PascaleBeier\ThunderbirdIspdb\Command;

use PascaleBeier\ThunderbirdIspdb\Upstream;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\HttpClient\HttpClient;

class VerifyCommand extends Command
{
    protected static $defaultName = 'ispdb:verify';

    protected function configure()
    {
        $this
            ->setDescription('Verifies the current ISPDB in this Repository.');
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        if ($this->verifyRef($output)) {
            $output->writeln('<info>Repository is up-to-date.</info>');
            return Command::SUCCESS;
        }

        $output->writeln('<error>Repository is out of date.</error>');
        return Command::FAILURE;
    }

    private function verifyRef(OutputInterface $output): bool
    {
        $localRef = trim(file_get_contents(__DIR__ . '/../../../.version'));

        if ($output->isVerbose()) {
            $output->writeln(sprintf('Local Version: %s', $localRef));
        }


        $remoteRef = Upstream::getLatestRef($output);

        if ($output->isVerbose()) {
            $output->writeln(sprintf('Remote Version: %s', $remoteRef));
        }

        return $localRef === $remoteRef;
    }
}
