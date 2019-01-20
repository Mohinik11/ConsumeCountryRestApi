<?php

namespace Yas\Controllers;

class CountryController extends CommonController
{
    /**
     * get Country Details
     *
     * @return Response
     */
    public function getCountryDetails(Array $data)
    {
        $this->validateArg($data);
        if(count($data) > 2) {
            $same = $this->compareCountries($data[1], $data[2]);
            return $this->createResponseCompare($same, $data[2]);
        } else {
            $countryData = json_decode($this->repo->getCountryByName($this->country));
            foreach ($countryData[0]->languages as $key => $value) {
                $countryDetails[$key]['countries'] = $this->fetchCountryNamesByLang($value->iso639_1);
                $countryDetails[$key]['language'] = $value->iso639_1;
            }
            return $this->createResponse($countryDetails);
        }
    }

    /**
     * compare countries by languages
     *
     * @return bool
     */
    private function compareCountries($countryOne, $countryTwo)
    {
        $countryDataOne = json_decode($this->repo->getCountryByName($countryOne));
        $countryDataTwo = json_decode($this->repo->getCountryByName($countryTwo));
        return (count(array_diff(array_column($countryDataOne[0]->languages, 'iso639_1'), array_column($countryDataTwo[0]->languages, 'iso639_1'))) == 0);
    }

    /**
     *  validate input data and set country 
     *  throw exception in case of error
     * 
     */
    private function validateArg($data)
    {
        if(is_array($data)) {
            foreach ($data as $value) {
                if(!is_string($value) || !preg_match('/^[a-zA-Z]{2,}/', $value)) {
                   throw new \InvalidArgumentException("Invalid Input Data", 1);
                }
            }
        }
        $this->country = $data[1];
    }

    /**
     * get Country Details by lang code
     *
     * @return Array
     */
    private function fetchCountryNamesByLang($lang)
    {
        $countries = [];
        $data = json_decode($this->repo->getCountryByLang($lang));
        foreach ($data as $key => $value) {
            $countries[] = $value->name;
        }

        return $countries;
    }

    /**
     * create response in case of two inputs
     *
     * @return String
     */    
    private function createResponse($data)
    {
        $message = '';
        foreach ($data as $key => $countryDetail) {
            $countryLanguageCode = $countryDetail['language'];
            $countryNames = implode(',', array_diff($countryDetail['countries'], [$this->country]));
            $message .= "Country language code: $countryLanguageCode" . "\n";
            $message .= "$this->country speaks same language with these countries: $countryNames" . "\n\n";
        }
        return $message;
    }

    /**
     * create response for single input
     *
     * @return String
     */
    private function createResponseCompare($same = false, $country)
    {
        if($same) {
            $message = "{$this->country} and {$country} speak the same language";
        } else {
            $message = "{$this->country} and {$country} do not speak the same language";
        }
        return $message;
    }
    
    /**
     * compare languages for multiple countries
     *
     * @return Array
     */
    private function compareLanguages($data)
    {
        foreach ($data as $key => $value) {
            $languages[] = array_column($value[0]->languages, 'iso639_1');
        }
        return array_diff($languages);
    }

}
