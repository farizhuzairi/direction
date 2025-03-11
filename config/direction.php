<?php

return [

    /**
     * List of service class configurations for running the application manager.
     * Direction Package by default fully supports EMS licensed applications running on Laravel ^11.
     * 
     * VitiBuilder Interface:
     * <app as Serviceable>|<visitor as Visitable>
     */
    "services" => [

        // Use Application Service Required
        "app" => \Director\Services\ApplicationService::class,

        // Use Visitor Service Required
        "visitor" => \Director\Services\VisitorService::class,

    ],

];