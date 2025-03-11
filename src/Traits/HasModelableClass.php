<?php

namespace Director\Traits;

trait HasModelableClass
{
    /**
     * Default Model
     * 
     * @return bool
     */
    private $withHascModelDefault = false;

    /**
     * Using Hub Connection
     * 
     * @return bool
     */
    private $withConnectionHub = false;

    /**
     * Using Hub Connection Class
     * 
     * @return string
     */
    private static $connectionHubClass;

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
    public function withConnectionHub(?string $class = null): bool
    {
        if(! class_exists($class)) {
            return false;
        }

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
        $_hubConnClass = static::$connectionHubClass;

        if($this->withConnectionHub($_hubConnClass)) {
            return $_hubConnClass;
        }

        return null;
    }

    /**
     * Set User Model Class
     * 
     * @return string|null
     */
    public function setUserModelClass(string $class): void
    {
        static::$userModelClass = $class;
    }

    /**
     * Get object
     * Has User Model Class
     * 
     * @return string|null
     */
    public function userModelClass(): ?string
    {
        return static::$userModelClass;
    }
}