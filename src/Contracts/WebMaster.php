<?php

namespace Director\Contracts;

use Closure;
use Director\Traits\HasTrace;
use Director\Contracts\Traceable;
use Director\Contracts\Visitable;
use Director\Contracts\Serviceable;
use Director\Traits\HasConnectionHub;
use Director\Traits\HasModelableClass;

abstract class WebMaster
{
    use
    HasTrace,
    HasModelableClass,
    HasConnectionHub;
    
    /**
     * Pengguna, sebagai objek yang melakukan permintaan
     * atau pengguna yang mengakses halaman / rute.
     * 
     * @var \Director\Contracts\Visitable
     */
    protected Visitable $visitor;

    /**
     * Layanan interaksi pengguna,
     * membangun struktur data objek berdasarkan permintaan untuk menghasilkan respon.
     * 
     * @var \Director\Contracts\Serviceable
     */
    protected Serviceable $service;

    /**
     * Data permintaan
     * 
     * @var array
     */
    protected static $formData = [];

    /**
     * Construction
     * 
     */
    public function __construct(?Traceable $trace, ?string $userModelClass, array $config)
    {
        static::$userModelClass = $userModelClass;
        $this->traceableSetup($trace);
    }

    /**
     * Membangun data pengunjung atau pengguna aktif
     * 
     * @return void
     */
    final public function visitorBuild(Visitable $visitor, ?Closure $visit = null, ?Closure $access = null): void
    {
        $this->createVisit($visitor);
        
        if($visit instanceof Closure) {
            $visit($this->visitor());
        }
        
        if($access instanceof Closure) {
            $access($this);
        }

        $this->serviceGate(
            new \Director\Services\ApplicationService()
        );
    }

    /**
     * Membangun suatu layanan data permintaan untuk menghasilkan respon
     * 
     * @return void
     */
    final public function serviceGate(Serviceable $service, ?Closure $builder = null): void
    {
        $this->service = $service;
        
        if($builder instanceof Closure) {
            $builder($this);
        }
    }

    /**
     * Create new Visit Instance
     * 
     * @return \Director\Contracts\Visitable
     */
    final public function createVisit(Visitable $visitor): Visitable
    {
        $this->visitor = $visitor;
        return $this->visitor()->withModel($this->userModelClass());
    }

    /**
     * Get data Visitable
     * 
     * @return \Director\Contracts\Visitable
     */
    final public function visitor(): Visitable
    {
        if(! $this->visitor instanceof Visitable) {
            throw new \Exception("Error Processing Request: Visitable invalid object.");
        }

        return $this->visitor;
    }

    /**
     * Get Data Service
     * 
     * @return Serviceable|null
     */
    final public function service(): Serviceable|null
    {
        if(! $this->service instanceof Serviceable) {
            throw new \Exception("Error Processing Request: Serviceable invalid object.");
        }

        return $this->service;
    }

    /**
     * Has Form Processing
     * 
     * @return bool
     */
    final public function formDataProcessing(): bool
    {
        return ! empty($this->formData) ? true : false;
    }

    /**
     * Insertion required in every page visit or data request process.
     * 
     * @return static
     */
    abstract public function insertions(?Closure $access): static;
}