<?php
session_start();
require_once("../lib/captcha.php");
require_once("../model/users.php");

if (!isset($_POST["captcha_answer"]) || !captcha_verify($_POST["captcha_answer"])) {
    captcha_clear();
    session_destroy();
    header("Location: /views/login.php?erreur=5"); // Erreur Captcha
    exit;
}

// on applique les deux fonctions mysqli_real_escape_string et htmlspecialchars
// pour éliminer toute attaque de type injection SQL et XSS
$username = $_POST['username'];
$password = $_POST['password'];
$user = User::login($username, $password);

// Connection failed
if (!$user) {
    header("Location: /views/login.php?error=0");
}

// Connection didn't fail, the model returned a valid User object
else {
    $_SESSION["user"] = serialize($user);

    if (!$user->has_connected_before || $user->must_change_password) {
        header("Location: /views/password_reset.php");
        exit;
    }

    switch ($user->id_role) {
        case 1:
            header("Location: /views/admin.php");
        case 2:
            header("Location: /views/medecin.php");
        case 3:
            header("Location: /views/secretaire.php");
    };
}
