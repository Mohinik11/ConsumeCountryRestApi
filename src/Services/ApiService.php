<?php

namespace ApiHandler;

use ApiHandler\ApiInterface;
/**
 * A simple implementation of ApiService.
 *
 * @author Mohini Kamboj <mohinikamboj11@gmail.com>
 *
 */
class ApiService implements ApiInterface
{
    /**
     * @var ContainerInterface
     */
    protected $client;

    /**
     * {@inheritdoc}
     */
    // public function __construct()
    // {
    //     $this->getHttpClient();
    // }


    /**
     * Get M3HttpClient
     *
     * @return M3HttpClient
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
     * @desc    Do a GET request with cURL
     *
     * @param   string $url   path to service
     * @return  mixed
     */
    public function get($url)
    {
        try {
            $options = array(
                CURLOPT_SSL_VERIFYPEER => false,
                CURLOPT_RETURNTRANSFER => true,
            );

            // $request = $this->getHttpClient()->get($url, null, null, $options);
            // $result = $this->getHttpClient()->send($request);

            // return $result->json();
            return '[{"name":"Spain","topLevelDomain":[".es"],"alpha2Code":"ES","alpha3Code":"ESP","callingCodes":["34"],"capital":"Madrid","altSpellings":["ES","Kingdom of Spain","Reino de España"],"region":"Europe","subregion":"Southern Europe","population":46438422,"latlng":[40.0,-4.0],"demonym":"Spanish","area":505992.0,"gini":34.7,"timezones":["UTC","UTC+01:00"],"borders":["AND","FRA","GIB","PRT","MAR"],"nativeName":"España","numericCode":"724","currencies":[{"code":"EUR","name":"Euro","symbol":"€"}],"languages":[{"iso639_1":"es","iso639_2":"spa","name":"Spanish","nativeName":"Español"}],"translations":{"de":"Spanien","es":"España","fr":"Espagne","ja":"スペイン","it":"Spagna","br":"Espanha","pt":"Espanha","nl":"Spanje","hr":"Španjolska","fa":"اسپانیا"},"flag":"https://restcountries.eu/data/esp.svg","regionalBlocs":[{"acronym":"EU","name":"European Union","otherAcronyms":[],"otherNames":[]}],"cioc":"ESP"}]';
        } catch (BadResponseException $e) {
            $responseBody = $e->getResponse()->getBody(true);
            return json_decode($responseBody, true);
        }
    }


    /**
     * @desc    Do a POST request with cURL
     *
     * @param   string $url   path to service
     * @param   string  $fields  data as json
     * @return  array | object
     */
    public function post($url, $fields, $contentType = 'json') 
    {
        try {
            $contentType = $contentType == 'xml' ? 'application/xml' : 'application/json';
            $headers = array(
                'Content-Type' => $contentType,
                'Content-Length' => strlen($fields)
            );

            $options = array(
                CURLOPT_CUSTOMREQUEST  => "POST",
                CURLOPT_POSTFIELDS     => $fields,
                CURLOPT_RETURNTRANSFER => true,
                CURLOPT_HTTPHEADER     => $headers,
            );

            $request = $this->getHttpClient()->post($url, $headers, $fields, $options);
            $result = $this->getHttpClient()->send($request);

            return $result->json();
        } catch (BadResponseException $e) {
            $responseBody = $e->getResponse()->getBody(true);
            return json_decode($responseBody, true);
        }
    }

}
