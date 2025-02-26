<?php

namespace Director\Enums;

enum RequestType : string
{
    case LOG = "request";
    case USERABLE = "userable";
    case DATAMODEL = "modelable";
    case TRX = "transactionable";

    use \Director\Traits\Enumerationable;
}