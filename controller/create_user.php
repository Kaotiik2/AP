<?php
require_once "../model/users.php";

use model\User;

extract($_POST);

$result = User::register($name, $surname, $mail, $birth_date, $telephone, intval($role), $password, $service);

if (is_string($result))
    header("Location: /views/create_account.php?error=".urlencode($result));
else if ($result instanceof User)
    header("Location: /views/create_account.php?success=true");

exit;
