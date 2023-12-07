<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8"/>
    <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
    <meta http-equiv="X-UA-Compatible" content="ie=edge"/>
    <title>Supprimer un Médecin</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css">
</head>

<body class="bg-gray-100 font-sans">
<div class="container mx-auto my-8">
    <div class="bg-white p-8 shadow-md rounded-md max-w-md mx-auto">
        <h1 class="text-2xl font-bold mb-6">Supprimer un Médecin</h1>

        <form action="/controller/action_medecin.php?action=delete" method="post">
            <div class="mb-4">
                <label for="medecin_id" class="block text-gray-700 text-sm font-semibold mb-2">Choisir le Médecin à Supprimer:</label>
                <select name="id" id="medecin_id" class="w-full border border-gray-300 p-2 rounded-md" required>
					<?php
					require_once "../../model/medecins.php";
					use Model\Medecin;

                    $first = false;
					foreach (Medecin::all_medecins() as $medecin) {
                        if (!$first) {
	                        echo "<option selected='selected' value=\"{$medecin->id}\" >{$medecin->nom} {$medecin->prenom}</option>";
                            $first = true;
                            continue;
                        }
						echo "<option value=\"{$medecin->id}\">{$medecin->nom} {$medecin->prenom}</option>";
					}
					?>
                </select>
            </div>

            <div class="flex justify-end">
                <button type="submit" class="bg-red-500 text-white px-4 py-2 rounded-md hover:bg-red-600">Supprimer</button>
            </div>
        </form>
    </div>
</div>
</body>

</html>
