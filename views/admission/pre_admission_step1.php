<!DOCTYPE html>
<html>


<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link rel="stylesheet" href="/static/css/secretaire.css">
    <script src="/static/js/forms_checks/generic.js" defer></script>
</head>

<body>

    <img src="/images/LPFS_logo.png" alt="" class="logo">
    <img src="/images/derou2.png" alt="" class="derou2">


    <form action="./pre_admission_step2.php" method="post">
        <?php
        include("../../lib/relay_post.php");
        ?>
        <p id="form-error"></p>
        <!-- Partie identité -->
        <label for="civilite">Civilité</label>
        <select name="civilite" required>
            <?php
            require_once("../../lib/config.php");
            $stmt = $db->prepare("SELECT * from `civilite`");
            $result = $stmt->execute();
            $rows = $stmt->fetchAll();

            foreach ($rows as $row) {
                extract($row);
                echo "<option value='$id'>$civilite</option>";
            }
            ?>
        </select>
        <label for="nom_naissance">Nom de naissance</label>
        <input type="text" name="nom_naissance" required />
        <label for="prenom">Prénom</label>
        <input type="text" name="prenom" required />
        <label for="nom_epouse">Nom d'épouse</label>
        <input type="text" name="nom_epouse" />
        <label for="date_naissance">Date de naissance</label>
        <input type="date" name="date_naissance" required />
        <!-- Spécial -->
        <label for="mineur">Mineur ?</label>
        <input type="checkbox" name="mineur" />
        <label for="parents_divorces">Parents divorvés ?</label>
        <input type="checkbox" name="parents_divorces" />
        <!-- Fin spécial -->
        <label for="adresse">Adresse</label>
        <input type="text" name="adresse" required />
        <label for="code_postal">Code Postal</label>
        <input type="text" class="numbers" name="code_postal" required />
        <label for="ville">Ville</label>
        <input type="text" name="ville" required />
        <label for="mail">Email</label>
        <input type="email" name="mail" required />
        <label for="telephone">Téléphone</label>
        <input type="tel" class="numbers" name="telephone" required />
        <input type="submit" class="bouton">
    </form>


</body>

</html>