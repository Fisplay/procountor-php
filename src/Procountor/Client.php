<?php
namespace Procountor;

use GuzzleHttp\Client as GuzzleClient;
use GuzzleHttp\Psr7\Request;



use Procountor\Json\Builder;
use Procountor\Interfaces\AbstractResourceInterface;

class Client {
    private $accessToken;
    private $oauth2Provider = null;
    private $mode = 'prod';
    private $state = null;
    private $loginParameters = [];
    private $guzzleClient;

    private static $urls = [
        'prod' => [
            'urlBase' => 'https://api.procountor.com/procountor.api.v4/api',
            'urlAuthorize' => '/oauth/authz',
            'urlAccessToken' => '/oauth/token',
        ],
        'dev' => [
            'urlBase' => 'https://api-test.procountor.com/procountor.api.v4/api',
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

    private function getRequestAuthHeaders() {
        $headers = [
            'headers' => [
                'Content-Type' => 'application/json',
                'Authorization' => 'Bearer '.$this->accessToken
            ],
            'http_errors' => false,

        ];

        return $headers;
    }

    public function post(string $resourceName, AbstractResourceInterface $resource)
    {
        $params = $this->getRequestAuthHeaders();
        $builder = new Builder();
        $builder->setResource($resource);
        $params['json'] = $builder->getArray();
        $request = $this->guzzleClient->request('POST', $this->getResourceUrl($resourceName), $params);
        $response = json_decode($request->getBody());

        if (!empty($response->error)) {
            $this->error($response);
        }

        if(!empty($response->constraintViolations)) {
            $error = new \stdClass();
            $error->error = $response->constraintViolations[0]->field;
            $error->error_description = $response->constraintViolations[0]->errorCode;
            $this->error($error);
        }
    }

    public function get(string $resourceName) {
        $response = $this->guzzleClient->request('GET', $this->getResourceUrl($resourceName), $this->getRequestAuthHeaders())->getBody();
        return json_decode($response);
    }

    private function getResourceUrl(string $resourceName, $id = null): string
    {
        return sprintf('%s/%s', $this->getBaseUri(), $resourceName);
    }

     private function getAccessTokenByAuthorizationCode(string $code): string
    {

        $post = [
            'code' => $code,
            'client_id' => $this->loginParameters['clientId'],
            'client_secret' => $this->loginParameters['clientSecret'],
            'redirect_uri' => $this->loginParameters['redirectUri'],
        ];
        $url = sprintf(
                '%s?grant_type=authorization_code&',
                $this->getUrlAccessToken()
        ).http_build_query($post);

        $request = $this->guzzleClient->request('POST',
            $url,
            [
                'headers' => [
                    'Content-Type' => 'application/x-www-form-urlencoded',
                ],
                'form_params' => $post
            ]

        );

        $result = json_decode($request->getBody());

        if (!empty($result->error)) {
            $this->error($result);
        }
        return $result->access_token;
    }

    private function error($result) {
        throw new ClientException($result->error_description);

    }

    private function getAuthorizationCode(): string
    {
        $url =  sprintf(
                '%s?response_type=code&client_id=%s&state=%s',
                $this->getUrlAuthorize(),
                $this->loginParameters['clientId'],
                $this->getState()
            );
        $params = [
                'headers' => [
                        'Content-Type' => 'application/x-www-form-urlencoded',
                    ],
                'form_params' => [
                    'response_type' => 'code',
                    'username' => urlencode($this->loginParameters['username']),
                    'password' => urlencode($this->loginParameters['password']),
                    'company' => urlencode($this->loginParameters['company']),
                    'redirect_uri' => $this->loginParameters['redirectUri'],
                ],
                'http_errors' => false,
                'allow_redirects' => [
                    'max'             => 0,        // allow at most 10 redirects.
                    'strict'          => true,      // use "strict" RFC compliant redirects.
                    'referer'         => true,      // add a Referer header
                    'protocols'       => ['http'], // only allow https URLs
                    'track_redirects' => false
                ]
            ];

        $request = $this->guzzleClient->request('POST',
            $url,
            $params
        );

        $result = $request->getBody();
        $headers = $request->getHeaders();
        if (!empty($headers['Location'])) {
            $urlParsed = parse_url($headers['Location'][0]);
            parse_str($urlParsed['query'], $queryParams);
            return $queryParams['code'];
        }

        //If no location header, it must be error
        preg_match('/(\{.*\})/', $result, $match);
        $result = json_decode($match[1]);
        $this->error($result);
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
