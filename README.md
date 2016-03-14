## HiberniaCDN API Client (PHP)

### Installing via [https://getcomposer.org](Composer)

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
    $response = $client->post(
        '/login',
        ['email' => 'my-mail@example.org', 'password' => 'My Secret Password']
    );
} catch (\HiberniaCDN\APIClient\Exception $x) {
  echo 'Error!' . PHP_EOL;
  echo ' > Status: ' . $x->getApiResponseStatus() . PHP_EOL;
  echo ' > Text: ' . $x->getServerErrorMessage() . PHP_EOL;
  echo ' > Details: ' . $x->getServerErrorDetails() . PHP_EOL;
  echo ' > Raw Response: ' . $x->getApiResponse() . PHP_EOL;
}

```