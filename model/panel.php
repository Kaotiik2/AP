<?php
session_start();
if (!isset($_SESSION["id"])) {
    header("Location: login.php");
}

extract($_SESSION);
$id_poste = intval($id_poste);
$location = "login.php";

switch ($id_poste) {
    case 1:
        $location = "panels/1_admin.php";
        break;
    case 2:
        $location = "panels/2_medecin.php";
        break;
    case 3:
        $location = "panels/3_secretaire.php";
        break;
}

header("Location: $location");
