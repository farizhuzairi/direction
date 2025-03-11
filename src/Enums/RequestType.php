<?php

namespace Director\Enums;

enum RequestType : string
{
    case LOG = "visit";
    case USERABLE = "userable";
    case DATAMODEL = "modelable";
    case TRX = "transactionable";

    use \Director\Traits\Enumerationable;
}