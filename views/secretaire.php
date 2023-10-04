<!DOCTYPE html>
<html>


<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link rel="stylesheet" href="/static/css/secretaire.css">
</head>

<body>
    <img src="/static/images/LPFS_logo.png" alt="" class="logo">
    <img src="/static/images/derou1.png" alt="" class="derou1">

    <form action="./admission/pre_admission_step1.php" method="post">
        <!-- Partie dates/médecin -->
        <label for="admission_type">Type d'admission :</label>
        <select name="admission_type" required>
            <?php
            require_once("../lib/config.php");
            $stmt = $db->prepare("SELECT * from `type_hospitalisation`");
            $result = $stmt->execute();
            $rows = $stmt->fetchAll();

            foreach ($rows as $row) {
                extract($row);
                echo "<option value='$id'>$type</option>";
            }
            ?>
        </select>
        <label for="admission_date">Date d'admission :</label>
        <input type="date" name="admission_date" required /> <!--TODO: Vérifier que la date n'est pas passée au moment de l'inscription -->
        <label for="admission_time">Heure de l'intervention :</label>
        <input type="time" name="admission_time" required /> <!--TODO: Vérifier que l'heure n'est pas passée au moment de l'inscription -->
        <label for="nom_medecin">Nom du médecin :</label>
        <select name="nom_medecin">
            <?php
            $stmt = $db->prepare("SELECT * from `medecins`");
            $result = $stmt->execute();
            $rows = $stmt->fetchAll();

            foreach ($rows as $row) {
                extract($row);
                echo "<option value='$id'>$nom $prenom</option>";
            }
            ?>
        </select>

        <input type="submit" class="bouton">
    </form>
</body>

</html>