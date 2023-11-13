<?php

namespace lib\db;

use PDO;

$host = "172.17.0.2";

$db = new PDO(
    "mysql:host=$host;dbname=LPFS;charset=utf8",
    "root",
    "password",
    [PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION],
);

function get_db(): PDO
{
    global $db;
    return $db;
}
