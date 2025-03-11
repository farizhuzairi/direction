<?php

namespace Director\Services;

use Director\Accessible;
use Director\Enums\RoleAs;
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
     * User Model Generation
     * 
     * @var object|null
     */
    private static $user;

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
        $this->setUser($user);
    }

    /**
     * set User
     * 
     * @return static
     */
    public function setUser(?object $user): static
    {
        if($user) {
            $this->userId = $user->id;
            $this->as = RoleAs::USER->value;
        }

        else{
            $this->as = RoleAs::GUEST->value;
        }

        return $this;
    }

    /**
     * Get User Object with Generation
     * as Object Model
     * 
     * @return bool
     */
    public function hasModel(): bool
    {
        if($this->userId) {

            if(static::$user instanceof $this->model) {
                return true;
            }

        }

        else{
            return $this->model ? true : false;
        }

        return false;
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

    /**
     * Set User Model Default
     * 
     * @return static
     */
    public function setUserModel(?string $model = null): static
    {
        if(! empty($model)) {

            if(! class_exists($model)) {

                throw new \Exception("Error Processing Request: User Model not found.");

            }

            $this->model = $model;

        }

        $user = Auth::user();
        $usingModel = $this->model;

        if($user?->id !== $this->userId) {

            throw new \Exception("Error Processing Request: Invalid user access.");

        }

        if($user) {

            if($this->hasModel()) {
                throw new \Exception("Error Processing Request: Invalid User Model.");
            }

            static::$user = $user;

        }

        return $this;
    }

    /**
     * Get User Model Not Generation
     * 
     * @return object|null
     */
    public function user(): ?object
    {
        return $this->hasModel() ? static::$user : null;
    }

    /**
     * Get User ID Not Generation
     * 
     * @return string|int|null
     */
    public function userId(): string|int|null
    {
        return $this->hasModel() ? $this->userId : null;
    }

    /**
     * Get User Role As Not Generation
     * 
     * @return string|null
     */
    public function as(): ?string
    {
        return $this->hasModel() ? $this->as : null;
    }

    /**
     * Get User Model Class Not Generation
     * 
     * @return string|null
     */
    public function model(): ?string
    {
        return $this->hasModel() ? $this->model : null;
    }
}