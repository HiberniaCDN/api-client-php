<?php

include_once __DIR__ . '/../src/APIClient.php';

$login = 'test.user@example.org';
$password = 'ABC123def';

$client = new \HiberniaCDN\APIClient();
try {
    
    $result = $client->login($login, $password);
    echo 'Auth Token: ' . $result['bearer_token'] . PHP_EOL;

} catch (\HiberniaCDN\APIClient\Exception $x) {
    echo 'API Exception: '
        . '[' . $x->getServerErrorMessage() . ']'
        . '[' . $x->getServerErrorDetails() . ']'
        . PHP_EOL;
}
