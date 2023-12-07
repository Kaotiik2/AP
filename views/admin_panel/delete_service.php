<?php
require_once "../../model/security.php";
global $SECURITY_ADMIN_LEVEL;

$SECURITY_ADMIN_LEVEL->authorize();
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="/static/css/role.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css" integrity="sha512-z3gLpd7yknf1YoNbCzqRKc4qyor8gaKU1qmn+CShxbuBusANI9QpRohGBreCFkKxLhei6S9CQXFEbbKuqLg0DA==" crossorigin="anonymous" referrerpolicy="no-referrer" />

    <title>Supprimer un service</title>
</head>
<body>

<?php
// Informations de connexion à la base de données
$serveur = "192.168.20.70:3306";
$utilisateur = "dev";
$motDePasse = "azerty1234+";
$baseDeDonnees = "LPFS";

// Connexion à la base de données
$connexion = new mysqli($serveur, $utilisateur, $motDePasse, $baseDeDonnees);

if ($connexion->connect_error) {
    die("Erreur de connexion à la base de données : " . $connexion->connect_error);
}

// Traitement des données soumises par le formulaire de suppression
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $id_service = $_POST["produit"];
    
    // Requête SQL pour supprimer le produit
    $deleteSql = "DELETE FROM services WHERE id_service=?";
    $deleteStmt = $connexion->prepare($deleteSql);

    if ($deleteStmt) {
        $deleteStmt->bind_param("i", $id_service);
        if ($deleteStmt->execute()) {
            echo "Le service a été supprimé avec succès.";
        } else {
            echo "Erreur lors de la suppression du service : " . $deleteStmt->error;
        }        
        $deleteStmt->close();
    } else {
        echo "Erreur de préparation de la requête de suppression : " . $connexion->error;
    }
}

// Récupérer tous les postes de la base de données
$services = array(); // Tableau pour stocker les services

$sql = "SELECT id_service, nom_service FROM services";
$result = $connexion->query($sql);

if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $services[] = $row;
    }
}

// Fermeture de la connexion à la base de données
$connexion->close();
?>

<div class="mainscreen">

<div class="card">

  <div class="leftside">
    <img src="/static/images/LPFS_logo.png" alt="">
  </div>

  <h2 class="titre_form">Formulaire de modification de service</h2> 
<form method="post" class="formulaire" onsubmit="return validateForm();">
    <label for="produit">Sélectionnez un service :</label>
    <select id="produit" name="produit">
        <?php
        foreach ($services as $service) {
            $serviceId = $service['id_service'];
            $serviceNom = $service['nom_service'];
            echo "<option value='$serviceId'>$serviceNom</option>";
        }
        ?>
    </select>
    <br><br>

    <input type="submit" value="Supprimer le service" id="ajoute">
</form>

<a href="/views/admin_panel/panel.php" ><i class="fa-solid fa-door-open" id="retour"></i></a>

</div>

</body>
</html>

