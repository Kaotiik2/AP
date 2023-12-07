<!DOCTYPE html>
<html>

<head>
    <title>LPFS - Créer un compte</title>
    <!-- Inclure Tailwind CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css">
    <script src="/static/js/create_account.js" defer></script>
</head>

<body class="bg-gray-100 flex justify-center items-center h-screen">
<div class="bg-white p-8 rounded-md shadow-md max-w-md w-full">
    <div class="max-w-md mx-auto bg-white p-6 rounded-md shadow-md hidden" id="status">
        <p id="success_message" class="hidden text-green-500 font-bold">Compte créé</p>
        <p id="error_message" class="hidden text-red-500 font-bold">Échec de la création du compte: </p>
    </div>

    <h1 class="text-2xl font-bold mb-6">Créer un compte</h1>

    <form action="/controller/create_user.php" method="post">
        <div class="mb-4">
            <label for="surname" class="block text-sm font-medium text-gray-600">Nom</label>
            <input type="text" name="name" required
                   class="mt-1 p-2 w-full border rounded-md focus:outline-none focus:border-blue-500">
        </div>

        <div class="mb-4">
            <label for="surname" class="block text-sm font-medium text-gray-600">Prénom</label>
            <input type="text" name="surname" required
                   class="mt-1 p-2 w-full border rounded-md focus:outline-none focus:border-blue-500">
        </div>

        <div class="mb-4">
            <label for="mail" class="block text-sm font-medium text-gray-600">Mail</label>
            <input type="email" name="mail" required
                   class="mt-1 p-2 w-full border rounded-md focus:outline-none focus:border-blue-500">
        </div>

        <div class="mb-4">
            <label for="birth_date" class="block text-sm font-medium text-gray-600">Date de naissance</label>
            <input type="date" name="birth_date" required
                   class="mt-1 p-2 w-full border rounded-md focus:outline-none focus:border-blue-500">
        </div>

        <div class="mb-4">
            <label for="telephone" class="block text-sm font-medium text-gray-600">Téléphone</label>
            <input type="text" name="telephone" required
                   class="mt-1 p-2 w-full border rounded-md focus:outline-none focus:border-blue-500">
        </div>

        <div class="mb-4">
            <label for="service" class="block text-sm font-medium text-gray-600">Service</label>
            <select name="service" required
                    class="mt-1 p-2 w-full border rounded-md focus:outline-none focus:border-blue-500">
				<?php
				require_once "../model/services.php";

				use model\Service;

				foreach (Service::all_services() as $service) {
					echo "<option value=\"{$service->service_name}\">{$service->service_name}</option>";
				}
				?>
            </select>
            <label for="role" class="block text-sm font-medium text-gray-600">Rôle</label>
            <select name="role" required
                    class="mt-1 p-2 w-full border rounded-md focus:outline-none focus:border-blue-500">
				<?php
				require_once "../model/roles.php";

				use model\Role;

				foreach (Role::get_roles() as $role) {
					echo "<option value=\"{$role->role_name}\">{$role->role_name}</option>";
				}
				?>
            </select>
        </div>

        <div class="mb-4">
            <label for="password" class="block text-sm font-medium text-gray-600">Mot de passe</label>
            <input type="password" name="password" required
                   class="mt-1 p-2 w-full border rounded-md focus:outline-none focus:border-blue-500">
        </div>

        <div class="mb-6">
            <label for="repeat_password" class="block text-sm font-medium text-gray-600">Répétez le mot de passe</label>
            <input type="password" name="repeat_password" required
                   class="mt-1 p-2 w-full border rounded-md focus:outline-none focus:border-blue-500">
        </div>

        <button type="submit"
                class="bg-blue-500 text-white py-2 px-4 rounded hover:bg-blue-700 focus:outline-none focus:shadow-outline-blue active:bg-blue-800">
            Créer un compte
        </button>

    </form>

</div>

</body>

</html>
