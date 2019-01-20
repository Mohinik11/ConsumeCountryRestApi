<?php

namespace Yas\Repository;

use Yas\Repository\CommonRepository;

class CountryRepository extends CommonRepository
{
    /**
     * get Country Details by name
     *
     * @return mixed
     */
    public function getCountryByName(String $countryName)
    {
    	$url = $this->baseUrl . "name/$countryName?fullText=true";
        return $this->validateData($this->apiService->get($url));
    }

    /**
     * get Country Details by language code
     *
     * @return mixed
     */
    public function getCountryByLang(String $langCode)
    {
        $url = $this->baseUrl . "lang/$langCode?fullText=true";
        return $this->validateData($this->apiService->get($url));
    }

    /**
     * validate json
     *
     * @return bool
     */
    private function validJson($value='')
    {
        $json_array = json_decode( $value , true );
        return !($json_array == NULL); 
    }

    /**
     * validate returned data and throw exception in case of error
     *
     * @return mixed
     */
    private function validateData($result)
    {
        if(!is_array($result) && $this->validJson($result)) {
            return $result;
        } else {
            throw new \Exception('Data Not Found');
        }
    }

}
