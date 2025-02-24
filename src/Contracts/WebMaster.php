<?php

namespace Director\Contracts;

use Closure;
use Director\Traits\HasTrace;
use Director\Traits\HasModelableClass;

abstract class WebMaster
{
    use
    HasTrace,
    HasModelableClass;
    
    /**
     * Pelacakan Rute atau Permintaan
     * 
     * @var Traceable
     */
    protected $trace;

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
    public function __construct($trace)
    {
        $this->trace = $trace;
    }

    /**
     * Membangun data pengunjung atau pengguna aktif
     * 
     * @return void
     */
    final public function visitorBuild(Visitable $visitor, ?Closure $builder): void
    {}

    /**
     * Membangun suatu layanan data permintaan untuk menghasilkan respon
     * 
     * @return void
     */
    final public function serviceBuild(Serviceable $service, ?Closure $builder): void
    {}

    /**
     * Get data Visitable
     * 
     * @return Visitable|null
     */
    public function visitor(): Visitable|null
    {
        return $this->visitor;
    }

    /**
     * Get Data Service
     * 
     * @return Serviceable|null
     */
    public function service(): Serviceable|null
    {
        return $this->service;
    }

    /**
     * Insert data
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