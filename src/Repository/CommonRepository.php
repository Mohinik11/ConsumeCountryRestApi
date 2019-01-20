<?php

namespace Yas\Repository;

use ApiHandler\ApiService;

class CommonRepository
{
    protected $apiService;
    protected $baseUrl;

    public function __construct(ApiService $apiService) {
        $this->apiService = $apiService;
        $this->baseUrl = $_ENV['API_ENDPOINT'];
    }

}
