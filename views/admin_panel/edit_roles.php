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

    <title>Modifier un role</title>
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

    // Traitement des données soumises par le formulaire de modification
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $intitule_poste = $_POST["intitule_poste"];
        $id = $_POST["produit"];

        // Vous pouvez ajouter la logique de mise à jour de la base de données ici
        // Utilisez la variable $id pour identifier le produit à mettre à jour

        // Exemple de requête SQL pour la mise à jour
        $updateSql = "UPDATE postes SET intitule_poste=? WHERE id=?";
        $updateStmt = $connexion->prepare($updateSql);

        if ($updateStmt) {
            $updateStmt->bind_param("si", $intitule_poste, $id);
            if ($updateStmt->execute()) {
                echo "Le role a été mis à jour avec succès.";
            } else {
                echo "Erreur lors de la mise à jour du role : " . $updateStmt->error;
            }
            $updateStmt->close();
        } else {
            echo "Erreur de préparation de la requête de mise à jour : " . $connexion->error;
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
                <img src="/static/images/LPFS_logo.png" alt="">
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

                <label for="intitule_poste">Nom du role :</label>
                <input type="text" id="intitule_poste" name="intitule_poste" required><br><br>

                <!-- Messages d'erreur -->
                <p id="error-nom" class="error-message"></p>
                <p id="error-prix" class="error-message"></p>


                <!-- Ajoutez d'autres champs ici si nécessaire -->

                <input type="submit" value="Mettre a jour le role" id="ajoute">

            </form>
            <a href="/views/admin_panel/panel.php"><i class="fa-solid fa-door-open" id="retour"></i></a>

        </div>

</body>

</html>