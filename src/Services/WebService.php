<?php

namespace Director\Services;

use Closure;
use Director\Accessible;
use Illuminate\Http\Request;
use Director\Contracts\WebMaster;

final class WebService extends WebMaster implements Accessible
{
    public function __constrcut($trace)
    {
        parent::__construct(trace: $trace);
    }

    public function middleTrace(Request $request): Accessible
    {
        return $this;
    }

    public function isPermitted(): bool
    {
        return ! empty($this->trace) ? true : false;
    }

    public function insertions(?Closure $access): static
    {
        return $this;
    }
}