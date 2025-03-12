<?php

namespace Director\Factory;

use Illuminate\Routing\UrlGenerator;
use Hascamp\BaseCrypt\Encryption\BaseCrypt;

class RequestFactory
{
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
    private $logs;

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

        return $this->getId();
    }

    /**
     * Set Trace ID
     * 
     * @return void
     */
    private function setId(): void
    {
        $id = \Illuminate\Support\Str::uuid()?->toString();
        session(['trace_id' => $id]);
    }

    /**
     * Get Trace ID
     * 
     * @return string|null
     */
    public function id(): ?string
    {
        $id = session('trace_id', null);
        return $id;
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
        $requestId = BaseCrypt::code(
            "{$csrf}++{$routeName}++{$this->getId()}++{$this->stamp()}++{$userId}",
            $this->instantKey($sessionName, $sessionId . $userId)
        );
        session('request_id', $requestId);
    }

    /**
     * Request ID
     * 
     * @return ?string
     */
    public function requestId(): ?string
    {
        return session('request_id', null);
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