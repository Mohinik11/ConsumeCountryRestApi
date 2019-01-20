<?php

namespace ApiHandler;

use ApiHandler\ApiInterface;
use GuzzleHttp\Exception\ClientException;
/**
 * A simple implementation of ApiService.
 *
 * @author Mohini Kamboj <mohinikamboj11@gmail.com>
 *
 */
class ApiService implements ApiInterface
{
    /**
     * @var client
     */
    protected $client;

    /**
     * Get HttpClient
     *
     * @return HttpClient
     */
    protected function getHttpClient() 
    {
        if (!isset($this->client)){
            try {
                $this->client = new \GuzzleHttp\Client();
            } catch (\Throwable $e) {
                error_log($e->getMessage());
            }
        }

        return $this->client;
    }

    /**
     * @desc    Do a GET request
     *
     * @param   string $url   path to service
     * @return  mixed
     */
    public function get($url)
    {
        try {
            $result = $this->getHttpClient()->get($url);
            return $result->getBody()->getContents();
        } catch (ClientException $e) {
            $responseBody = $e->getResponse()->getBody(true);
            return json_decode($responseBody, true);
        }
    }

}
