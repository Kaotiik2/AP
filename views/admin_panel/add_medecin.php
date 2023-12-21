<?php
require_once "../../model/security.php";
global $SECURITY_ADMIN_LEVEL;

$SECURITY_ADMIN_LEVEL->authorize();
?>

<!DOCTYPE html>
<html lang="fr">

<head>
	<meta charset="UTF-8"/>
	<meta name="viewport" content="width=device-width, initial-scale=1.0"/>
	<meta http-equiv="X-UA-Compatible" content="ie=edge"/>
	<title>Ajouter un Médecin</title>
	<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css">
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css" integrity="sha512-z3gLpd7yknf1YoNbCzqRKc4qyor8gaKU1qmn+CShxbuBusANI9QpRohGBreCFkKxLhei6S9CQXFEbbKuqLg0DA==" crossorigin="anonymous" referrerpolicy="no-referrer" />

</head>

<body class="bg-gray-100 font-sans">
<div class="container mx-auto my-8">
	<div class="bg-white p-8 shadow-md rounded-md max-w-md mx-auto">
		<h1 class="text-2xl font-bold mb-6">Ajouter un Médecin</h1>

		<form action="/controller/action_medecin.php?action=create" method="post">
			<div class="mb-4">
				<label for="nom" class="block text-gray-700 text-sm font-semibold mb-2">Nom:</label>
				<input type="text" id="nom" name="nom" class="w-full border border-gray-300 p-2 rounded-md" required>
			</div>

			<div class="mb-4">
				<label for="prenom" class="block text-gray-700 text-sm font-semibold mb-2">Prénom:</label>
				<input type="text" id="prenom" name="prenom" class="w-full border border-gray-300 p-2 rounded-md" required>
			</div>

			<div class="mb-4">
				<label for="discipline" class="block text-gray-700 text-sm font-semibold mb-2">Discipline:</label>
				<input type="number" id="discipline" name="discipline" class="w-full border border-gray-300 p-2 rounded-md" required>
			</div>

			<div class="mb-4">
				<label for="nom_service" class="block text-gray-700 text-sm font-semibold mb-2">Nom du Service:</label>
				<select name="nom_service" id="nom_service" class="w-full border border-gray-300 p-2 rounded-md" required>
                    <?php
                    require_once "../../model/services.php";
                    use model\Service;

                    $services = Service::all_services();
                    foreach ($services as $service) {
                        echo "<option value=\"" . $service->service_name . "\">" . $service->service_name . "</option>";
                    }
                    ?>
                </select>
			</div>

			<div class="flex justify-end">
				<button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded-md hover:bg-blue-600">Ajouter</button>
				<a href="/views/admin_panel/panel.php"><i class="fa-solid fa-door-open" id="retour"></i></a>
			</div>
		</form>
	</div>
</div>

<style>
	#retour{
		padding: 15px;
	}
</style>
</body>

</html>
