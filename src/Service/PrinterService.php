<?php
declare(strict_types=1);

namespace App\Service;

use App\Entity\Personne;

final class PrinterService
{
    public function printLabels(array $personnes): void
    {
        foreach ($personnes as $p) {
            if (!$p instanceof Personne) {
                throw new \InvalidArgumentException("Le tableau doit contenir des Personne.");
            }
            echo $p->getLabel() . PHP_EOL;
        }
    }
}