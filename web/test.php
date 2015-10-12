<?php

require_once '../vendor/autoload.php';

use GuzzleHttp\Client;
use Seld\JsonLint\JsonParser;

$client = new Client();
$parser = new JsonParser();

$_response = $client->request('GET', 'https://api.nylas.com/messages?in=inbox', [
    'auth' => ['63a63CIENKCy9RTOc3gZXbZRcreSCZ', null],
    'verify' => false,
]);

var_dump(json_decode((string) $_response->getBody()));
