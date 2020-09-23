<?php
namespace Procountor;

use GuzzleHttp\Client as GuzzleClient;
use Procountor\Interfaces\AbstractResourceInterface;
use Procountor\Interfaces\LoggerInterface;
use Procountor\Json\Builder;

class Client 
{
    private $accessToken;
    private $mode = 'prod';
    private $state = null;
    private $loginParameters = [];
    private $guzzleClient;
    private $debug = false;
    private $logger = null;

    private static $urls = [
        'prod' => [
            'urlBase' => 'https://api.procountor.com/v2006/api',
            'urlAuthorize' => '/oauth/authz',
            'urlAccessToken' => '/oauth/token',
        ],
        'dev' => [
            'urlBase' => 'https://api-test.procountor.com/v2006/api',
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
    ): self {
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

    private function getRequestAuthHeaders()
    {
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

    public function request(string $url, string $type, string $headers, string $data)
    {
        $params = [
            'headers' => json_decode($headers, true),
            'http_errors' => false,
            'debug' => $this->debug,
            'allow_redirects' => [
                'max'             => 0,        // allow at most 10 redirects.
                'strict'          => true,      // use "strict" RFC compliant redirects.
                'referer'         => true,      // add a Referer header
                'protocols'       => ['http'], // only allow https URLs
                'track_redirects' => false
            ],
        ];

        if ($params['headers']['Content-Type']=='application/json') {
            $params['json'] = json_decode($data, true);
        } else {
            $params['form_params'] = json_decode($data, true);
        }

        $request = $this->guzzleClient->request($type, $url, $params);

        $this->logger->log(
            $url,
            $type,
            $headers,
            $data,
            $request->getStatusCode(),
            json_encode($request->getHeaders()),
            json_encode($request->getBody())
        );


        return $request;
    }

    private function createRequest($type, string $resourceName, AbstractResourceInterface $resource = null)
    {
        $requestBody = [];
        if ($resource) {
            $builder = new Builder();
            $builder->setResource($resource);
            $requestBody = $builder->getArray();
            //echo json_encode($requestBody);
        }

        $request = $this->request($this->getResourceUrl($resourceName), $type, json_encode($this->getRequestAuthHeaders()), json_encode($requestBody));
        /*if($request->getStatusCode()!=200) {
            //var_dump($requestBody, $request->getStatusCode());
            $error = new \stdClass();
            $error->error = $request->getStatusCode();
            $error->error_description = $request->getStatusCode();
            $this->error($error);
        }*/
        $response = json_decode($request->getBody());

        if (!empty($response->errors)) {
            $this->error($response);
        }

        if(!empty($response->constraintViolations)) {
            $error = new \stdClass();
            $error->errors = [['message' =>  $response->constraintViolations[0]->errorCode]];
            $this->error($error);
        }

        return $response;
    }

    public function get(string $resourceName)
    {
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

        $headers = [
            'Content-Type' => 'application/x-www-form-urlencoded',
        ];

        $request = $this->request($url, 'POST', json_encode($headers), json_encode($post));
        $result = json_decode($request->getBody());

        if (!empty($result->errors)) {
            $this->error($result);
        }
        return $result->access_token;
    }

    private function error($result)
    {
        throw new ClientException($result->errors[0]->message);
    }

    private function getAuthorizationCode(): string
    {
        $url =  sprintf(
                '%s?response_type=code&client_id=%s&state=%s',
                $this->getUrlAuthorize(),
                $this->loginParameters['clientId'],
                $this->getState()
            );
        $headers = [
            'Content-Type' => 'application/x-www-form-urlencoded',
        ];

        $data = [
            'response_type' => 'code',
            'username' => urlencode($this->loginParameters['username']),
            'password' => urlencode($this->loginParameters['password']),
            'company' => urlencode($this->loginParameters['company']),
            'redirect_uri' => $this->loginParameters['redirectUri'],
        ];

        $request = $this->request($url, 'POST', json_encode($headers), json_encode($data));


        $result = $request->getBody();
        $headers = $request->getHeaders();


        if ($this->debug) {
            echo "---------------------------------\n\n\nForm_params: ";
            var_dump(http_build_query($data));
            echo "\n";
        }



        if (!empty($headers['Location'])) {
            $urlParsed = parse_url($headers['Location'][0]);
            parse_str($urlParsed['query'], $queryParams);
            return $queryParams['code'];
        }

        //If no location header, it must be error
        preg_match('/(\{.*\})/', $result, $match);
        $result = json_decode($match[1]);
        $this->error($result ?: (object)['errors' => [['message' => 'API ERROR']]]);
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

    public function setDebug(bool $debug)
    {
        $this->debug = $debug;
    }

}
