<?php

namespace Director\Traits;

use Closure;

trait HasConnectionHub
{
    /**
     * Hub Connection Check,
     * is using connection?
     * 
     * @return bool
     */
    private $withConnection = false;

    /**
     * Hub Connection Object
     * 
     * @return object|null
     */
    private static $hub;

    /**
     * Using Connection Check
     * 
     * @return bool
     */
    public function withConnection(Closure|bool $connection = false): bool
    {
        if($connection instanceof Closure) {

            $connection($this);
            return $this->withConnection;

        }

        elseif(is_bool($connection)) {

            if($connection) {
                return is_object($this->getConnection()) ? $this->withConnection : false;
            }

        }
        
        return false;
    }

    /**
     * Set Connection
     * 
     * @return static
     */
    public function setConnection(?string $class): static
    {
        if(class_exists($class)) {
            static::$hub = new $class();
        }

        return $this;
    }

    /**
     * Get Connection Object
     * 
     * @return object|null
     */
    public function getConnection(): ?object
    {
        if($this->withConnection) {
            return static::$hub;
        }

        return null;
    }

    /**
     * Connection Check
     * 
     * @return bool
     */
    public function hasConnection(): bool
    {
        return $this->withConnection;
    }
}