<?php
declare(strict_types=1);

namespace App\Entity;

use App\Contract\ExportableInterface;

final class Etudiant extends Personne implements ExportableInterface
{
    private Filiere $filiere;

    public function __construct(?int $id, string $nom, string $email, Filiere $filiere)
    {
        parent::__construct($id, $nom, $email);
        $this->setFiliere($filiere);
    }

    public function getFiliere(): Filiere
    {
        return $this->filiere;
    }

    public function setFiliere(Filiere $filiere): void
    {
        $this->filiere = $filiere;
    }

    public function getRole(): string
    {
        return "Etudiant";
    }

    public function toArray(): array
    {
        return [
            'id' => $this->getId(),
            'role' => $this->getRole(),
            'nom' => $this->getNom(),
            'email' => $this->getEmail(),
            'filiere' => [
                'id' => $this->filiere->getId(),
                'libelle' => $this->filiere->getLibelle()
            ]
        ];
    }
}