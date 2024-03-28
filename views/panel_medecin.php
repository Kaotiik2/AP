<?php
// Informations de connexion à la base de données
$serveur = "localhost:8889";
$nomUtilisateur = "root";
$motDePasse = "root";
$nomBaseDeDonnees = "LPFS";

require_once "../model/users.php";
use model\User;

$medecin = User::from_session();

// Supposons que $idMedecinConnecte contient l'ID du médecin connecté
$idMedecinConnecte = $medecin->id_user;

try {
    // Connexion à la base de données
    $connexion = new PDO("mysql:host=$serveur;dbname=$nomBaseDeDonnees", $nomUtilisateur, $motDePasse);
    $connexion->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // Préparation de la requête SQL pour sélectionner les hospitalisations du médecin connecté avec les informations des patients
    $requete = $connexion->prepare("SELECT hospitalisations.id, hospitalisations.date_hospitalisation, hospitalisations.heure_intervention, hospitalisations.type_hospitalisation, patients.* FROM hospitalisations INNER JOIN patients ON hospitalisations.num_secu = patients.num_secu WHERE hospitalisations.medecin_id = :idMedecin");
    $requete->bindParam(':idMedecin', $idMedecinConnecte);
    $requete->execute();

    // Récupération des résultats
    $hospitalisations = $requete->fetchAll(PDO::FETCH_ASSOC);

    // Affichage du tableau HTML
    echo "<table border='1'>";
    echo "<tr><th>ID Hospitalisation</th><th>Date Hospitalisation</th><th>Heure Intervention</th><th>Type Hospitalisation</th><th>Informations Patient</th></tr>";

    // Traitement des résultats
    foreach ($hospitalisations as $hospitalisation) {
        // Afficher chaque hospitalisation dans une ligne de tableau
        echo "<tr>";
        echo "<td>" . $hospitalisation['id'] . "</td>";
        echo "<td>" . $hospitalisation['date_hospitalisation'] . "</td>";
        echo "<td>" . $hospitalisation['heure_intervention'] . "</td>";
        echo "<td>" . $hospitalisation['type_hospitalisation'] . "</td>";
        echo "<td>";
        // Afficher les informations du patient associé à l'hospitalisation
        echo "Numéro de Sécurité Sociale: " . $hospitalisation['num_secu'] . ", Nom: " . $hospitalisation['nom_naissance'] . ", Prénom: " . $hospitalisation['prenom'] . ", Date de Naissance: " . $hospitalisation['date_naissance'];
        // Vous pouvez ajouter d'autres informations du patient ici
        echo "</td>";
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
