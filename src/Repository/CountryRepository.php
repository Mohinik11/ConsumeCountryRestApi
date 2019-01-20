<?php

namespace Yas\Repository;

use Yas\Repository\CommonRepository;

class CountryRepository extends CommonRepository
{
    /**
     * get Country list
     *
     * @return Response
     */
    public function getCountryByName(String $countryName)
    {
    	$url = $this->baseUrl . "name/$countryName?fullText=true";
        return $this->apiService->get($url);
    }

    public function getCountryByLang(String $langCode)
    {
        $url = $this->baseUrl . "lang/$langCode?fullText=true";
        //return $this->apiService->get($url);

        return '[{"name":"Fiji","topLevelDomain":[".fj"],"alpha2Code":"FJ","alpha3Code":"FJI","callingCodes":["679"],"capital":"Suva","altSpellings":["FJ","Viti","Republic of Fiji","Matanitu ko Viti","Fijī Gaṇarājya"],"region":"Oceania","subregion":"Melanesia","population":867000,"latlng":[-18.0,175.0],"demonym":"Fijian","area":18272.0,"gini":42.8,"timezones":["UTC+12:00"],"borders":[],"nativeName":"Fiji","numericCode":"242","currencies":[{"code":"FJD","name":"Fijian dollar","symbol":"$"}],"languages":[{"iso639_1":"en","iso639_2":"eng","name":"English","nativeName":"English"},{"iso639_1":"fj","iso639_2":"fij","name":"Fijian","nativeName":"vosa Vakaviti"},{"iso639_1":"hi","iso639_2":"hin","name":"Hindi","nativeName":"हिन्दी"},{"iso639_1":"ur","iso639_2":"urd","name":"Urdu","nativeName":"اردو"}],"translations":{"de":"Fidschi","es":"Fiyi","fr":"Fidji","ja":"フィジー","it":"Figi","br":"Fiji","pt":"Fiji","nl":"Fiji","hr":"Fiđi","fa":"فیجی"},"flag":"https://restcountries.eu/data/fji.svg","regionalBlocs":[],"cioc":"FIJ"},{"name":"India","topLevelDomain":[".in"],"alpha2Code":"IN","alpha3Code":"IND","callingCodes":["91"],"capital":"New Delhi","altSpellings":["IN","Bhārat","Republic of India","Bharat Ganrajya"],"region":"Asia","subregion":"Southern Asia","population":1295210000,"latlng":[20.0,77.0],"demonym":"Indian","area":3287590.0,"gini":33.4,"timezones":["UTC+05:30"],"borders":["AFG","BGD","BTN","MMR","CHN","NPL","PAK","LKA"],"nativeName":"भारत","numericCode":"356","currencies":[{"code":"INR","name":"Indian rupee","symbol":"₹"}],"languages":[{"iso639_1":"hi","iso639_2":"hin","name":"Hindi","nativeName":"हिन्दी"},{"iso639_1":"en","iso639_2":"eng","name":"English","nativeName":"English"}],"translations":{"de":"Indien","es":"India","fr":"Inde","ja":"インド","it":"India","br":"Índia","pt":"Índia","nl":"India","hr":"Indija","fa":"هند"},"flag":"https://restcountries.eu/data/ind.svg","regionalBlocs":[{"acronym":"SAARC","name":"South Asian Association for Regional Cooperation","otherAcronyms":[],"otherNames":[]}],"cioc":"IND"}]';
    }

}
