<?php

namespace Director\Traits;

use Director\Contracts\Traceable;

trait HasTrace
{
    /**
     * Pelacakan Rute atau Permintaan
     * 
     * @var \Director\Contracts\Traceable|null
     */
    protected ?Traceable $trace = null;

    /**
     * Traceable Setup
     * 
     * @return void
     */
    protected function traceableSetup(?Traceable $trace): void
    {
        if(! $trace instanceof Traceable) {
            throw new \Exception("Error Processing Request: Invalid Traceable object.");
        }

        $this->trace = $trace;
    }

    /**
     * Using Traceable Check
     * 
     * @return bool
     */
    public function hasTrace(): bool
    {
        if($this->trace instanceof Traceable) {
            return $this->trace->factory()->id() ? true : false;
        }

        return false;
    }

    /**
     * Get Trace ID
     * 
     * @return string|null
     */
    public function traceId(): ?string
    {
        if($this->hasTrace()) {
            return $this->trace->factory()->id();
        }
        
        return null;
    }

    /**
     * Get Request ID
     * 
     * @return string|null
     */
    public function requestId(): ?string
    {
        if($this->hasTrace()) {
            return $this->trace->factory()->getRequestId();
        }
        
        return null;
    }
}