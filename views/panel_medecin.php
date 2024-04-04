<?php
require_once "../model/security.php";
global $SECURITY_MEDECIN_LEVEL;
$SECURITY_MEDECIN_LEVEL->authorize();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>LPFS - Panel Médecin</title>
    <link rel="stylesheet" href="/static/css/panel_medecin.css">
</head>
<body>
<div class="container">
    <div class="logo">
    <img src="/static/images/LPFS_logo.png" alt="Logo de votre site" class="logoimg">
    </div>
<div class="content">
<?php
// Informations de connexion à la base de données
$serveur = "localhost:3306";
$nomUtilisateur = "root";
$motDePasse = "Sio2021";
$nomBaseDeDonnees = "LPFS";

require_once "../model/users.php";
require_once "../model/medecins.php";

use model\User;
use model\Medecin;

$user = User::from_session();
$medecin = Medecin::from_user_id($user->id_user);

// Supposons que $idMedecinConnecte contient l'ID du médecin connecté
$idMedecinConnecte = $medecin->id;

try {
    // Connexion à la base de données
    $connexion = new PDO("mysql:host=$serveur;dbname=$nomBaseDeDonnees", $nomUtilisateur, $motDePasse);
    $connexion->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // Requête pour sélectionner les informations sur les hospitalisations du médecin connecté
    $requeteHospitalisations = $connexion->prepare("SELECT hospitalisations.date_hospitalisation, hospitalisations.heure_intervention, type_hospitalisation.type, hospitalisations.num_secu FROM hospitalisations INNER JOIN type_hospitalisation ON hospitalisations.type_hospitalisation = type_hospitalisation.id WHERE hospitalisations.medecin_id = :idMedecin");
    $requeteHospitalisations->bindParam(':idMedecin', $idMedecinConnecte);
    $requeteHospitalisations->execute();

    // Récupération des résultats des hospitalisations
    $hospitalisations = $requeteHospitalisations->fetchAll(PDO::FETCH_ASSOC);

    // Requête pour sélectionner les informations sur les patients des hospitalisations du médecin connecté
    $requetePatients = $connexion->prepare("SELECT * FROM patients WHERE num_secu IN (SELECT num_secu FROM hospitalisations WHERE medecin_id = :idMedecin)");
    $requetePatients->bindParam(':idMedecin', $idMedecinConnecte);
    $requetePatients->execute();

    // Récupération des résultats des patients
    $patients = $requetePatients->fetchAll(PDO::FETCH_ASSOC);

    // Affichage du tableau HTML
    echo "<table border='1'>";
    echo "<tr><th>Date Hospitalisation</th><th>Heure Intervention</th><th>Type Hospitalisation</th><th>Numéro de Sécurité Sociale</th><th>Nom</th><th>Prénom</th><th>Date de Naissance</th></tr>";

    // Traitement des résultats
    foreach ($hospitalisations as $hospitalisation) {
        // Afficher chaque hospitalisation dans une ligne de tableau
        echo "<tr>";
        echo "<td>" . $hospitalisation['date_hospitalisation'] . "</td>";
        echo "<td>" . $hospitalisation['heure_intervention'] . "</td>";
        echo "<td>" . $hospitalisation['type'] . "</td>";
        echo "<td>" . $hospitalisation['num_secu'] . "</td>";

        // Recherche du patient correspondant
        foreach ($patients as $patient) {
            if ($patient['num_secu'] == $hospitalisation['num_secu']) {
                echo "<td>" . $patient['nom_naissance'] . "</td>";
                echo "<td>" . $patient['prenom'] . "</td>";
                echo "<td>" . $patient['date_naissance'] . "</td>";
                break;
            }
        }

        echo "</tr>";
    }

    echo "</table>";

} catch(PDOException $e) {
    // Gérer les exceptions PDO
    echo "Erreur de connexion à la base de données: " . $e->getMessage();
}

// Fermeture de la connexion à la base de données
$connexion = null;
?>
</body>
</html>
