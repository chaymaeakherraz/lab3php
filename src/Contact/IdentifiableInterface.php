<?php
declare(strict_types=1);

namespace App\Contract;

interface IdentifiableInterface
{
    public function getId(): ?int;
    public function setId(?int $id): void;
}