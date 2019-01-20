<?php

use PHPUnit\Framework\TestCase;
use Yas\Controllers\CountryController;
use Yas\Repository\CountryRepository;
use ApiHandler\ApiService;

class CountryControllerTest extends TestCase
{

    /**
     * CountryRepository
     *
     * @type  CountryRepository
     */
    protected $repo;

    /**
     * CountryController
     *
     * @type  ExportDate
     */
    protected $ctrl;

    /**
     * set up test environmemt
     */
    public function setUp()
    {
    	$_ENV["API_ENDPOINT"] = "test";
        $this->repo = $this->getMockBuilder('Yas\Repository\CountryRepository')
            ->setConstructorArgs([new ApiService])
            ->getMock();
        $this->ctrl = new CountryController($this->repo);
    }

    /**
     * test for constructor
     */
    public function testCanBeInstantiated()
    {
        $this->assertInstanceOf(
            CountryController::class,
            new CountryController($this->repo)
        );
    }

    /**
     * @dataProvider additionProvider
     */
    public function testGetCountryDetailsException($file, $name)
    {
        $this->expectException(InvalidArgumentException::class);
        $this->ctrl->getCountryDetails([$file, $name]);
    }

    public function additionProvider()
    {
        return [
            ['test', 123],
            ['test', '!#$test']
        ];
    }

    /**
     * test for single input
     */
    public function testGetCountryDetailsOneParameter()
    {
        $response = '[{"name": "Spain","languages": [{"iso639_1": "es","iso639_2": "spa","name": "Spanish","nativeName": "Español"}]}]';
        $responseLang = '[{"name": "Spain","languages": [{"iso639_1": "es","iso639_2": "spa","name": "Spanish","nativeName": "Español"}]},{"name": "Mexico","languages": [{"iso639_1": "es","iso639_2": "spa","name": "Spanish","nativeName": "Español"}]}]';
        $this->repo->expects($this->any())->method('getCountryByName')->willReturn($response);
        $this->repo->expects($this->any())->method('getCountryByLang')->willReturn($responseLang);
        $this->assertContains('Country language code: es', $this->ctrl->getCountryDetails(['test', 'Spain']));
    }

    /**
     * test for two inputs with same language
     */
    public function testGetCountryDetailsTwoParametersSameLang()
    {
        $response = '[{"name": "Spain","languages": [{"iso639_1": "es","iso639_2": "spa","name": "Spanish","nativeName": "Español"}]}]';
        $responseLang = '[{"name": "Spain","languages": [{"iso639_1": "es","iso639_2": "spa","name": "Spanish","nativeName": "Español"}]},{"name": "Mexico","languages": [{"iso639_1": "es","iso639_2": "spa","name": "Spanish","nativeName": "Español"}]}]';
        $this->repo->expects($this->any())->method('getCountryByName')->willReturn($response);
        $this->repo->expects($this->any())->method('getCountryByLang')->willReturn($responseLang);
        $this->assertContains('Spain and Mexico speak the same language', $this->ctrl->getCountryDetails(['test', 'Spain', 'Mexico']));
    }

    /**
     * test for two inputs with different language
     */
    public function testGetCountryDetailsTwoParametersDiffLang()
    {
        $response = '[{"name": "Spain","languages": [{"iso639_1": "es","iso639_2": "spa","name": "Spanish","nativeName": "Español"}]}]';
        $responseTwo = '[{"name": "India","languages":[{"iso639_1":"hi","iso639_2":"hin","name":"Hindi","nativeName":"हिन्दी"},{"iso639_1":"en","iso639_2":"eng","name":"English","nativeName":"English"}]}]';

        $this->repo->expects($this->any())->method('getCountryByName')->willReturnOnConsecutiveCalls($response, $responseTwo);
        $this->assertContains('Spain and India do not speak the same language', $this->ctrl->getCountryDetails(['test', 'Spain', 'India']));
    }
}