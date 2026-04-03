<?php
declare(strict_types=1);

namespace App\Entity;

final class Filiere
{
    private int $id;
    private string $libelle;

    public function __construct(int $id, string $libelle)
    {
        $this->setId($id);
        $this->setLibelle($libelle);
    }

    public function getId(): int
    {
        return $this->id;
    }

    public function setId(int $id): void
    {
        if ($id <= 0) {
            throw new \InvalidArgumentException("Id filiere invalide.");
        }
        $this->id = $id;
    }

    public function getLibelle(): string
    {
        return $this->libelle;
    }

    public function setLibelle(string $libelle): void
    {
        $libelle = trim($libelle);
        if ($libelle === '') {
            throw new \InvalidArgumentException("Libellé filiere obligatoire.");
        }
        $this->libelle = $libelle;
    }
}