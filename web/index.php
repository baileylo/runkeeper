<?php

require __DIR__ . '/../vendor/autoload.php';

// Load environment variables.
(new Dotenv\Dotenv(__DIR__))->load();

$redirect_uri = 'http://localhost:8888/?redirect=';

if (!isset($_GET['redirect'])) {
    $url = 'https://runkeeper.com/apps/authorize?' . http_build_query([
        'client_id'     => getenv('CLIENT_ID'),
        'response_type' => 'code',
        'redirect_uri'  => $redirect_uri
    ]);

    header("location: {$url}");
    exit;
}

$code = $_GET['code'];
//extract data from the post
//set POST variables
$url = 'https://runkeeper.com/apps/token';


//open connection
$ch = curl_init();

//set the url, number of POST vars, POST data
curl_setopt_array($ch, [
    CURLOPT_URL => $url,
    CURLOPT_POST => true,
    CURLOPT_POSTFIELDS => http_build_query([
        'grant_type'    => 'authorization_code',
        'code'          => $code,
        'client_id'     => getenv('CLIENT_ID'),
        'client_secret' => getenv('CLIENT_SECRET'),
        'redirect_uri'  => $redirect_uri
    ])
]);

curl_exec($ch);
curl_close($ch);

exit;