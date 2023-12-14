<?php
require_once "../../model/security.php";
global $SECURITY_ADMIN_LEVEL;
$SECURITY_ADMIN_LEVEL->authorize();
?>

<html lang="fr">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <meta http-equiv="X-UA-Compatible" content="ie=edge" />
    <title>LOGIN PAGE LPF</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css" integrity="sha512-z3gLpd7yknf1YoNbCzqRKc4qyor8gaKU1qmn+CShxbuBusANI9QpRohGBreCFkKxLhei6S9CQXFEbbKuqLg0DA==" crossorigin="anonymous" referrerpolicy="no-referrer" />
</head>

<body class="bg-gray-200">

    <div class="mainscreen min-h-screen flex items-center justify-center">
        <div class="card p-6 bg-white rounded-lg shadow-md">

            <div class="leftside">
                <!-- <img src="/static/images/LPFS_logo.png" alt=""> -->
            </div>

            <section id="infos" class="mt-6 space-y-4">


                <div class="maDiv">
                    <p class="utilisateur">Médecins</p>
                    <a href="/views/admin_panel/add_medecin.php" class="text-blue-500">Ajouter</a>
                    <a href="/views/admin_panel/edit_medecin.php" class="text-blue-500">Modifier</a>
                    <a href="/views/admin_panel/delete_medecin.php" class="text-blue-500">Supprimer</a>
                </div>

                <div class="maDiv">
                    <p class="utilisateur">Roles</p>
                    <a href="/views/admin_panel/add_roles.php" class="text-blue-500">Ajouter</a>
                    <a href="/views/admin_panel/edit_roles.php" class="text-blue-500">Modifier</a>
                    <a href="/views/admin_panel/delete_roles.php" class="text-blue-500">Supprimer</a>
                </div>

                <div class="maDiv">
                    <p class="utilisateur">Services</p>
                    <a href="/views/admin_panel/add_service.php" class="text-blue-500">Ajouter</a>
                    <a href="/views/admin_panel/edit_service.php" class="text-blue-500">Modifier</a>
                    <a href="/views/admin_panel/edit_service.php" class="text-blue-500">Supprimer</a>
                    <a href="/views/admin_panel/delete_service.php" class="text-blue-500">Supprimer</a>
                </div>

            </section>

        </div>
    </div>

</body>

</html>