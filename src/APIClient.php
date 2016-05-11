<?php
/**
 * API Client wrapper object to expose API REST calls as Object methods
 *
 * Examples:
 *      /api/login will be exposed as $this->login($email, $password)
 *      /api/accounts/{AccountID}/sites will be exposed as $this->getAccountSites($accountId, $authToken)
 */
namespace HiberniaCDN;

include_once 'Exception.php';
include_once 'HTTPClient.php';

use HiberniaCDN\APIClient\HTTPClient;


class APIClient
{
    protected $httpClient;
    protected $apiKey = '';
    protected $loggedInUser = [];

    public function __construct($apiKey = '', $apiURL = 'https://portal.hiberniacdn.com/api')
    {
        $this->httpClient= new HTTPClient($apiURL);
        $this->apiKey = $apiKey;
    }

    /**
     * Gets URI to send request to. Appends api_key if Client contains API key
     * @param $uri
     * @return string
     */
    protected function getURI($uri)
    {
        $uri .= !empty($this->apiKey) ? '?api_key=' . $this->apiKey : '';
        return $uri;
    }


    /**
     * @return HTTPClient
     */
    public function getHttpClient()
    {
        return $this->httpClient;
    }

    public function getAuthorizationToken($authToken = null)
    {
        if (empty($authToken)
            && !empty($this->loggedInUser)
            && !empty($this->loggedInUser['token'])
        ) {
            return $this->loggedInUser['token'];
        }
        return $authToken;
    }

    public function login($email, $password)
    {
        $data = $this->httpClient->post('/login', [
            'email' => $email,
            'password' => $password
        ]);
        if (!empty($data['bearer_token'])) {
            $this->loggedInUser = [
                'id' => $data['id'],
                'token' => $data['bearer_token'],
                'account' => [
                    'id' => $data['user']['account']['id']
                ]
            ];
        }
        return $data;
    }

    /**
     * Creates new account
     * Parameters list is similar to Account Update action: http://portal.hiberniacdn.com/api/doc/#put--api-accounts-{id}.{_format}
     *
     * @param string $name Account Name (must be unique across the system)
     * @param array $parameters Account creation parameters
     * @param null $authToken
     * @return mixed|null
     */
    public function createAccount($name, $parameters = [], $authToken = null)
    {
        $parameters['name'] = $name;
        return $this->httpClient->post(
            $this->getURI('/accounts'),
            $parameters,
            $this->getAuthorizationToken($authToken)
        );
    }

    /**
     * Creates a new user for a given account
     * Users parameters list can be found at: http://portal.hiberniacdn.com/api/doc/#post--api-accounts-{id}-users.{_format}
     *
     * @param int $accountId
     * @param array $parameters
     * @param null $authToken
     * @return mixed|null
     */
    public function createUserForAccount($accountId, $parameters = [], $authToken = null)
    {
        return $this->httpClient->post(
            $this->getURI('/accounts/' . $accountId . '/users'),
            $parameters,
            $this->getAuthorizationToken($authToken)
        );
    }

    /**
     * Creates a new Bucket
     *
     * @param $accountId
     * @param $parameters
     * @param null $authToken
     * @return mixed|null
     */
    public function createBucket($accountId, $parameters, $authToken = null)
    {
        return $this->httpClient->post(
            $this->getURI('/accounts/' . $accountId . '/credits-transactions'),
            $parameters,
            $this->getAuthorizationToken($authToken)
        );
    }

}
