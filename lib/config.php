<?php

namespace lib\db;

use PDO;

$host = "192.168.20.70";

$db = new PDO(
    "mysql:host=$host;dbname=LPFS;charset=utf8",
    "dev",
    "azerty1234+",
    [PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION],
);

function get_db(): PDO
{
    global $db;
    return $db;
}
