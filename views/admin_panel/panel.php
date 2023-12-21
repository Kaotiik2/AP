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
    <link href="/static/css/panel-admin.css" rel="stylesheet"/>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css" integrity="sha512-z3gLpd7yknf1YoNbCzqRKc4qyor8gaKU1qmn+CShxbuBusANI9QpRohGBreCFkKxLhei6S9CQXFEbbKuqLg0DA==" crossorigin="anonymous" referrerpolicy="no-referrer" />
</head>

<body>

    <section>
        <div class="card">

            <div class="top">
              <img src="/static/images/LPFS_logo.png" alt="">
            </div>

            <div class="bottom">

            <div class="maDiv">
                    <p class="utilisateur">Médecins</p>
                    <a href="/views/admin_panel/add_medecin.php" >Ajouter</a>
                    <a href="/views/admin_panel/edit_medecin.php" >Modifier</a>
                    <a href="/views/admin_panel/delete_medecin.php" >Supprimer</a>
                </div>

                <div class="maDiv">
                    <p class="utilisateur">Roles</p>
                    <a href="/views/admin_panel/add_roles.php" >Ajouter</a>
                    <a href="/views/admin_panel/edit_roles.php" >Modifier</a>
                    <a href="/views/admin_panel/delete_roles.php" >Supprimer</a>
                </div>

                <div class="maDiv">
                    <p class="utilisateur">Services</p>
                    <a href="/views/admin_panel/add_service.php" >Ajouter</a>
                    <a href="/views/admin_panel/edit_service.php" >Modifier</a>
                    <a href="/views/admin_panel/delete_service.php" >Supprimer</a>
                </div>
                <a href="/views/admin.php" ><i class="fa-solid fa-door-open" id="retour"></i></a>

            </div>
        </div>
    </section>

</body>

</html>