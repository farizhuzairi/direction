<?php

namespace Director\Services;

use Closure;
use Illuminate\Session\Store;
use Director\Enums\RequestType;
use Director\Contracts\Traceable;
use Director\Factory\RequestFactory;
use Illuminate\Routing\UrlGenerator;

class TraceService implements Traceable
{
    /**
     * Traceable Request Factory
     * 
     * @return \Director\Factory\RequestFactory
     */
    private $factory;

    /**
     * Construction
     * 
     */
    public function __construct(RequestFactory $factory)
    {
        $this->factory = $factory;
    }

    /**
     * New Visit
     * 
     * @return static
     */
    public function newVisit(
        RequestType $typeOf,
        Store $session,
        UrlGenerator $url,
        ?string $routeName,
        ?string $userId = null,
        ?Closure $tracer = null
    ): static
    {
        if(! $session instanceof Store) {
            throw new \Exception("Error Processing Request: Invalid session.");
        }

        if($tracer instanceof Closure) {
            $tracer($this);
        }

        if(! $this->factory()->create(
            $typeOf->value,
            $session->getId(),
            $session->getName(),
            $session->token(),
            $url,
            $routeName,
            $this->factory()->id(),
            $userId
        )) {
            throw new \Exception("Error Processing Request: Invalid Traceable ID process.");
        }

        return $this;
    }

    /**
     * Get Factory
     * 
     * @return \Director\Factory\RequestFactory|null
     */
    public function factory(): ?RequestFactory
    {
        return $this->factory;
    }
}