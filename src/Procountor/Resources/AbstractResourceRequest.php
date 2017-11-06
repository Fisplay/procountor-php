<?php
namespace Procountor\Resources;

use Procountor\Client;

class AbstractResourceRequest {
    protected $client;


    public function __construct(Client $client) {
        $this->client = $client;
    }

    public function post(string $resource, $postData)
    {
        $ch = $this->getNewCurlRequest([
            CURLOPT_CUSTOMREQUEST => 'POST',
            CURLOPT_URL => sprintf(
                '%s?grant_type=authorization_code&',
                $client->getUrlAccessToken()
            )
        ]);
        $ch->exec());
    }

    public function get(int $id) {

    }

}
