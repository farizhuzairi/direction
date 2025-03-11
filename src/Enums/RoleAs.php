<?php

namespace Director\Enums;

enum RoleAs : string
{
    case GUEST = "guest";
    case USER = "user";

    use \Director\Traits\Enumerationable;
}