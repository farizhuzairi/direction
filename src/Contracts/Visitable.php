<?php

namespace Director\Contracts;

interface Visitable
{
    public function __construct(?object $user);
    public function setUser(?object $user): static;
    public function hasModel(): bool;
    public function withModel(string $class): static;
    public function setUserModel(?string $model = null): static;
    public function user(): ?object;
    public function userId(): string|int|null;
    public function as(): ?string;
    public function model(): ?string;
}