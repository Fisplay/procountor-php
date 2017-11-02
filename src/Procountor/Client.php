<?php
namespace Procountor;

use \League\OAuth2\Client\Provider\GenericProvider;
use \League\OAuth2\Client\Provider\Exception\IdentityProviderException;

class Client {
    private $accessToken;
    private $oauth2Provider = null;
    private $mode = 'prod';

    private $urls = [
        'prod' => [
            'urlAuthorize' => '',
            'urlAccessToken' => '',
        ],
        'dev' => [
            'urlAuthorize' => 'https://api-test.procountor.com/api/oauth/authz?response_type=code&client_id=%s&state=%s',
            'urlAccessToken' => 'https://api-test.procountor.com/api/oauth/token?grant_type=authorization_code',
        ],
    ];

    public function __construct()
    {

    }

    public function login(
        string $clientId,
        string $clientSecret,
        string $redirectUri,
        string $username,
        string $password,
        int $company,
    ): self
    {
        $this->oauth2Provider= new GenericProvider([
            'clientId'                => $clientId,    // The client ID assigned to you by the provider
            'clientSecret'            => $clientSecret,   // The client password assigned to you by the provider
            'redirectUri'             => $redirectUri,
            'urlAuthorize'            => $this->getUrlAuthorize($clientId, $this->getRandomState()),
            'urlAccessToken'          => $this->getUrlAccessToken(),
        ]);

        try {

            // Try to get an access token using the resource owner password credentials grant.
            $this->accessToken = $provider->getAccessToken('password', [
                'username' => $username,
                'password' => $password,
                'company' => $company,
            ]);

        } catch (IdentityProviderException $e) {

            // Failed to get the access token
            exit($e->getMessage());

        }
        var_dump($this);
        return $this;
    }

    public function setModeDev(): self
    {
        $this->mode = 'dev';
        return $this;
    }

    private function getUrlAuthorize($clientId, $state): string
    {
        return sprintf(self::$urls[$this->mode]['urlAuthorize'], $clientId, $state);
    }

    private function getUrlAccessToken(): string
    {
        return self::$urls[$this->mode]['urlAccessToken'];
    }

    private function getRandomState(): string
    {
        return 'adf';
    }


}
