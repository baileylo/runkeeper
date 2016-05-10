<?php

use GuzzleHttp\Client as HttpClient;
use JMS\Serializer\SerializerBuilder;
use Portico\RunKeeper\RunKeeper;
use Portico\RunKeeper\Entities\User;

require __DIR__ . '/../vendor/autoload.php';

$credential = '<Your Auth Credential>';

// Bootstrap Serializer
$serializer = SerializerBuilder::create()
    ->setCacheDir(__DIR__ . '/../cache')
    ->setDebug(true)
    ->addMetadataDir(__DIR__ . '/../config')
    ->build();

$api = new RunKeeper($serializer);
$runner = $api->getUser($credential);
$recentActivity = $api->fitnessActivities($runner, $credential);

foreach ($recentActivity as $activity) {
    $activity = $api->activity($activity, $credential);
}