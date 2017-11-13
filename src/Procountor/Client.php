<?php
namespace Procountor;

use GuzzleHttp\Client as GuzzleClient;
use GuzzleHttp\Psr7\Request;

class Client {
    private $accessToken;
    private $oauth2Provider = null;
    private $mode = 'prod';
    private $state = null;
    private $loginParameters = [];
    private $guzzleClient;

    private static $urls = [
        'prod' => [
            'urlBase' => '',
            'urlAuthorize' => '',
            'urlAccessToken' => '',
        ],
        'dev' => [
            'urlBase' => 'https://api-test.procountor.com/api',
            'urlAuthorize' => '/oauth/authz',
            'urlAccessToken' => '/oauth/token',
        ],
    ];

    public function __construct()
    {
        $this->guzzleClient = new GuzzleClient(['base_uri' => $this->getBaseUri()]);
        $this->state = rand().strtotime('now');
    }

    public function login(
        string $clientId,
        string $clientSecret,
        string $redirectUri,
        string $username,
        string $password,
        int $company
    ): self
    {

        $this->loginParameters = [
            'clientId' => $clientId,
            'clientSecret' => $clientSecret,
            'redirectUri' => $redirectUri,
            'username' => $username,
            'password' => $password,
            'company' => $company,
        ];

        $code = $this->getAuthorizationCode();
        $this->accessToken = $this->getAccessTokenByAuthorizationCode($code);
        return $this;
    }

    private function getNewCurlRequest(array $requestOptions) {
        $ch = curl_init();

        $options =  $requestOptions + [
            CURLOPT_HEADER => 0,
            CURLOPT_HTTPHEADER => ['Content-Type: application/x-www-form-urlencoded'],
            CURLOPT_RETURNTRANSFER => 1,
            //CURLOPT_VERBOSE => 1,
        ];

        curl_setopt_array($ch, $options);

        return $ch;
    }

    private function getRequestAuthHeaders() {
        $headers = [
            'headers' => [
                'Content-Type' => 'application/json',
                'Authorization' => 'Bearer '.$this->accessToken
            ]
        ];

        return $headers;
    }

    public function post(string $resourceName, Interface $resource)
    {
        $params = $this->getRequestAuthHeaders();
        $builder = new Builder();
        $builder->setResource($object);
        $params['body'] = $builder->getJson();

        $request = $this->guzzleClient->request('POST', $this->getResourceUrl($resourceName), $params);
    }

    public function get(string $resourceName) {
        $response = $this->guzzleClient->request('GET', $this->getResourceUrl($resourceName), $this->getRequestAuthHeaders())->getBody();
        return json_decode($response);
    }

    private function getResourceUrl(string $resourceName, $id = null): string
    {
        return sprintf('%s/%s', $this->getBaseUri(), $resourceName);
    }

    public function createNewRequest(array $data) {
        $ch = $this->getNewCurlRequest([

        ]);

        return $ch;
    }

    private function getAccessTokenByAuthorizationCode(string $code): string
    {
        $post = [
            'code' => $code,
            'client_id' => $this->loginParameters['clientId'],
            'client_secret' => $this->loginParameters['clientSecret'],
            'redirect_uri' => $this->loginParameters['redirectUri'],
        ];

        $options = [
            CURLOPT_POST => 1,
            CURLOPT_URL => sprintf(
                '%s?grant_type=authorization_code&',
                $this->getUrlAccessToken()
            ).http_build_query($post),
            CURLOPT_POSTFIELDS => http_build_query($post),
        ];

        $ch = $this->getNewCurlRequest($options);



        $result = json_decode(curl_exec($ch));
        return $result->access_token;
    }

    private function getAuthorizationCode(): string
    {


        $post = [
            'username' => $this->loginParameters['username'],
            'password' => $this->loginParameters['password'],
            'company' => $this->loginParameters['company'],
            'redirect_uri' => $this->loginParameters['redirectUri'],
            'response_type' => 'code',
        ];

        $options = [
            CURLOPT_POST => 1,
            CURLOPT_HEADER => 1,
            CURLOPT_URL => sprintf(
                '%s?response_type=code&client_id=%s&state=%s',
                $this->getUrlAuthorize(),
                $this->loginParameters['clientId'],
                $this->getState()
            ),
            CURLOPT_POSTFIELDS => http_build_query($post),
        ];

        $ch = $this->getNewCurlRequest($options);


//        curl_setopt_array($ch, $options);

        $result = curl_exec($ch);

        if(preg_match('/Location: .*?code=(.*)&.*\n/', $result, $code)) {
            return $code[1];
        }
    }

    public function setModeDev(): self
    {
        $this->mode = 'dev';
        $this->guzzleClient = new GuzzleClient(['base_uri' => $this->getBaseUri()]);

        return $this;
    }

    private function getUrlAuthorize(): string
    {
        return $this->getBaseUri().self::$urls[$this->mode]['urlAuthorize'];
    }

    private function getUrlAccessToken(): string
    {
        return $this->getBaseUri().self::$urls[$this->mode]['urlAccessToken'];
    }

    private function getState(): string
    {
        return $this->state;
    }

    private function getBaseUri(): string
    {
        return self::$urls[$this->mode]['urlBase'];
    }

}
