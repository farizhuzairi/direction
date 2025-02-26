<?php

namespace Director\Services;

use Director\Accessible;
use Director\Contracts\Visitable;
use Director\Contracts\VisitBuilder;
use Illuminate\Support\Facades\Auth;

class VisitorService implements VisitBuilder, Visitable
{
    /**
     * User ID Generation
     * 
     * @var string|int|null
     */
    protected $userId;

    /**
     * User Role As Identification
     * 
     * @var string|null
     */
    protected $as;

    /**
     * User Model Class
     * 
     * @var string
     */
    protected $model;

    /**
     * Construction
     * 
     */
    public function __construct(?object $user)
    {
        if($user) {
            $this->setUser($user->id);
        }
    }

    /**
     * set User
     * 
     * @return static
     */
    private function setUser(string|int|null $userId): static
    {
        $this->userId = $userId;
        return $this;
    }

    /**
     * Set User Model Default
     * 
     * @return void
     */
    private function setUserModel(string $model): void
    {
        if(! class_exists($model)) {
            throw new \Exception("Error Processing Request: User Model not found.");
        }

        $this->model = $model;
    }

    /**
     * Get User ID Not Generation
     * 
     * @return string|int|null
     */
    public function userId(): string|int|null
    {
        return $this->userId;
    }

    /**
     * Get User Role As Not Generation
     * 
     * @return string|null
     */
    public function as(): ?string
    {
        return $this->as;
    }

    /**
     * Get User Model Class Not Generation
     * 
     * @return string|null
     */
    public function model(): ?string
    {
        return $this->model;
    }

    /**
     * Get User Object with Generation
     * as Object Model
     * 
     * @return object|null
     */
    public function user(): ?object
    {
        $user = Auth::user();
        if(! $user || $user?->id !== $this->userId()) {
            return null;
        }

        return $user;
    }

    /**
     * Set User Model Class
     * 
     * @return static
     */
    public function withModel(string $class): static
    {
        $this->model = $class;
        return $this;
    }
}