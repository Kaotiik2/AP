<?php

require_once "../../model/security.php";
global $SECURITY_SECRETARY_LEVEL;

$SECURITY_SECRETARY_LEVEL->authorize();
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
</head>

<body class="bg-white">
    <img src="/static/images/LPFS_logo.png" alt="LPFS Logo" class="mx-auto my-8 w-96">
    <img src="/static/images/derou4.png" alt="Derou4" class="mx-auto mb-8 w-128">

    <form action="./pre_admission_step4.php" method="post" enctype="multipart/form-data" class="max-w-lg mx-auto mt-8 p-8 bg-white rounded-lg shadow-md">
        <?php
        require_once "../../lib/relay_post.php";
        require_once "../../lib/config.php";

        use lib\utils;

        utils\relay_post();
        ?>

        <div>
            <div id="trusted-person">
                <h2 class="text-xl font-semibold mb-4">Informations d'une personne de confiance</h2>
                <div class="grid grid-cols-2 gap-4">
                    <input type="text" name="pc_nom" required maxlength="100" placeholder="Nom" class="p-2 border rounded">
                    <input type="text" name="pc_prenom" required maxlength="100" placeholder="Prénom" class="p-2 border rounded">
                    <input type="text" name="pc_adresse" required maxlength="200" placeholder="Adresse" class="p-2 border rounded">
                    <input type="tel" name="pc_telephone" required maxlength="15" placeholder="Téléphone" class="p-2 border rounded">
                </div>
            </div>

            <div id="prevent-person" class="mt-4 rounded">
                <h2 class="text-xl font-semibold mb-4">Informations d'une personne à prévenir</h2>
                <div class="grid grid-cols-2 gap-4">
                    <input type="text" name="pp_nom" required maxlength="100" placeholder="Nom" class="p-2 border rounded">
                    <input type="text" name="pp_prenom" required maxlength="100" placeholder="Prénom" class="p-2 border rounded">
                    <input type="text" name="pp_adresse" required maxlength="200" placeholder="Adresse" class="p-2 border rounded">
                    <input type="tel" name="pp_telephone" required maxlength="15" placeholder="Téléphone" class="p-2 border rounded">
                </div>
            </div>
        </div>

        <input type="submit" class="w-full p-2 bg-blue-500 text-white rounded cursor-pointer" />
    </form>
</body>

</html>