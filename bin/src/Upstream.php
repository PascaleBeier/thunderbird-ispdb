<?php

namespace PascaleBeier\ThunderbirdIspdb;

use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\HttpClient\HttpClient;

class Upstream
{
    public static function getLatestRef(OutputInterface $output): string
    {
        $client = HttpClient::create();

        if ($output->isVeryVerbose()) {
            $output->writeln('Retrieving remote Version ...');
        }

        $refEndpoint = 'https://api.github.com/repos/thundernest/autoconfig/git/ref/heads/master';

        $response = $client->request('GET', $refEndpoint, [
            'headers' => [
                'Accept' => 'application/vnd.github.v3.sha'
            ]
        ]);

        $responseBody = $response->toArray();

        if ($output->isVeryVerbose()) {
            $output->writeln($response->getInfo('debug'));
        }

        return $responseBody['object']['sha'] ?? '';
    }
}
