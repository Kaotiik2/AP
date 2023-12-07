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
	<title>Modifier un médecin</title>
	<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css">
</head>

<body class="bg-gray-100 font-sans">
<div class="container mx-auto my-8">
	<div class="bg-white p-8 shadow-md rounded-md mx-auto">
		<h1 class="text-2xl font-bold mb-6">Liste des Médecins</h1>

		<table class="min-w-full bg-white border border-gray-300">
			<thead>
			<tr>
				<th class="py-2 px-4 border-b">Nom</th>
				<th class="py-2 px-4 border-b">Prénom</th>
				<th class="py-2 px-4 border-b">Discipline</th>
				<th class="py-2 px-4 border-b">Service</th>
				<th class="py-2 px-4 border-b">Actions</th>
			</tr>
			</thead>
			<tbody>
			<?php
			require_once "../../model/medecins.php";
			require_once "../../model/services.php";
			use model\Medecin;
			use model\Service;

			foreach (Medecin::all_medecins() as $medecin) {
				echo "<form action='/controller/action_medecin.php?action=update' method='post'>";
					echo "<tr>";
					echo "<input type='hidden' name='id' value='{$medecin->id}' />";
					echo "<td class='py-2 px-4 border-b'> <input type='text' name='new_nom' value='{$medecin->nom}' /> </td>";
				echo "<td class='py-2 px-4 border-b'> <input type='text' name='new_prenom' value='{$medecin->prenom}' /></td>";

				echo "<td class='py-2 px-4 border-b'>";
				$services = Service::all_services();
				echo "<select name='new_nom_service'>";
				foreach ($services as $service) {
					if ($service->service_name == $medecin->nom_service)
						echo "<option selected='selected' value=\"" . $service->service_name . "\">" . $service->service_name . "</option>";
					else
						echo "<option value=\"" . $service->service_name . "\">" . $service->service_name . "</option>";
				}
				echo "</select>";
				echo "</td>";

				echo "<td class='py-2 px-4 border-b'> <input type='submit' value='Modifier'/> </td>";
				echo "</tr>";
				echo "</form>";
			}
			?>
			</tbody>
		</table>
	</div>
</div>
</body>

</html>

