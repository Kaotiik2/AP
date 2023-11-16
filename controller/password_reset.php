<?php

require_once "../lib/captcha.php";
require_once "../model/users.php";

use lib\captcha;
use model\User;

session_start();

$user = unserialize($_SESSION["user"]);
var_dump($user);

// Captcha fail
if (!captcha\captcha_verify($_POST["captcha_answer"])) {
    header("Location: /views/password_reset.php?error=5");
}
// Captcha success
else {
    extract($_POST);

    if (isset($submit) && $new_password == $password_repeat) {
        // New password cannot be equals to the old one.
        if ($user->validate_login($new_password)) {
            header("Location: /views/password_reset.php?error=10");
        }

        model\update_user_password($user->$user_id, $new_password);
        session_destroy();
        header("Location: login.php");
    }
}
