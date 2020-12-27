<?php

namespace PascaleBeier\ThunderbirdIspdb\Command;

use PascaleBeier\ThunderbirdIspdb\Upstream;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\HttpClient\HttpClient;
use Symfony\Component\Process\Process;

class UpdateCommand extends Command
{
    protected static $defaultName = 'ispdb:update';

    protected function configure()
    {
        $this
            ->setDescription('Updates the local ISPDB.')
        ;
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        return $this->getLatestArchive($output);
    }

    protected function getLatestArchive(OutputInterface $output)
    {
        $client = HttpClient::create();

        if ($output->isVerbose()) {
            $output->writeln('Retrieving latest Archive ...');
        }

        $ref = Upstream::getLatestRef($output);

        $tmpFile = tempnam(sys_get_temp_dir(), 'archive');

        $archiveEndpoint = 'https://api.github.com/repos/thundernest/autoconfig/tarball/' . $ref;

        $response = $client->request('GET', $archiveEndpoint, [
            'headers' => [
                'Accept' => 'application/vnd.github.v3+json'
            ]
        ]);

        $fileHandler = fopen($tmpFile, 'wb');
        foreach ($client->stream($response) as $chunk) {
            fwrite($fileHandler, $chunk->getContent());
        }


        if ($output->isVeryVerbose()) {
            $output->writeln($response->getInfo('debug'));
        }

        if ($output->isVerbose()) {
            $output->writeln('Cleaning up dist/ ...');
        }

        foreach (glob('dist/*') as $file) {
            if ($output->isVeryVerbose()) {
                $output->writeln('Removing ' . $file . ' ...');
            }
            unlink($file);
        }

        $cmd = new Process(['tar', '-xzf', $tmpFile, '--strip-components=2', '-C', 'dist', '--exclude=*.json']);
        $cmd->start();

        while ($cmd->isRunning()) {
            if ($output->isVerbose()) {
                $output->writeln('Extracting Archive to dist/ ...');
            }

            if ($output->isVerbose()) {
                $output->writeln('Writing .version ...');
            }

            file_put_contents(__DIR__ . '/../../../.version', $ref);
        }


        if ($cmd->getExitCode() === Command::SUCCESS) {
            $output->writeln("<info>Downloaded $ref.</info>");

            return Command::SUCCESS;
        }

        $output->writeln('<error>Could not extract Archive.</error>');

        if ($output->isVerbose()) {
            $output->writeln($cmd->getErrorOutput());
        }

        return Command::FAILURE;
    }
}
