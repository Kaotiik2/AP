<?php
require_once "../../model/security.php";
global $SECURITY_SECRETARY_LEVEL;

$SECURITY_SECRETARY_LEVEL->authorize();
?>

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

<h1>Prochaine Hospitalisations</h1>
<?php

try {
    // Connexion à la base de données avec PDO
    $host = '192.168.20.20';
    $dbname = 'LPFS';
    $username = 'root';
    $password = 'sio2021';
    $db = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);
    $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // Requête SQL pour récupérer les données des hospitalisations futures
    $aujourdhui = date("Y-m-d");
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
        echo "<th>Médecin</th>";
        echo "<th>Action</th>";
        echo "</tr>";
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            echo "<tr>";
            echo "<td>".$row['date_hospitalisation']."</td>";
            echo "<td>".$row['heure_intervention']."</td>";
            echo "<td>".$row['type_hospitalisation']."</td>";
            
            // Récupération du nom du médecin
            $medecin_id = $row['medecin_id'];
            $sql_medecin = "SELECT CONCAT(prenom, ' ', nom) AS nom_complet FROM medecins WHERE id_medecin = :medecin_id";
            $stmt_medecin = $db->prepare($sql_medecin);
            $stmt_medecin->bindParam(':medecin_id', $medecin_id);
            $stmt_medecin->execute();
            $medecin = $stmt_medecin->fetch(PDO::FETCH_ASSOC);
            echo "<td>".$medecin['nom_complet']."</td>";

            echo "<td>";
            echo "<form method='post'>";
            echo "<input type='hidden' name='id' value='".$row['id']."'>";
            echo "<button type='submit' name='action' value='modifier'>Modifier</button>";
            echo "<button type='submit' name='action' value='supprimer'>Supprimer</button>";
            echo "</form>";
            echo "</td>";
            echo "</tr>";
        }
        echo "</table>";
    } else {
        echo "Aucune hospitalisation future trouvée.";
    }

} catch(PDOException $e) {
    echo "Erreur de connexion à la base de données: " . $e->getMessage();
}

?>
</div>
</div>
</body>
</html>
