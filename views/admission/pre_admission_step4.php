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

    <form action="/controller/pre_admission.php" method="post" enctype="multipart/form-data" class="max-w-md mx-auto bg-white p-8 rounded shadow-md">
        <?php
        require_once "../../lib/relay_post.php";
        require_once "../../lib/config.php";

        use lib\utils;

        utils\relay_post();
        ?>
        <div class="mb-4">
            <label for="ci_recto" class="block text-sm font-semibold text-gray-600">Carte d'identité (recto)</label>
            <input type="file" name="ci_recto" required class="w-full p-2 border border-gray-300 rounded focus:outline-none focus:border-blue-500" />
        </div>
        <div class="mb-4">
            <label for="ci_verso" class="block text-sm font-semibold text-gray-600">Carte d'identité (verso)</label>
            <input type="file" name="ci_verso" required class="w-full p-2 border border-gray-300 rounded focus:outline-none focus:border-blue-500" />
        </div>
        <div class="mb-4">
            <label for="carte_vitale" class="block text-sm font-semibold text-gray-600">Carte vitale</label>
            <input type="file" name="carte_vitale" required class="w-full p-2 border border-gray-300 rounded focus:outline-none focus:border-blue-500" />
        </div>
        <div class="mb-4">
            <label for="carte_mutuelle" class="block text-sm font-semibold text-gray-600">Carte mutuelle</label>
            <input type="file" name="carte_mutuelle" required class="w-full p-2 border border-gray-300 rounded focus:outline-none focus:border-blue-500" />
        </div>
        <?php
        if ($_POST["mineur"] == "on") {
            echo '<div class="mb-4">';
            echo '<label for="livret_famille" class="block text-sm font-semibold text-gray-600">Livret de famille</label>';
            echo '<input type="file" name="livret_famille" required class="w-full p-2 border border-gray-300 rounded focus:outline-none focus:border-blue-500" />';
            echo '</div>';

            echo '<div class="mb-4">';
            echo '<label for="autorisation_soin" class="block text-sm font-semibold text-gray-600">Autorisation de soin (si mineur)</label>';
            echo '<input type="file" name="autorisation_soin" required class="w-full p-2 border border-gray-300 rounded focus:outline-none focus:border-blue-500" />';
            echo '</div>';
        }
        if ($_POST["parents_divorces"] == "on") {
        ?>
            <div class="mb-4">
                <label for="monoparentalite_juge" class="block text-sm font-semibold text-gray-600">Décision de justice
                    (Monoparentalité)</label>
                <input type="file" name="monoparentalite_juge" required class="w-full p-2 border border-gray-300 rounded focus:outline-none focus:border-blue-500" />
            </div>
        <?php
        }
        ?>

        <input type="submit" class="w-full p-2 bg-blue-500 text-white rounded cursor-pointer" />
    </form>
</body>

</html>