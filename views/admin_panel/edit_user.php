<?php
require_once "../../model/security.php";
global $SECURITY_ADMIN_LEVEL;

$SECURITY_ADMIN_LEVEL->authorize();
?>