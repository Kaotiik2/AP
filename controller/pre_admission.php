<?php

require_once "../model/users.php";
require_once "../lib/relay_post.php";

use lib\utils;

$result = model\new_pre_admission($_POST);

if (!$result) {
    header("Location: views/admission/pre_admission_result.php");
} else {
    header("Location: views/admission/pre_admission_result.php?error=" . $result);
}
