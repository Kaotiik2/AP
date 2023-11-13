<!DOCTYPE html>
<html>


<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link rel="stylesheet" href="/static/css/secretaire.css">
    <link rel="stylesheet" href="/static/css/style.css" />
    <script src="/static/js/forms_checks/generic.js" defer></script>
    <script src="/static/js/forms_checks/pre_admission/form-1-check.js" defer></script>
</head>

<body>
    <img src="/static/images/LPFS_logo.png" alt="" class="logo">
    <img src="/static/images/derou2.png" alt="" class="derou2">


    <form action="./pre_admission_step2.php" method="post" id="pre-admission-form-1">
        <?php

        use lib\utils;

        utils\relay_post();
        ?>
        <p id="form-error" class="invalid"></p>
        <!-- Partie identité -->
        <label for="civilite">Civilité</label>
        <select name="civilite" required>
            <?php

            use lib\db;

            $db = db\get_db();
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