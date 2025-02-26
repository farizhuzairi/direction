<?php

namespace Director\Services;

use Closure;
use Director\Accessible;
use Illuminate\Http\Request;
use Director\Enums\RequestType;
use Director\Contracts\Traceable;
use Director\Contracts\WebMaster;

final class WebService extends WebMaster implements Accessible
{
    /**
     * Construction
     * 
     */
    public function __constrcut(?Traceable $trace, ?string $userModelClass)
    {
        parent::__construct(trace: $trace, userModelClass:$userModelClass);
    }

    /**
     * Direction Service Middleware
     * ---
     * 
     * Menerapkan Direction Service sebagai Layanan Manajemen Data yang digunakan secara otomatis.
     * 
     * @return Accessible
     */
    public function bootTrace(?Request $request): Accessible
    {
        if(! $request instanceof Request || ! $this->isPermitted()) {
            throw new \Exception("Error Processing Request: Invalid Boot Race System.");
        }

        $this->trace->newVisit(RequestType::LOG, $request->session()->token(), $this->visitor->userId());
        return $this;
    }

    /**
     * Memeriksa apakah akses permintaan diizinkan.
     * 
     * @return bool
     */
    public function isPermitted(): bool
    {
        return true;
    }

    /**
     * Insertion required in every page visit or data request process
     * 
     * @return static
     */
    public function insertions(?Closure $access): static
    {
        return $this;
    }
}