<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Hospitalisations futures</title>
    <link rel="stylesheet" href="/static/css/afficher_admission.css">
</head>
<body>
<div class="container">
    <div class="logo">
    <img src="/static/images/LPFS_logo.png" alt="Logo de votre site" class="logoimg">
    </div>
<div class="content">

<h1>Prochaine Admissions</h1>
<?php
include '../../lib/config.php';

function get_db() {
    $host = 'localhost:8889';
    $dbname = 'LPFS';
    $username = 'root';
    $password = 'root';
    try {
        $db = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);
        $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        return $db;
    } catch(PDOException $e) {
        echo "Erreur de connexion à la base de données: " . $e->getMessage();
        exit;
    }
}

if(isset($_POST['action']) && $_POST['action'] == 'modifier') {
    // Récupérer les données postées
    $num_secu = $_POST['num_secu'] ?? '';
    $date_hospitalisation = $_POST['date_hospitalisation'] ?? '';
    $heure_intervention = $_POST['heure_intervention'] ?? '';
    $type_hospitalisation = $_POST['type_hospitalisation'] ?? '';
    $medecin_id = $_POST['medecin_id'] ?? '';
    $id = $_POST['id'] ?? ''; // Utilisation de l'identifiant 'id'
    
    try {
        // Connexion à la base de données
        $db = get_db();
        
        // Préparation de la requête SQL pour mettre à jour l'hospitalisation
        $sql = "UPDATE hospitalisations SET date_hospitalisation = :date_hospitalisation, heure_intervention = :heure_intervention, type_hospitalisation = :type_hospitalisation, medecin_id = :medecin_id WHERE num_secu = :num_secu AND id = :id"; // Modification de la requête pour utiliser également l'identifiant 'id'
        $stmt = $db->prepare($sql);
        
        // Liaison des valeurs
        $stmt->bindParam(':num_secu', $num_secu);
        $stmt->bindParam(':date_hospitalisation', $date_hospitalisation);
        $stmt->bindParam(':heure_intervention', $heure_intervention);
        $stmt->bindParam(':type_hospitalisation', $type_hospitalisation);
        $stmt->bindParam(':medecin_id', $medecin_id);
        $stmt->bindParam(':id', $id); // Liaison de l'identifiant 'id'
        
        // Exécution de la requête
        $stmt->execute();
        
        // Affichage d'un message de succès
        echo "<p class='success-message'>Hospitalisation modifiée avec succès.</p>";

    } catch(PDOException $e) {
        // Gestion des erreurs
        echo "Erreur lors de la modification de l'hospitalisation: " . $e->getMessage();
    }
}

if(isset($_POST['action']) && $_POST['action'] == 'supprimer') {
    $id = $_POST['id'] ?? '';
    
    try {
        // Connexion à la base de données
        $db = get_db();
        
        // Préparation de la requête SQL pour supprimer l'hospitalisation
        $sql = "DELETE FROM hospitalisations WHERE id = :id";
        $stmt = $db->prepare($sql);
        $stmt->bindParam(':id', $id);
        
        // Exécution de la requête
        $stmt->execute();
        
        // Affichage d'un message de succès
        echo "<p class='success-message'>Hospitalisation supprimée avec succès.</p>";
        
    } catch(PDOException $e) {
        // Gestion des erreurs
        echo "Erreur lors de la suppression de l'hospitalisation: " . $e->getMessage();
    }
}


$aujourdhui = date("Y-m-d");

$sql_medecins = "SELECT id_medecin, CONCAT(prenom, ' ', nom) AS nom_complet FROM medecins";
$db = get_db();
$stmt_medecins = $db->prepare($sql_medecins);
$stmt_medecins->execute();

if ($stmt_medecins->rowCount() > 0) {
    $medecins = $stmt_medecins->fetchAll(PDO::FETCH_ASSOC);
} else {
    $medecins = array();
}

// Modifier la requête SQL pour récupérer les types d'hospitalisation depuis la table 'type_hospitalisation'
$sql_types_hospitalisation = "SELECT id, type FROM type_hospitalisation";
$stmt_types_hospitalisation = $db->prepare($sql_types_hospitalisation);
$stmt_types_hospitalisation->execute();

if ($stmt_types_hospitalisation->rowCount() > 0) {
    $types_hospitalisation = $stmt_types_hospitalisation->fetchAll(PDO::FETCH_ASSOC);
} else {
    $types_hospitalisation = array();
}

$sql = "SELECT h.id, h.num_secu, h.date_hospitalisation, h.heure_intervention, h.type_hospitalisation, h.medecin_id FROM hospitalisations h WHERE h.date_hospitalisation >= :aujourdhui ORDER BY h.date_hospitalisation ASC, h.heure_intervention ASC";

$stmt = $db->prepare($sql);
$stmt->bindParam(':aujourdhui', $aujourdhui);
$stmt->execute();

if ($stmt->rowCount() > 0) {
    echo "<table>";
    echo "<tr>";
    echo "<th>Date d'hospitalisation</th>";
    echo "<th>Heure d'intervention</th>";
    echo "<th>Type d'hospitalisation</th>";
    echo "<th>Nom du médecin</th>";
    echo "<th>Action</th>"; // Entête de la colonne Action
    echo "</tr>";
    while($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
        // Chaque admission est dans son propre formulaire avec un identifiant unique
        echo "<form method='post'>";
        echo "<tr>";
        echo "<input type='hidden' name='num_secu' value='".$row["num_secu"]."'>";
        echo "<input type='hidden' name='id' value='".$row["id"]."'>"; // Ajouter un champ pour l'identifiant 'id'
        echo "<td><input type='date' name='date_hospitalisation' value='".$row["date_hospitalisation"]."'></td>";
        echo "<td><input type='time' name='heure_intervention' value='".$row["heure_intervention"]."'></td>";
        // Modifier la partie du formulaire pour afficher un menu déroulant des types d'hospitalisation
        echo "<td><select name='type_hospitalisation'>";
        foreach ($types_hospitalisation as $type) {
            $selected = ($row["type_hospitalisation"] == $type["id"]) ? "selected" : "";
            echo "<option value='".$type['id']."' $selected>".$type['type']."</option>";
        }
        echo "</select></td>";
        echo "<td><select name='medecin_id'>";
        foreach ($medecins as $medecin) {
            $selected = ($row["medecin_id"] == $medecin["id_medecin"]) ? "selected" : "";
            echo "<option value='".$medecin['id_medecin']."' $selected>".$medecin['nom_complet']."</option>";
        }
        echo "</select></td>";


        echo "<td><button type='submit' name='action' value='modifier'>Modifier</button></td>";
        echo "<td><button type='submit' name='action' value='supprimer'>Supprimer</button></td>"; // Ajout du bouton Supprimer

        


        echo "</tr>";
        echo "</form>"; // Fermer le formulaire ici
    }
    echo "</table>";
} else {
    echo "Aucune hospitalisation future trouvée.";
}


?>
</div>
</div>
</body>
</html>
