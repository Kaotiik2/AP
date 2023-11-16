<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="/AP-master/static/css/role.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css" integrity="sha512-z3gLpd7yknf1YoNbCzqRKc4qyor8gaKU1qmn+CShxbuBusANI9QpRohGBreCFkKxLhei6S9CQXFEbbKuqLg0DA==" crossorigin="anonymous" referrerpolicy="no-referrer" />

    <title>Supprimer un role</title>
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
    $id = $_POST["produit"];
    
    // Requête SQL pour supprimer le produit
    $deleteSql = "DELETE FROM postes WHERE id=?";
    $deleteStmt = $connexion->prepare($deleteSql);

    if ($deleteStmt) {
        $deleteStmt->bind_param("i", $id);
        if ($deleteStmt->execute()) {
            echo "Le role a été supprimé avec succès.";
        } else {
            echo "Erreur lors de la suppression du role : " . $deleteStmt->error;
        }
        $deleteStmt->close();
    } else {
        echo "Erreur de préparation de la requête de suppression : " . $connexion->error;
    }
}

// Récupérer tous les postes de la base de données
$postes = array(); // Tableau pour stocker les postes

$sql = "SELECT id, intitule_poste FROM postes";
$result = $connexion->query($sql);

if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $postes[] = $row;
    }
}

// Fermeture de la connexion à la base de données
$connexion->close();
?>

<div class="mainscreen">

<div class="card">

  <div class="leftside">
    <img src="/AP-master/static/images/LPFS_logo.png" alt="">
  </div>

  <h2 class="titre_form">Formulaire de modification de role</h2> 
<form method="post" class="formulaire" onsubmit="return validateForm();">
    <label for="produit">Sélectionnez un role :</label>
    <select id="produit" name="produit">
        <?php
        foreach ($postes as $poste) {
            $posteId = $poste['id'];
            $posteNom = $poste['intitule_poste'];
            echo "<option value='$posteId'>$posteNom</option>";
        }
        ?>
    </select>
    <br><br>

    <input type="submit" value="Supprimer le role" id="ajoute">
</form>

<a href="/AP-master/views/admin_panel/panel.php" ><i class="fa-solid fa-door-open" id="retour"></i></a>

</div>

</body>
</html>

