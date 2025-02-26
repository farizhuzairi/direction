<?php

namespace Director\Factory;

use Director\Enums\RequestType;

class RequestFactory
{
    /**
     * Request ID
     * 
     * @var string
     */
    private $requestId;

    /**
     * Timestamp as Unique Code Prefix
     * 
     * @return int
     */
    private $stamp;

    /**
     * Visitor Counter Hit
     * 
     * @return int
     */
    private $hits = 0;
    
    /**
     * Trace ID
     * 
     * @return string
     */
    private static $id;

    /**
     * Type of Traceable Object User
     * log | userable | datamodel
     * 
     * @return \Director\Enums\RequestType|null
     */
    private $typeOf;

    /**
     * Instant Key
     * 
     * @return string
     */
    public function instantKey(): string
    {
        return "ems_haschanetwork";
    }

    /**
     * Create New Trace ID
     * 
     * @return ?string
     */
    public function create(
        RequestType $typeOf,
        string $csrf,
        ?string $currentId,
        ?string $userId = null
    ): ?string
    {
        $this->typeOf = $typeOf;

        if($csrf !== $currentId && $typeOf) {
            
            $this->stamp = now()->timestamp;
            $this->hits += 1;

            // request id setup
            $this->requestId = $csrf;

            $dataId = \Hascamp\BaseCrypt\Encryption\BaseCrypt::code(
                [
                    'requestId' => $this->requestId(),
                    'typeOf' => $typeOf?->value,
                    'stamp' => $this->stamp(),
                    'hits' => $this->hits(),
                    'id' => \Illuminate\Support\Str::uuid()?->toString(),
                    'currentId' => $currentId,
                    'user' => [
                        'id' => $userId,
                    ],
                ],
                $this->instantKey()
            );

            // new Trace ID
            static::$id = $dataId;

        }

        return static::$id;
    }

    /**
     * Get Trace ID
     * 
     * @return string|null
     */
    public function id(): ?string
    {
        return static::$id;
    }

    /**
     * Public Trace ID
     * 
     * @return string|null
     */
    public function getId(): ?string
    {
        return $this->id();
    }

    /**
     * Get Stamp
     * 
     * @return int|null
     */
    public function stamp(): ?int
    {
        return $this->stamp;
    }

    /**
     * Public Stamp Data
     * 
     * @return int|null
     */
    public function getStamp(): ?int
    {
        return $this->stamp();
    }

    /**
     * Get Hits
     * 
     * @return int
     */
    private function hits(): int
    {
        return $this->hits;
    }

    /**
     * Public Hits Data
     * 
     * @return int
     */
    public function getHits(): int
    {
        return $this->hits();
    }

    /**
     * Request ID
     * 
     * @return ?string
     */
    public function requestId(): ?string
    {
        return $this->requestId;
    }

    /**
     * Get Request ID
     * 
     * @return ?string
     */
    public function getRequestId(): ?string
    {
        return $this->requestId();
    }

    /**
     * Request Type of
     * 
     * @return \Director\Enums\RequestType|null
     */
    public function typeOf(): ?RequestType
    {
        return $this->typeOf;
    }

    /**
     * Get Request Type
     * 
     * @return \Director\Enums\RequestType|null
     */
    public function getTypeOf(): ?RequestType
    {
        return $this->typeOf();
    }
}