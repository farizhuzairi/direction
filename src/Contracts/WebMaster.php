<?php

namespace Director\Contracts;

use Closure;
use Director\Traits\HasTrace;
use Director\Contracts\Traceable;
use Director\Contracts\Visitable;
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
     * @var Visitable
     */
    protected $visitor;

    /**
     * Layanan interaksi pengguna,
     * membangun struktur data objek berdasarkan permintaan untuk menghasilkan respon.
     * 
     * @var Serviceable
     */
    protected $service;

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
    public function __construct(?Traceable $trace, ?string $userModelClass)
    {
        static::$userModelClass = $userModelClass;
        $this->traceableSetup($trace);
    }

    /**
     * Membangun data pengunjung atau pengguna aktif
     * 
     * @return void
     */
    final public function visitorBuild(Visitable $visitor, ?Closure $builder = null): void
    {
        $this->visitor = $visitor;
        $this->visitor()->withModel($this->userModelClass());
        
        if($builder instanceof Closure) {
            $builder($this);
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
     * Get data Visitable
     * 
     * @return \Director\Contracts\Visitable
     */
    public function visitor(): Visitable
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
    public function service(): Serviceable|null
    {
        if(! $this->service instanceof Serviceable) {
            throw new \Exception("Error Processing Request: Serviceable invalid object.");
        }

        return $this->service;
    }

    /**
     * Insertion required in every page visit or data request process.
     * 
     * @return static
     */
    abstract public function insertions(?Closure $access): static;

    /**
     * Has Form Processing
     * 
     * @return bool
     */
    public function formDataProcessing(): bool
    {
        return ! empty($this->formData) ? true : false;
    }
}