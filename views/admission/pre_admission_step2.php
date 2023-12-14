<?php
require_once "../../model/security.php";
global $SECURITY_SECRETARY_LEVEL;

$SECURITY_SECRETARY_LEVEL->authorize();
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    <script src="/static/js/forms_checks/pre_admission/form-2-check.js" defer></script>
</head>

<body class="bg-white">
    <img src="/static/images/LPFS_logo.png" alt="LPFS Logo" class="mx-auto my-8 w-96">
    <img src="/static/images/derou3.png" alt="Derou3" class="mx-auto mb-8 w-128">

    <form action="./pre_admission_step3.php" method="post" id="pre-admission-form-2" class="max-w-md mx-auto bg-white p-8 rounded shadow-md">
        <?php
        require_once "../../lib/relay_post.php";
        require_once "../../lib/config.php";

        use lib\utils;

        utils\relay_post();
        ?>
        <p id="form-error" class="invalid"></p>

        <!-- Partie sécu -->
        <div class="mb-4">
            <label for="caisse_secu" class="block text-sm font-semibold text-gray-600">Organisme de sécurité sociale/
                Nom de la Caisse de sécurité sociale</label>
            <input type="text" name="caisse_secu" required class="w-full p-2 border border-gray-300 rounded focus:outline-none focus:border-blue-500" />
        </div>
        <div class="mb-4">
            <label for="num_secu" class="block text-sm font-semibold text-gray-600">Numéro de sécurité sociale</label>
            <input type="text" name="num_secu" required class="w-full p-2 border border-gray-300 rounded focus:outline-none focus:border-blue-500" />
        </div>
        <div class="mb-4">
            <label for="est_assure" class="block text-sm font-semibold text-gray-600">Le patient est-il assuré ?</label>
            <select name="est_assure" required class="w-full p-2 border border-gray-300 rounded focus:outline-none focus:border-blue-500">
                <option value="1">Oui</option>
                <option value="0">Non</option>
            </select>
        </div>
        <div class="mb-4">
            <label for="ald" class="block text-sm font-semibold text-gray-600">Le patient est-il en ALD ?</label>
            <select name="ald" required class="w-full p-2 border border-gray-300 rounded focus:outline-none focus:border-blue-500">
                <option value="0">Non</option>
                <option value="1">Oui</option>
            </select>
        </div>
        <div class="mb-4">
            <label for="nom_mutuelle" class="block text-sm font-semibold text-gray-600">Nom de la mutuelle ou de
                l'assurance</label>
            <input type="text" name="nom_mutuelle" class="w-full p-2 border border-gray-300 rounded focus:outline-none focus:border-blue-500" />
        </div>
        <div class="mb-4">
            <label for="numero_adherent_mutuelle" class="block text-sm font-semibold text-gray-600">Numéro
                d'adhérent</label>
            <input type="text" name="numero_adherent_mutuelle" class="w-full p-2 border border-gray-300 rounded focus:outline-none focus:border-blue-500" />
        </div>
        <div class="mb-4">
            <label for="type_chambre" class="block text-sm font-semibold text-gray-600">Chambre particulière
                ?</label>
            <select name="type_chambre" required class="w-full p-2 border border-gray-300 rounded focus:outline-none focus:border-blue-500">
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
        </div>
        <input type="submit" class="w-full p-2 bg-blue-500 text-white rounded cursor-pointer" />
    </form>
</body>

</html>