<?php

namespace model;

require_once __DIR__ . "/../lib/config.php";

use http\Exception\RuntimeException;
use RuntimeException as GlobalRuntimeException;

use function lib\db\get_db;

enum TypePersonne
{
    case PersonneDeConfiance;
    case PersonneAPrevenir;
}

class Personne
{
    public string $nom;
    public string $prenom;
    public string $telephone;
    public string $adresse;
    public string $num_secu;
    public TypePersonne $type;

    function __construct(
        string       $nom,
        string       $prenom,
        string       $telephone,
        string       $adresse,
        string       $num_secu,
        TypePersonne $type
    ) {
        $this->nom = $nom;
        $this->prenom = $prenom;
        $this->telephone = $telephone;
        $this->adresse = $adresse;
        $this->num_secu = $num_secu;
        $this->type = $type;
    }

    public static function from_form(mixed $form, TypePersonne $type): static
    {
        // var_dump($form);
        // exit();

        extract($form);
        switch ($type) {
            case TypePersonne::PersonneDeConfiance: {
                    return new static($pc_nom, $pc_prenom, $pc_telephone, $pc_adresse, $num_secu, $type);
                }

            case TypePersonne::PersonneAPrevenir: {
                    return new static($pp_nom, $pp_prenom, $pp_telephone, $pp_adresse, $num_secu, $type);
                }

            default:
                throw new GlobalRuntimeException("Invalid type");
        }
    }

    public function register(): bool
    {
        $db = get_db();

        $table = match ($this->type) {
            TypePersonne::PersonneDeConfiance => "personnes_de_confiance",
            TypePersonne::PersonneAPrevenir => "personnes_a_prevenir",
        };

        $req = "INSERT INTO $table(nom, prenom, telephone, adresse, num_secu) VALUES (:nom, :prenom, :telephone, :adresse, :num_secu)";
        $stmt = $db->prepare($req);

        $stmt->bindValue(":nom", $this->nom);
        $stmt->bindValue(":prenom", $this->prenom);
        $stmt->bindValue(":telephone", $this->telephone);
        $stmt->bindValue(":adresse", $this->adresse);
        $stmt->bindValue(":num_secu", $this->num_secu);

        return $stmt->execute();
    }
}
