<?php
require_once "../model/security.php";
global $SECURITY_SECRETARY_LEVEL;

$SECURITY_SECRETARY_LEVEL->authorize();
?>

<html lang="fr">

<head>
    <meta charset="UTF-8"/>
    <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
    <meta http-equiv="X-UA-Compatible" content="ie=edge"/>
    <title>LPFS - Panel Secréteriat</title>
    <link href="/static/css/admin.css" rel="stylesheet"/>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css"
          integrity="sha512-z3gLpd7yknf1YoNbCzqRKc4qyor8gaKU1qmn+CShxbuBusANI9QpRohGBreCFkKxLhei6S9CQXFEbbKuqLg0DA=="
          crossorigin="anonymous" referrerpolicy="no-referrer"/>
    <script src="js/login.js" defer></script>
</head>

<body>
<div class="mainscreen">
    <div class="card">
        <div class="leftside">
            <img src="/static/images/LPFS_logo.png" alt="">
        </div>
        <section id="infos">
            <div class="maDiv">
                <div class="maDiv-left">
                    <div class="icon-1">
                        <i class="fa-solid fa-user-plus"></i>
                    </div>
                    <a href="/views/admission/pre_admission_step0.php">Pré-admission</a>
                </div>
                <div class="maDiv-right">
                    <div class="icon-1">
                        <i class="fa-solid fa-shield-halved"></i>
                    </div>
                    <a href="/views/admin_panel/panel.php">Prochaines Hospitalisations</a>
                </div>
            </div>

        </section>

    </div>

    <style>

    </style>

</body>

</html>