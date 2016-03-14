## HiberniaCDN API Client (PHP)

### Installing using composer

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
Run
```
$ php composer.phar install
```

In PHP you should include vendor/autoload.php

``` php
include_once __DIR__ . '/vendor/autoload.php';
```