<?php

namespace Yas\Controllers;

class CountryController extends CommonController
{
    /**
     * get Country list
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
                $countryDetails[$key]['countries'] = $this->fetchNames($value->iso639_1);
                $countryDetails[$key]['language'] = $value->iso639_1;
            }
            return $this->createResponse($countryDetails);
        }
    }

    private function compareCountries($countryOne, $countryTwo)
    {
        $countryDataOne = json_decode($this->repo->getCountryByName($countryOne));
        $countryDataTwo = json_decode($this->repo->getCountryByName($countryTwo));
        return (count(array_diff(array_column($countryDataOne[0]->languages, 'iso639_1'), array_column($countryDataTwo[0]->languages, 'iso639_1'))) == 0);
    }

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

    private function fetchNames($lang)
    {
        $countries = [];
        $data = json_decode($this->repo->getCountryByLang($lang));
        foreach ($data as $key => $value) {
            $countries[] = $value->name;
        }

        return $countries;
    }

    private function createResponse($data)
    {
        foreach ($data as $key => $countryDetail) {
            $countryLanguageCode = $countryDetail['language'];
            $countryNames = implode(',', array_diff($countryDetail['countries'], [$this->country]));
            $message = "Country language code: $countryLanguageCode" . "\n";
            $message .= "$this->country speaks same language with these countries: $countryNames" . "\n\n";
        }
        return $message;
    }

    private function compareLanguages($data)
    {
        foreach ($data as $key => $value) {
            $languages[] = array_column($value[0]->languages, 'iso639_1');
        }
        return array_diff($languages);
    }

    private function createResponseCompare($same = false, $country)
    {
        if($same) {
            $message = "{$this->country} and {$country} speak the same language";
        } else {
            $message = "{$this->country} and {$country} do not speak the same language";
        }
        return $message;
    }
}
