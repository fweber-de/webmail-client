<?php

namespace AppBundle\Service;

class NylasAccountService
{
    protected $doctrine;
    protected $guzzleClient;

    public function __construct($doctrine, $guzzleClient)
    {
        $this->doctrine = $doctrine;
        $this->guzzleClient = $guzzleClient;
    }
}
