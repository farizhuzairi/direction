<?php

namespace Director\Factory;

use Illuminate\Routing\UrlGenerator;
use Hascamp\BaseCrypt\Encryption\BaseCrypt;

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
     * @var int
     */
    private $stamp;

    /**
     * Visitor Counter Hit
     * 
     * @var int
     */
    private int $hits = 0;
    
    /**
     * Trace ID
     * 
     * @var string
     */
    private static $id;

    /**
     * Type of Traceable Object User
     * log | userable | datamodel
     * 
     * @var string
     */
    private $typeOf;

    /**
     * Logs
     * 
     * @var string
     */
    protected $logs;

    /**
     * Instant Key
     * 
     * @return string
     */
    public function instantKey(string $key, ?string $prefix = null): string
    {
        $iKey = (string) $key;
        $iKey .= (string) $prefix;

        return $iKey;
    }

    /**
     * Create New Trace ID
     * 
     * @return ?string
     */
    public function create(
        string $typeOf,
        string $sessionId,
        string $sessionName,
        string $csrf,
        UrlGenerator $url,
        ?string $routeName,
        ?string $currentId,
        ?string $userId,
    ): ?string
    {
        $this->typeOf = $typeOf;
        $time = \Carbon\Carbon::now();

        if(! empty($currentId)) {
            // ...
        }

        if($sessionId && $csrf && $typeOf) {
            
            $this->stamp = $time->timestamp;
            $this->hits += 1;

            $this->setId();
            $this->setRequestId($csrf, $routeName, $sessionName, $sessionId, $userId);

            $this->logs = BaseCrypt::code(
                [
                    'requestId' => $this->requestId(),
                    'sessionId' => $sessionId,
                    'sessionName' => $sessionName,
                    'token' => $csrf,
                    'typeOf' => $typeOf,
                    'stamp' => $this->stamp(),
                    'hits' => $this->hits(),
                    'currentId' => $this->id(),
                    'user' => [
                        'id' => $userId,
                    ],
                    'url' => [
                        'fullUrl' => $url->full(),
                        'current' => $url->current(),
                        'previous' => $url->previous(),
                    ],
                    'dateTime' => $time->format('Y-m-d H:i:s'),
                ],
                $this->instantKey($sessionName, $this->requestId() . $userId)
            );

        }

        return static::$id;
    }

    /**
     * Set Trace ID
     * 
     * @return void
     */
    private function setId(): void
    {
        $id = \Illuminate\Support\Str::uuid()?->toString();
        static::$id = $id;
    }

    /**
     * Get Trace ID
     * 
     * @return string|null
     */
    public function id(): ?string
    {
        $id = static::$id;

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
     * Set Request ID
     * 
     * @return void
     */
    private function setRequestId(
        string $csrf,
        string $routeName,
        string $sessionName,
        string $sessionId,
        ?string $userId,
    ): void
    {
        $newTraceId = static::$id;
        $this->requestId = BaseCrypt::code(
            "{$csrf}++{$routeName}++{$newTraceId}++{$this->stamp()}++{$userId}",
            $this->instantKey($sessionName, $sessionId . $userId)
        );
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
     * @return string|null
     */
    public function typeOf(): ?string
    {
        return $this->typeOf;
    }

    /**
     * Get Request Type
     * 
     * @return string|null
     */
    public function getTypeOf(): ?string
    {
        return $this->typeOf();
    }

    /**
     * Logs
     * 
     * @return string|null
     */
    public function logs(): ?string
    {
        return $this->logs;
    }

    /**
     * Get Logs
     * 
     * @return string|null
     */
    public function getLogs(): ?string
    {
        return $this->logs();
    }
}