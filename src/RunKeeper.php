<?php

namespace Portico\RunKeeper;

use GuzzleHttp\Client;
use GuzzleHttp\Exception\RequestException;
use GuzzleHttp\Exception\TransferException;
use GuzzleHttp\Psr7\Request;
use GuzzleHttp\Psr7\Response;
use JMS\Serializer\Exception\RuntimeException;
use JMS\Serializer\Serializer;
use Portico\RunKeeper\Entities\Activity;

class RunKeeper
{
    /** @var Client */
    private $client;

    /** @var Serializer */
    private $serializer;

    public function __construct(Serializer $serializer)
    {
        $this->serializer = $serializer;
        $this->client = new Client([
            'base_uri' => 'https://api.runkeeper.com'
        ]);
    }

    /**
     * Allow injection or modification of the Guzzle Client.
     * @param Client $client
     */
    public function setClient(Client $client)
    {
        $this->client = $client;
    }

    /**
     * Fetch information about a user.
     *
     * @param string $token User's access token
     *
     * @return Entities\User
     */
    public function getUser($token)
    {
        $request = new Request('GET', '/user', [
            'Authorization' => "Bearer {$token}",
            'Content-Type'  => 'application/vnd.com.runkeeper.User+json'
        ]);

        $response = $this->dispatch($request);
        return $this->deserialize($response, Entities\User::class, 'json');
    }

    /**
     * @param Entities\User $user
     * @param               $token
     *
     * @return Entities\ActivityFeed|null
     */
    public function fitnessActivities(Entities\User $user, $token)
    {
        $request = new Request('GET', "{$user->fitness_activities}", [
            'Authorization' => "Bearer {$token}",
            'Content-Type'  => 'application/vnd.com.runkeeper.FitnessActivityFeed+json'
        ]);

        $response = $this->dispatch($request);
        return $this->deserialize($response, Entities\ActivityFeed::class, 'json');
    }

    public function activity(Activity $activity, $token)
    {
        $request = new Request('GET', "{$activity->uri}", [
            'Authorization' => "Bearer {$token}",
            'Content-Type'  => 'application/vnd.com.runkeeper.FitnessActivitySummary+json'
        ]);

        $response = $this->dispatch($request);
        return $this->deserialize($response, Entities\FitnessActivity::class, 'json');
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

    /**
     * @param Response|null $response   Null in the case of response failure
     * @param string        $class_name The name of the entity to population
     * @param string        $format     The serialization format
     *
     * @return mixed Should be an instance of $class_name or null
     * @throws \Exception
     */
    private function deserialize($response, $class_name, $format = 'json')
    {
        if (is_null($response)) {
            // api failure, just return null
            return null;
        }

        if ($response->getStatusCode() === 401) {
            throw new \Exception('Authorization Error, Please Check Token');
        }

        if ($response->getStatusCode() !== 200) {
            throw new \Exception('Bad API Request - (string) $response->getBody()', $response->getStatusCode());
        }

        try {
            $entity = $this->serializer->deserialize($response->getBody(), $class_name, $format);
        } catch (RuntimeException $e) {
            throw new \Exception('Api Serialization Response Failure - ' . $e->getMessage());
        }

        return $entity;
    }
}