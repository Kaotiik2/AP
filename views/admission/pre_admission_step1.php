<?php
require_once "../../model/security.php";
global $SECURITY_SECRETARY_LEVEL;

$SECURITY_SECRETARY_LEVEL->authorize();
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    <script src="/static/js/forms_checks/generic.js" defer></script>
    <script src="/static/js/forms_checks/pre_admission/form-1-check.js" defer></script>
</head>

<body class="bg-white">
    <img src="/static/images/LPFS_logo.png" alt="LPFS Logo" class="mx-auto my-8 w-96">
    <img src="/static/images/derou2.png" alt="Derou2" class="mx-auto mb-8 w-128">

    <form action="./pre_admission_step2.php" method="post" id="pre-admission-form-1" class="max-w-md mx-auto bg-white p-8 rounded shadow-md">
        <?php
        require_once "../../lib/relay_post.php";
        require_once "../../lib/config.php";

        use lib\utils;

        utils\relay_post();
        ?>
        <p id="form-error" class="invalid"></p>
        <!-- Partie identité -->
        <div class="mb-4">
            <label for="civilite" class="block text-sm font-semibold text-gray-600">Civilité</label>
            <select name="civilite" required class="w-full p-2 border border-gray-300 rounded focus:outline-none focus:border-blue-500">
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
        </div>
        <div class="mb-4">
            <label for="nom_naissance" class="block text-sm font-semibold text-gray-600">Nom de naissance</label>
            <input type="text" name="nom_naissance" required class="w-full p-2 border border-gray-300 rounded focus:outline-none focus:border-blue-500" />
        </div>
        <div class="mb-4">
            <label for="prenom" class="block text-sm font-semibold text-gray-600">Prénom</label>
            <input type="text" name="prenom" required class="w-full p-2 border border-gray-300 rounded focus:outline-none focus:border-blue-500" />
        </div>
        <div class="mb-4">
            <label for="nom_epouse" class="block text-sm font-semibold text-gray-600">Nom d'épouse</label>
            <input type="text" name="nom_epouse" class="w-full p-2 border border-gray-300 rounded focus:outline-none focus:border-blue-500" />
        </div>
        <div class="mb-4">
            <label for="date_naissance" class="block text-sm font-semibold text-gray-600">Date de naissance</label>
            <input type="date" name="date_naissance" required class="w-full p-2 border border-gray-300 rounded focus:outline-none focus:border-blue-500" />
        </div>
        <!-- Spécial -->
        <div class="mb-4">
            <label for="mineur" class="block text-sm font-semibold text-gray-600" value="on">Mineur ?</label>
            <input type="checkbox" name="mineur" />
        </div>
        <div class="mb-4">
            <label for="parents_divorces" class="block text-sm font-semibold text-gray-600">Parents divorvés
                ?</label>
            <input type="checkbox" name="parents_divorces" />
        </div>
        <!-- Fin spécial -->
        <div class="mb-4">
            <label for="adresse" class="block text-sm font-semibold text-gray-600">Adresse</label>
            <input type="text" name="adresse" required class="w-full p-2 border border-gray-300 rounded focus:outline-none focus:border-blue-500" />
        </div>
        <div class="mb-4">
            <label for="code_postal" class="block text-sm font-semibold text-gray-600">Code Postal</label>
            <input type="text" class="numbers" name="code_postal" required class="w-full p-2 border border-gray-300 rounded focus:outline-none focus:border-blue-500" />
        </div>
        <div class="mb-4">
            <label for="ville" class="block text-sm font-semibold text-gray-600">Ville</label>
            <input type="text" name="ville" required class="w-full p-2 border border-gray-300 rounded focus:outline-none focus:border-blue-500" />
        </div>
        <div class="mb-4">
            <label for="mail" class="block text-sm font-semibold text-gray-600">Email</label>
            <input type="email" name="mail" required class="w-full p-2 border border-gray-300 rounded focus:outline-none focus:border-blue-500" />
        </div>
        <div class="mb-4">
            <label for="telephone" class="block text-sm font-semibold text-gray-600">Téléphone</label>
            <input type="tel" class="numbers" name="telephone" required class="w-full p-2 border border-gray-300 rounded focus:outline-none focus:border-blue-500" />
        </div>
        <input type="submit" class="w-full p-2 bg-blue-500 text-white rounded cursor-pointer" />
    </form>
</body>

</html>