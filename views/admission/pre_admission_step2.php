<!DOCTYPE html>
<html>


<head>
    <link rel="stylesheet" href="/static/css/secretaire.css" />
    <link rel="stylesheet" href="/static/css/style.css" />
    <script src="/static/js/forms_checks/pre_admission/form-2-check.js" defer></script>
</head>

<body>
    <img src="/static/images/LPFS_logo.png" alt="" class="logo">
    <img src="/static/images/derou3.png" alt="" class="derou2">

    <form action="pre_admission_step3.php" method="post" id="pre-admission-form-2">
        <?php

        use lib\utils;

        utils\relay_post();
        ?>
        <p id="form-error" class="invalid"></p>

        <!-- Partie sécu -->
        <label for="caisse_secu">Organisme de sécurité sociale/ Nom de la Caisse de sécurité sociale</label>
        <input type="text" name="caisse_secu" required />

        <label for="num_secu">Numéro de sécurité sociale</label>
        <input type="text" name="num_secu" required />

        <label for="est_assure">Le patient est-il assuré ?</label>
        <select name="est_assure" required>
            <option value="1">Oui</option>
            <option value="0">Non</option>
        </select>

        <label for="ald">Le patient est-il en ALD ?</label>
        <select name="ald" required>
            <option value="0">Non</option>
            <option value="1">Oui</option>
        </select>

        <label for="nom_mutuelle">Nom de la mutuelle ou de l'assurance</label>
        <input type="text" name="nom_mutuelle" />

        <label for="numero_adherent_mutuelle">Numéro d'adhérent</label>
        <input type="text" name="numero_adherent_mutuelle" />

        <label for="type_chambre">Chambre particulière ?</label>
        <select name="type_chambre" required>
            <?php

            use lib\db;

            $db = db\get_db();
            $stmt = $db->prepare("SELECT * from `type_chambre`");
            $result = $stmt->execute();
            $rows = $stmt->fetchAll();

            foreach ($rows as $row) {
                extract($row);
                echo "<option value='$id'>$type</option>";
            }
            ?>
        </select>
        <input type="submit" class="bouton" />
    </form>
</body>

</html>