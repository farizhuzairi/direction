<?php

namespace Director;

interface Accessible
{
    public function bootTrace(\Illuminate\Http\Request|null $request): Accessible;
    public function isPermitted(): bool;
}