<?php
namespace Procountor;

use GuzzleHttp\Client as GuzzleClient;
use GuzzleHttp\Psr7\Request;



use Procountor\Json\Builder;
use Procountor\Interfaces\AbstractResourceInterface;
use Procountor\Response\Factory as ResponseFactory;
use Procountor\Interfaces\LoggerInterface;

class Client {
    private $accessToken;
    private $oauth2Provider = null;
    private $mode = 'prod';
    private $state = null;
    private $loginParameters = [];
    private $guzzleClient;
    private $debug = false;
    private $logger = null;

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

    public function __construct(LoggerInterface $logger)
    {
        $this->guzzleClient = new GuzzleClient(['base_uri' => $this->getBaseUri()]);
        $this->state = rand().strtotime('now');
        $this->logger = $logger;
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
            'Content-Type' => 'application/json',
            'Authorization' => 'Bearer '.$this->accessToken
        ];

        return $headers;
    }

    public function post(string $resourceName, AbstractResourceInterface $resource)
    {
        return $this->createRequest('POST', $resourceName, $resource);
    }

    public function put(string $resourceName, AbstractResourceInterface $resource)
    {
        return $this->createRequest('PUT', $resourceName, $resource);
    }

    public function request(string $url, string $type, string $headers, string $json)
    {
        $params = [
            'headers' => json_decode($headers, true),
            'json' => json_decode($json, true),
            'http_errors' => false,
            'debug' => $this->debug
        ];
        $request = $this->guzzleClient->request($type, $url, $params);
        
        $response = json_decode($request->getBody());
        
        $this->logger->log(
            $url,
            $type,
            $headers,
            $json,
            $request->getStatusCode(),
            json_encode($request->getHeaders()),
            json_encode($response)
        );      
        
        if (!empty($response->error)) {
            $this->error($response);
        }

        if(!empty($response->constraintViolations)) {
            $error = new \stdClass();
            $error->error = $response->constraintViolations[0]->field;
            $error->error_description = $response->constraintViolations[0]->errorCode;
            $this->error($error);
        }
        
        return $response;
    }
    
    private function createRequest($type, string $resourceName, AbstractResourceInterface $resource = null)
    {
        $requestBody = [];
        if ($resource) {
            $builder = new Builder();
            $builder->setResource($resource);
            $requestBody = $builder->getArray();
        }
        return $this->request($this->getResourceUrl($resourceName), $type, $this->getRequestAuthHeaders(), $requestBody);
    }

    public function get(string $resourceName) {
        //$response = $this->guzzleClient->request('GET', $this->getResourceUrl($resourceName), $this->getRequestAuthHeaders())->getBody();
        return $this->createRequest('GET', $resourceName);
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
                'form_params' => $post,
                'debug' => $this->debug
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
                ],
                'debug' => $this->debug
            ];


        $request = $this->guzzleClient->request('POST',
            $url,
            $params
        );

        if ($this->debug) {
            echo "---------------------------------\n\n\nForm_params: ";
            var_dump(http_build_query($params['form_params']));
            echo "\n";
        }


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

    public function setDebug(bool $debug) {
        $this->debug = $debug;
    }

}
