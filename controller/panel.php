<?php

require_once "../model/users.php";

use model\User;

$user = User::from_session();

$redirect_route = match ($user->id_role) {
    0 => "/views/admin.php",
    2 => "/views/panel_medecin.php",
    3 => "/views/panel_secreteriat.php",
    default => "/views/login.php?error=1"
};

header("Location: $redirect_route");
