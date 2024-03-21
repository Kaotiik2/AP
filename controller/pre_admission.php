<?php

require_once "../model/pre_admission.php";
require_once "../lib/relay_post.php";

use lib\utils;
use model;

$result = model\new_pre_admission($_POST);

if (!$result) {
    header("Location: /views/admission/pre_admission_result.php");
} else {
    header("Location: /views/admission/pre_admission_result.php?error=" . htmlspecialchars($result));
}
