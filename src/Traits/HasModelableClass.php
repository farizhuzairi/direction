<?php

namespace Director\Traits;

trait HasModelableClass
{
    /**
     * Default Model
     * 
     * @return bool
     */
    private static $withHascModelDefault = false;

    /**
     * Default Hub Connection
     * 
     * @return bool
     */
    private static $withConnectionHub = false;

    /**
     * Hub Connection Class
     * 
     * @return string
     */
    private static $connectionHubClass;

    /**
     * With User Model
     * 
     * @return bool
     */
    private static $withUserModel = false;

    /**
     * User Model Class
     * 
     * @return string
     */
    private static $userModelClass;

    /**
     * Get object
     * data model default
     * 
     * @return bool
     */
    public function hascModelDefault(): bool
    {
        return $this->withHascModelDefault;
    }

    /**
     * Get object
     * Has With Connection Hub
     * 
     * @return bool
     */
    public function withConnectionHub(): bool
    {
        return $this->withConnectionHub;
    }

    /**
     * Get object
     * Hub Connection Class
     * 
     * @return string|null
     */
    public function connectionHubClass(): ?string
    {
        return $this->connectionHubClass;
    }

    /**
     * Get object
     * Has With User Model
     * 
     * @return bool
     */
    public function withUserModel(): bool
    {
        return $this->withUserModel;
    }

    /**
     * Get object
     * Has User Model Class
     * 
     * @return string|null
     */
    public function userModelClass(): ?string
    {
        return $this->userModelClass;
    }
}