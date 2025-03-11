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
            return $this->trace->id() ? true : false;
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
        $id = null;

        if($this->hasTrace()) {
            $id = $this->trace->id();
        }
        
        return $id;
    }

    /**
     * Get Request ID
     * 
     * @return string|null
     */
    public function requestId(): ?string
    {
        $requestId = null;

        if($this->hasTrace()) {
            $requestId = $this->trace->getRequestId();
        }
        
        return $requestId;
    }
}