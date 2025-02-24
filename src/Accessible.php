<?php

namespace Director;

interface Accessible
{
    public function middleTrace(\Illuminate\Http\Request $request): Accessible;
    public function isPermitted(): bool;
}