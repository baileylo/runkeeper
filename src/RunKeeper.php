<?php

namespace Portico\RunKeeper;

use GuzzleHttp\Client;
use GuzzleHttp\Exception\RequestException;
use GuzzleHttp\Exception\TransferException;
use GuzzleHttp\Psr7\Request;

class RunKeeper
{
    /** @var Client */
    private $client;

    public function __construct(Client $client)
    {
        $this->client = $client;
    }

    public function getUser($token)
    {
        $request = new Request('GET', 'https://api.runkeeper.com/user', [
            'Authorization' => "Bearer {$token}"
        ]);

        $response = $this->dispatch($request);

        var_dump((string)$request, (string)$response);
    }

    /**
     * Dispatches API Request.
     *
     * @param Request $request
     *
     * @return null|\Psr\Http\Message\ResponseInterface Null on total API failure
     */
    private function dispatch(Request $request)
    {
        try {
            $response = $this->client->send($request);
        } catch (RequestException $e) {
            $response = $e->getResponse();
        } catch (TransferException $e) {
            // Fatal Error From API...
            $response = null;
        }

        return $response;
    }
}