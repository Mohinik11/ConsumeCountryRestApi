<?php

namespace Yas\Controllers;

use Yas\Repository\CommonRepository;

class CommonController
{
    protected $repo;

    public function __construct(CommonRepository $repo) {
    	$this->repo = $repo;
    }

}
