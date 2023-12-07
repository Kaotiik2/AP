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

<form action="/controller/pre_admission.php" method="post" enctype="multipart/form-data"
      class="max-w-lg mx-auto mt-8 p-8 bg-white rounded-lg shadow-md">
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
                <input type="text" name="trusted_name" required maxlength="100" placeholder="Nom"
                       class="p-2 border rounded">
                <input type="text" name="trusted_surname" required maxlength="100" placeholder="Prénom"
                       class="p-2 border rounded">
                <input type="text" name="trusted_address" required maxlength="200" placeholder="Adresse"
                       class="p-2 border rounded">
                <input type="tel" name="trusted_phone" required maxlength="15" placeholder="Téléphone"
                       class="p-2 border rounded">
            </div>
        </div>

        <div id="prevent-person" class="mt-4 rounded">
            <h2 class="text-xl font-semibold mb-4">Informations d'une personne à prévenir</h2>
            <div class="grid grid-cols-2 gap-4">
                <input type="text" name="prevent_name" required maxlength="100" placeholder="Nom"
                       class="p-2 border rounded">
                <input type="text" name="prevent_surname" required maxlength="100" placeholder="Prénom"
                       class="p-2 border rounded">
                <input type="text" name="prevent_address" required maxlength="200" placeholder="Adresse"
                       class="p-2 border rounded">
                <input type="tel" name="prevent_phone" required maxlength="15" placeholder="Téléphone"
                       class="p-2 border rounded">
            </div>
        </div>
    </div>

    <input type="submit" class="w-full p-2 bg-blue-500 text-white rounded cursor-pointer" />
</form>
</body>

</html>
