<?php

namespace Director;

interface Accessible
{
    public function bootTrace(\Illuminate\Http\Request $request): Accessible;
    public function isPermitted(): bool;
}