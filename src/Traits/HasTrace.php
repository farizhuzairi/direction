<?php

namespace Director\Traits;

trait HasTrace
{
    public function traceId(): string
    {
        return '';
    }

    public function requestId(): string
    {
        return '';
    }

    public function stamp(): int
    {
        return 0;
    }

    public function hits(): int
    {
        return 0;
    }

    public function invalidTrace(): bool
    {
        return true;
    }

    public function traceRecord(bool $isJson): array|string|null
    {
        return null;
    }
}