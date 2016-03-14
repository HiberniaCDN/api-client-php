## HiberniaCDN API Client (PHP)


### You can simply clone it from GitHub
```
$ git clone git@github.com:HiberniaCDN/api-client-php.git
```

Usage example

``` php
# Include necessary files
include_once __DIR__ . '/src/Exception.php';
include_once __DIR__ . '/src/HTTPClient.php';

# Create a client
$client = new \HiberniaCDN\APIClient\HTTPClient();


try {

    # Try to log in
    $response = $client->post(
        '/login',
        ['email' => 'my-mail@example.org', 'password' => 'My Secret Password']
    );

    # Getting authorization token from response
    $authToken = $response['bearer_token'];

    # Request Account's sites list
    $sites = $client->get(
        '/accounts/' . $response['user']['account']['id'] . '/sites',
        $authToken
    );

    # Output
    echo sizeof($sites) . ' sites found' . PHP_EOL;

} catch (\HiberniaCDN\APIClient\Exception $x) {
  echo 'Error!' . PHP_EOL;
  echo ' > Status: ' . $x->getApiResponseStatus() . PHP_EOL;
  echo ' > Text: ' . $x->getServerErrorMessage() . PHP_EOL;
  echo ' > Details: ' . $x->getServerErrorDetails() . PHP_EOL;
  echo ' > Raw Response: ' . $x->getApiResponse() . PHP_EOL;
}

```

### You can install it via [Composer](https://getcomposer.org)

Create composer.json like following
```
{
    "require": {
        "HiberniaCDN/api-client-php": "dev-master"
    },
    "repositories": [
        {
            "type": "vcs",
            "url": "git@github.com:HiberniaCDN/api-client-php.git"
        }
    ]
}
```
Run composer to install
```
$ php composer.phar install
```

Usage example

``` php
# Include AutoLoader
include_once __DIR__ . '/vendor/autoload.php';

# Create a client
$client = new \HiberniaCDN\APIClient\HTTPClient();

# Try to log in
try {

    # Try to log in
    $response = $client->post(
        '/login',
        ['email' => 'my-mail@example.org', 'password' => 'My Secret Password']
    );

    # Getting authorization token from response
    $authToken = $response['bearer_token'];

    # Request Account's sites list
    $sites = $client->get(
        '/accounts/' . $response['user']['account']['id'] . '/sites',
        $authToken
    );

    # Output
    echo sizeof($sites) . ' sites found' . PHP_EOL;
    
} catch (\HiberniaCDN\APIClient\Exception $x) {
  echo 'Error!' . PHP_EOL;
  echo ' > Status: ' . $x->getApiResponseStatus() . PHP_EOL;
  echo ' > Text: ' . $x->getServerErrorMessage() . PHP_EOL;
  echo ' > Details: ' . $x->getServerErrorDetails() . PHP_EOL;
  echo ' > Raw Response: ' . $x->getApiResponse() . PHP_EOL;
}

```