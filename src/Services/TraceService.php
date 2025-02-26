<?php

namespace Director\Services;

use Closure;
use Director\Enums\RequestType;
use Director\Contracts\Traceable;
use Director\Factory\RequestFactory;

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
        string $csrf,
        // ?string $requestCode = "",
        // string $key = "",
        ?string $userId = null,
        ?Closure $factory = null
    ): static
    {
        if(! $this->factory()->create($typeOf, $csrf, $this->factory()->id(), $userId)) {
            throw new \Exception("Error Processing Request: Invalid Traceable ID process.");
        }

        if($factory instanceof Closure) {
            $factory($this->factory());
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