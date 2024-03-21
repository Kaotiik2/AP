<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Hospitalisations futures</title>
    <link rel="stylesheet" href="/static/css/afficher_admission.css">
</head>
<body>
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
    $num_secu_list = $_POST['num_secu'] ?? [];
    $date_hospitalisation_list = $_POST['date_hospitalisation'] ?? [];
    $heure_intervention_list = $_POST['heure_intervention'] ?? [];
    $type_hospitalisation_list = $_POST['type_hospitalisation'] ?? [];
    $medecin_id_list = $_POST['medecin_id'] ?? [];
    
    try {
        // Connexion à la base de données
        $db = get_db();
        
        // Parcourir les données postées et mettre à jour chaque hospitalisation
        for ($i = 0; $i < count($num_secu_list); $i++) {
            $num_secu = $num_secu_list[$i];
            $date_hospitalisation = $date_hospitalisation_list[$i];
            $heure_intervention = $heure_intervention_list[$i];
            $type_hospitalisation = $type_hospitalisation_list[$i];
            $medecin_id = $medecin_id_list[$i];
            
            // Préparation de la requête SQL pour mettre à jour l'hospitalisation
            $sql = "UPDATE hospitalisations SET date_hospitalisation = :date_hospitalisation, heure_intervention = :heure_intervention, type_hospitalisation = :type_hospitalisation, medecin_id = :medecin_id WHERE num_secu = :num_secu";
            $stmt = $db->prepare($sql);
            
            // Liaison des valeurs
            $stmt->bindParam(':num_secu', $num_secu);
            $stmt->bindParam(':date_hospitalisation', $date_hospitalisation);
            $stmt->bindParam(':heure_intervention', $heure_intervention);
            $stmt->bindParam(':type_hospitalisation', $type_hospitalisation);
            $stmt->bindParam(':medecin_id', $medecin_id);
            
            // Exécution de la requête
            $stmt->execute();
        }
        
        // Affichage d'un message de succès
        echo "Hospitalisations modifiées avec succès.";
    } catch(PDOException $e) {
        // Gestion des erreurs
        echo "Erreur lors de la modification des hospitalisations: " . $e->getMessage();
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

$sql = "SELECT h.num_secu, h.date_hospitalisation, h.heure_intervention, h.type_hospitalisation, h.medecin_id FROM hospitalisations h WHERE h.date_hospitalisation >= :aujourdhui ORDER BY h.date_hospitalisation ASC, h.heure_intervention ASC";

$stmt = $db->prepare($sql);
$stmt->bindParam(':aujourdhui', $aujourdhui);
$stmt->execute();

if ($stmt->rowCount() > 0) {
    echo "<form method='post'>";
    echo "<table border='1'><tr><th>Numéro de Sécurité Sociale</th><th>Date d'Hospitalisation</th><th>Heure d'Intervention</th><th>Type d'Hospitalisation</th><th>Médecin</th><th>Actions</th></tr>";
    while($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
        echo "<tr><td><input type='text' name='num_secu[]' value='".$row["num_secu"]."' disabled></td><td><input type='text' name='date_hospitalisation[]' value='".$row["date_hospitalisation"]."' disabled></td><td><input type='text' name='heure_intervention[]' value='".$row["heure_intervention"]."' disabled></td><td><input type='text' name='type_hospitalisation[]' value='".$row["type_hospitalisation"]."' disabled></td><td><select name='medecin_id[]' disabled>";
        foreach ($medecins as $medecin) {
            $selected = ($row["medecin_id"] == $medecin["id_medecin"]) ? "selected" : "";
            echo "<option value='".$medecin['id_medecin']."' $selected>".$medecin['nom_complet']."</option>";
        }
        echo "</select></td><td><button type='button' onclick='enableEdit(this)'>Modifier</button></td></tr>";
    }
    echo "</table>";
    echo "<button type='submit' name='action' value='modifier'>Enregistrer</button>";
    echo "</form>";
} else {
    echo "Aucune hospitalisation future trouvée.";
}
?>
<script>
function enableEdit(button) {
    var row = button.parentNode.parentNode;
    var inputs = row.querySelectorAll('input[type="text"]');
    var selects = row.querySelectorAll('select');
    for(var i = 0; i < inputs.length; i++) {
        inputs[i].disabled = !inputs[i].disabled;
    }
    for(var i = 0; i < selects.length; i++) {
        selects[i].disabled = !selects[i].disabled;
    }
}
</script>
</body>
</html>
