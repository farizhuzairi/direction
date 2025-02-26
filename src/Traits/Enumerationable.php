<?php

namespace Director\Traits;

trait Enumerationable
{
    /**
     * Data to Array
     * 
     */
    public static function data(): array
    {
        return array_combine(
            array_column(self::cases(), 'name'),
            array_column(self::cases(), 'value'),
        );
    }
}