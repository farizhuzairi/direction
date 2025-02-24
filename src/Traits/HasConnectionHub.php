<?php

namespace Director\Traits;

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
    private $hub;

    /**
     * 
     */
    public function withConnection(Closure|bool $connection): bool
    {
        return $this->connection;
    }
}