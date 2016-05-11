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
    protected $loggedInUser = [];

    public function __construct($apiURL = 'https://portal.hiberniacdn.com/api')
    {
        $this->httpClient= new HTTPClient($apiURL);
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

    public function getUser($userId, $authToken = null)
    {
        return $this->httpClient->get('/users/' . $userId, $this->getAuthorizationToken($authToken));
    }

    public function getAccountSites($accountId, $authToken = null)
    {
        return $this->httpClient->get('/accounts/' . $accountId . '/sites', $this->getAuthorizationToken($authToken));
    }

    public function updateSite($siteId, $data, $authToken = null)
    {
        return $this->httpClient->put('/sites/' . $siteId, $data, $this->getAuthorizationToken($authToken = null));
    }

}
