<?php
declare(strict_types=1);

namespace App\Contract;

interface ExportableInterface
{
    public function toArray(): array;
}