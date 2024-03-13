<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Hospitalisations futures</title>
    <link rel="stylesheet" href="/static/css/afficher_admission.css">
</head>
<body>
<?php
include '../../lib/config.php'; // Inclure le fichier de configuration pour la connexion à la base de données

// Récupérer l'objet PDO pour interagir avec la base de données
function get_db() {
    $host = 'localhost:8889';
    $dbname = 'LPFS';
    $username = 'root';
    $password = 'root';
    try {
        $db = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);
        // Définir le mode d'erreur de PDO sur Exception
        $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        return $db;
    } catch(PDOException $e) {
        echo "Erreur de connexion à la base de données: " . $e->getMessage();
        exit;
    }
}

$db = get_db();

// Définir la date d'aujourd'hui
$aujourdhui = date("Y-m-d");

// Préparer la requête SQL pour sélectionner les hospitalisations futures
$sql = "SELECT num_secu, date_hospitalisation, heure_intervention, type_hospitalisation, id FROM hospitalisations WHERE date_hospitalisation >= :aujourdhui ORDER BY date_hospitalisation ASC, heure_intervention ASC";

// Préparer la requête
$stmt = $db->prepare($sql);

// Lier le paramètre
$stmt->bindParam(':aujourdhui', $aujourdhui);

// Exécuter la requête
$stmt->execute();

// Vérifier si la requête retourne des résultats
if ($stmt->rowCount() > 0) {
    // Début du tableau
    echo "<table border='1'><tr><th>ID</th><th>Numéro de Sécurité Sociale</th><th>Date d'Hospitalisation</th><th>Heure d'Intervention</th><th>Type d'Hospitalisation</th></tr>";
    // Récupérer et afficher chaque ligne de résultat
    while($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
        echo "<tr><td>".$row["id"]."</td><td>".$row["num_secu"]."</td><td>".$row["date_hospitalisation"]."</td><td>".$row["heure_intervention"]."</td><td>".$row["type_hospitalisation"]."</td></tr>";
    }
    echo "</table>";
} else {
    echo "Aucune hospitalisation future trouvée.";
}
?>
</body>
</html>
