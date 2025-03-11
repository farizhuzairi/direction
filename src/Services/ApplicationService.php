<?php

namespace Director\Services;

use Director\Contracts\Serviceable;
use Director\Contracts\VisitBuilder;

class ApplicationService implements VisitBuilder, Serviceable
{
    /**
     * Transaction Model Request Type
     * 
     * @var string
     */
    private $transactionModel;

    /**
     * Response Service
     * 
     * @var \Director\Contracts\Sourceable
     */
    private $response;
}