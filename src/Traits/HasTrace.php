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
    protected $trace = null;

    /**
     * Traceable Setup
     * 
     * @return void
     */
    protected function traceableSetup(?Traceable $class): void
    {
        if($class instanceof Traceable) {
            $this->trace = $class;
        }
    }

    /**
     * Using Traceable Check
     * 
     * @return bool
     */
    protected function hasTrace(): bool
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
        $id = null;

        if($this->hasTrace()) {
            $id = $this->trace->getRequestId();
        }
        
        return $id;
    }
}