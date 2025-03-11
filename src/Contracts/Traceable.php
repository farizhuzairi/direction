<?php

namespace Director\Contracts;

use Closure;
use Illuminate\Session\Store;
use Director\Enums\RequestType;
use Director\Factory\RequestFactory;
use Illuminate\Routing\UrlGenerator;

interface Traceable
{
    public function __construct(RequestFactory $factory);

    public function newVisit(
        RequestType $typeOf,
        Store $session,
        UrlGenerator $url,
        ?string $routeName,
        ?string $userId,
        ?Closure $tracer = null
    ): static;
    
    public function factory(): ?RequestFactory;
}