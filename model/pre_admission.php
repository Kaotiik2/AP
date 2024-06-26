<?php

namespace model;

require_once __DIR__ . "/../lib/config.php";
require_once "../model/personnes.php";

use lib\db;
use model\Personne;
use model\TypePersonne;

// Returns false if insert_patient got successful, the error string else
// TODO: Doesn't work lmao
// TODO: Do Model for Documents and Patients
function new_pre_admission($values): false|string
{
    $db = db\get_db();

    extract($values);

    // `patients` Insertion
    $req = "INSERT INTO patients(num_secu, organisme_secu, assurance, ald, nom_mutuelle, num_adherent_mutuelle, type_chambre, civilite, nom_naissance, nom_epouse, prenom, date_naissance, adresse, code_postal, ville, email, telephone)
        VALUES(
            :num_secu, :organisme_secu, :assurance, 
            :ald, :nom_mutuelle, :num_adherent_mutuelle, :type_chambre, 
            :civilite, :nom_naissance, :nom_epouse, 
            :prenom, :date_naissance, :adresse, 
            :code_postal, :ville, :email, 
            :telephone
    );";

    $stmt = $db->prepare($req);
    $stmt->bindValue(":num_secu", $num_secu);
    $stmt->bindValue(":organisme_secu", $caisse_secu);
    $stmt->bindValue(":assurance", $est_assure);
    $stmt->bindValue(":ald", $ald);
    $stmt->bindValue(":nom_mutuelle", $nom_mutuelle);
    $stmt->bindValue(":num_adherent_mutuelle", $numero_adherent_mutuelle);
    $stmt->bindValue(":type_chambre", $type_chambre);
    $stmt->bindValue(":civilite", $civilite);
    $stmt->bindValue(":nom_naissance", $nom_naissance);
    $stmt->bindValue(":nom_epouse", $nom_epouse);
    $stmt->bindValue(":prenom", $prenom);
    $stmt->bindValue(":date_naissance", $date_naissance);
    $stmt->bindValue(":adresse", $adresse);
    $stmt->bindValue(":code_postal", $code_postal);
    $stmt->bindValue(":ville", $ville);
    $stmt->bindValue(":email", $mail);
    $stmt->bindValue(":telephone", $telephone);

    $result = $stmt->execute();

    if (!$result) {
        return $db->errorCode();
    }

    // End `patients` insertion

    // `hospitalisations` Insertion
    $req = "INSERT INTO hospitalisations(num_secu, date_hospitalisation, heure_intervention, type_hospitalisation, medecin_id)
        VALUES(
            :num_secu,
            :admission_date,
            :admission_time,
            :admission_type,
            :admission_medecin
    )";

    $stmt = $db->prepare($req);
    $stmt->bindValue(":num_secu", $num_secu);
    $stmt->bindValue(":admission_date", $admission_date);
    $stmt->bindValue(":admission_time", $admission_time);
    $stmt->bindValue(":admission_type", $admission_type);
    $stmt->bindValue(":admission_medecin", $nom_medecin);

    $result = $stmt->execute();

    if (!$result) {
        return $db->errorCode();
    }


    // `documents` Insertion
    if ($_POST["mineur"] == "on") {
        if ($_POST["parents_divorces"] == "on") {
            $req = "INSERT INTO documents(
            num_secu,
            carte_identite_recto,
            carte_identite_verso,
            carte_vitale,
            carte_mutuelle,
            livret_famille,
            autorisation_soin,
            monoparentalite_juge
        ) VALUES(
            :num_secu,
            :carte_identite_recto,
            :carte_identite_verso,
            :carte_vitale,
            :carte_mutuelle,
            :livret_famille,
            :autorisation_soin,
            :monoparentalite_juge
        );";
        } else {
            $req = "INSERT INTO documents(
            num_secu,
            carte_identite_recto,
            carte_identite_verso,
            carte_vitale,
            carte_mutuelle,
            livret_famille,
            autorisation_soin
        ) VALUES(
            :num_secu,
            :carte_identite_recto,
            :carte_identite_verso,
            :carte_vitale,
            :carte_mutuelle,
            :livret_famille,
            :autorisation_soin
        );";
        }

        $stmt = $db->prepare($req);
        $stmt->bindValue(":num_secu", $num_secu);
        $stmt->bindValue(":carte_identite_recto", file_get_contents($filename = $filename = $_FILES["ci_recto"]["tmp_name"]));
        $stmt->bindValue(":carte_identite_verso", file_get_contents($filename = $_FILES["ci_verso"]["tmp_name"]));
        $stmt->bindValue(":carte_vitale", file_get_contents($filename = $_FILES["carte_vitale"]["tmp_name"]));
        $stmt->bindValue(":carte_mutuelle", file_get_contents($filename = $_FILES["carte_mutuelle"]["tmp_name"]));
        if ($_POST["mineur"] == "on")
            $stmt->bindValue(":livret_famille", file_get_contents($filename = $_FILES["livret_famille"]["tmp_name"]));

        $stmt->bindValue(":autorisation_soin", file_get_contents($filename = $_FILES["autorisation_soin"]["tmp_name"]));

        if ($_POST["parents_divorces"] == "on") {
            $stmt->bindValue(":monoparentalite_juge", file_get_contents($filename = $_FILES["monoparentalite_juge"]["tmp_name"]));
        }
    } else {
        $req = "INSERT INTO documents(
        num_secu,
        carte_identite_recto,
        carte_identite_verso,
        carte_vitale,
        carte_mutuelle
    ) VALUES(
        :num_secu,
        :carte_identite_recto,
        :carte_identite_verso,
        :carte_vitale,
        :carte_mutuelle
    );";

        $stmt = $db->prepare($req);
        $stmt->bindValue(":num_secu", $num_secu);
        $stmt->bindValue(":carte_identite_recto", file_get_contents($filename = $_FILES["ci_recto"]["tmp_name"]));
        $stmt->bindValue(":carte_identite_verso", file_get_contents($filename = $_FILES["ci_verso"]["tmp_name"]));
        $stmt->bindValue(":carte_vitale", file_get_contents($filename = $_FILES["carte_vitale"]["tmp_name"]));
        $stmt->bindValue(":carte_mutuelle", file_get_contents($filename = $_FILES["carte_mutuelle"]["tmp_name"]));
    }

    $result = $stmt->execute();

    if (!$result) {
        return $db->errorCode();
    }

    // End `documents` Insertion

    $personne_de_confiance = Personne::from_form($_POST, TypePersonne::PersonneDeConfiance);
    if (!$personne_de_confiance->register())
        return "Can't register trusted person";


    $personne_a_prevenir = Personne::from_form($_POST, TypePersonne::PersonneAPrevenir);
    if (!$personne_a_prevenir->register())
        return "Can't register prevent person";

        session_start();
    $_SESSION["dernier_secu"] = $num_secu;
    return false;
}
