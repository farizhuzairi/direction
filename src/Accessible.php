<?php

namespace Director;

interface Accessible
{
    public function bootTrace(): Accessible;
    public function isPermitted(): bool;
}