<?php

use model\User;

extract($_POST);

$result = User::register($name, $surname, $mail, $birth_date, $telephone, 3, $password);

if (!$result)
    header("Location: /views/create_account.php?error=1");
else
    header("Location: /views/create_account.php?error=0");

exit;
