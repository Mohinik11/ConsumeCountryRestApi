<?php

namespace ApiHandler;

/**
 * ApiInterface should be implemented by classes that depends on an Api.
 *
 * @author Mohini Kamboj <mohinikamboj11@gmail.com>
 */
interface ApiInterface
{
    /**
     * Get API.
     *
     */
    public function get($url);

}
