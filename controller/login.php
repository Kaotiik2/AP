<?php
session_start();

require_once "../model/users.php";
require_once "../lib/captcha.php";

use model\User;
use lib\captcha;

if (!isset($_POST["captcha_answer"]) || !captcha\captcha_verify($_POST["captcha_answer"])) {
    captcha\captcha_clear();
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
    var_dump($user);
    //exit;

    if (!$user->has_connected_before || $user->must_change_password) {
        header("Location: /views/password_reset.php");
        exit;
    }

    header("Location: /controller/panel.php");
    exit;
}
