<?php
declare(strict_types=1);

// ----------------etape 2------------
// Interfaces
interface IdentifiableInterface
{
    public function getId(): ?int;
    public function setId(?int $id): void;
}

interface ExportableInterface
{
    public function toArray(): array;
}

// ----------------etape 3------------
// Classe abstraite Personne
abstract class Personne implements IdentifiableInterface
{
    protected ?int $id;
    protected string $nom;
    protected string $email;

    public function __construct(?int $id, string $nom, string $email)
    {
        $this->setId($id);
        $this->setNom($nom);
        $this->setEmail($email);
    }

    public function getId(): ?int { return $this->id; }
    public function setId(?int $id): void
    {
        if ($id !== null && $id <= 0) throw new \InvalidArgumentException("Id invalide");
        $this->id = $id;
    }

    public function getNom(): string { return $this->nom; }
    public function setNom(string $nom): void
    {
        $nom = trim($nom);
        if ($nom === '') throw new \InvalidArgumentException("Nom obligatoire");
        $this->nom = $nom;
    }

    public function getEmail(): string { return $this->email; }
    public function setEmail(string $email): void
    {
        $email = trim($email);
        if ($email === '' || !filter_var($email, FILTER_VALIDATE_EMAIL)) throw new \InvalidArgumentException("Email invalide");
        $this->email = $email;
    }

    abstract public function getRole(): string;

    public function getLabel(): string
    {
        return $this->getRole() . " : " . $this->nom . " <" . $this->email . ">";
    }
}

// ----------------etape 4------------
// Classe Filiere
class Filiere
{
    private int $id;
    private string $libelle;

    public function __construct(int $id, string $libelle)
    {
        $this->setId($id);
        $this->setLibelle($libelle);
    }

    public function getId(): int { return $this->id; }
    public function setId(int $id): void
    {
        if ($id <= 0) throw new \InvalidArgumentException("Id filiere invalide");
        $this->id = $id;
    }

    public function getLibelle(): string { return $this->libelle; }
    public function setLibelle(string $libelle): void
    {
        $libelle = trim($libelle);
        if ($libelle === '') throw new \InvalidArgumentException("Libelle obligatoire");
        $this->libelle = $libelle;
    }
}

// ----------------etape 4------------
// Classe Etudiant
class Etudiant extends Personne implements ExportableInterface
{
    private Filiere $filiere;

    public function __construct(?int $id, string $nom, string $email, Filiere $filiere)
    {
        parent::__construct($id, $nom, $email);
        $this->filiere = $filiere;
    }

    public function getFiliere(): Filiere { return $this->filiere; }
    public function setFiliere(Filiere $filiere): void { $this->filiere = $filiere; }

    public function getRole(): string { return "Etudiant"; }

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

// ----------------etape 5------------
// Classe Enseignant
class Enseignant extends Personne implements ExportableInterface
{
    private string $grade;

    public function __construct(?int $id, string $nom, string $email, string $grade)
    {
        parent::__construct($id, $nom, $email);
        $this->setGrade($grade);
    }

    public function getGrade(): string { return $this->grade; }
    public function setGrade(string $grade): void
    {
        $grade = trim($grade);
        if ($grade === '') throw new \InvalidArgumentException("Le grade est obligatoire");
        $this->grade = $grade;
    }

    public function getRole(): string { return "Enseignant"; }

    public function toArray(): array
    {
        return [
            'id' => $this->getId(),
            'role' => $this->getRole(),
            'nom' => $this->getNom(),
            'email' => $this->getEmail(),
            'grade' => $this->grade
        ];
    }
}

// ----------------etape 7------------
// Service PrinterService
class PrinterService
{
    public function printLabels(array $personnes): void
    {
        foreach ($personnes as $p)
        {
            if (!$p instanceof Personne) throw new \InvalidArgumentException("Le tableau doit contenir des Personne");
            echo $p->getLabel() . "<br>";
        }
    }
}

// ----------------etape 4------------
// Création filière et étudiants
$fInfo = new Filiere(1, "Informatique");
$e1 = new Etudiant(null, "Ali", "Ali@example.com", $fInfo);
$e2 = new Etudiant(null, "Chaymae", "Chaymae@example.com", $fInfo);

// ----------------etape 5------------
// Création enseignant
$ens1 = new Enseignant(null, "Dr Mohamed", "Mohamed@example.com", "Maitre de conferences");

// ----------------etape 7------------
// Tableau polymorphe
$personnes = [$e1, $e2, $ens1];

// ----------------etape 7------------
// Service pour afficher labels
$printer = new PrinterService();
$printer->printLabels($personnes);

// ----------------etape 6------------
// Export en tableau
echo "<br>Export tableau (exemple) :<br>";
echo "<pre>";
print_r($e1->toArray());
print_r($ens1->toArray());
echo "</pre>";