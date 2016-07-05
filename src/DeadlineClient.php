<?php

namespace Morrislaptop\Deadline;

use GuzzleHttp\Client;
use GuzzleHttp\Psr7\Request;

class DeadlineClient
{
    /**
     * @var Client
     */
    protected $client;

    public function __construct(Client $client)
    {
        $this->client = $client;
    }

    public function submitJob($payload)
    {
        $request = new Request('POST', "jobs", [], json_encode($payload));

        return $this->send($request);
    }

    public function getAllTheJobs()
    {
        $request = new Request('GET', "jobs");

        return $this->send($request);
    }

    public function getJob($job)
    {
        $request = new Request('GET', "jobs?JobId=" . $job);

        return $this->send($request);
    }

    public function suspendJob($job)
    {
        $payload = [
            'Command' => 'suspend',
            'JobID' => $job
        ];
        
        $request = new Request('PUT', "jobs", [], json_encode($payload));

        return $this->send($request);        
    }

	protected function send(Request $request, array $options = [])
    {
        $request = $request->withHeader('Content-Type', 'application/json');

        $response = $this->client->send($request, $options);

        return json_decode($response->getBody(), true);
    }
}