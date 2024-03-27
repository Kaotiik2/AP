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

    // Requête SQL pour récupérer les prochains rendez-vous du médecin connecté
    $requete = "SELECT m.nom AS nom_medecin, m.prenom AS prenom_medecin, h.date_hospitalisation, h.heure_intervention, h.type_hospitalisation, p.nom_naissance AS nom_patient, p.prenom AS prenom_patient
                FROM hospitalisations h
                JOIN medecins m ON h.medecin_id = m.id_medecin
                JOIN patients p ON h.id_patient = p.num_secu
                WHERE h.medecin_id = :idMedecinConnecte AND h.medecin_id = $idMedecinConnecte
                ORDER BY h.date_hospitalisation, h.heure_intervention";
    
    // Préparation de la requête
    $statement = $connexion->prepare($requete);
    
    // Liaison des paramètres
    $statement->bindParam(':idMedecinConnecte', $idMedecinConnecte, PDO::PARAM_INT);
    
    // Exécution de la requête
    $statement->execute();

    // Récupération des résultats
    $resultats = $statement->fetchAll(PDO::FETCH_ASSOC);

    // Affichage des résultats
    echo "<h1>Vos prochains rendez-vous :</h1>";
    echo "<table border='1'>";
    echo "<tr><th>Nom Médecin</th><th>Prénom Médecin</th><th>Date Hospitalisation</th><th>Heure Intervention</th><th>Type Hospitalisation</th><th>Nom Patient</th><th>Prénom Patient</th></tr>";
    foreach ($resultats as $row) {
        echo "<tr>";
        echo "<td>".$row['nom_medecin']."</td>";
        echo "<td>".$row['prenom_medecin']."</td>";
        echo "<td>".$row['date_hospitalisation']."</td>";
        echo "<td>".$row['heure_intervention']."</td>";
        echo "<td>".$row['type_hospitalisation']."</td>";
        echo "<td>".$row['nom_patient']."</td>";
        echo "<td>".$row['prenom_patient']."</td>";
        echo "</tr>";
    }
    echo "</table>";

} catch(PDOException $e) {
    // En cas d'erreur de connexion ou d'exécution de la requête
    echo "Erreur : " . $e->getMessage();
}

// Fermeture de la connexion à la base de données
$connexion = null;
?>
