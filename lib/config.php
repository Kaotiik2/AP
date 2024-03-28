<?php

namespace lib\db;

use PDO;

$host = "192.168.20.20";

$db = new PDO(
    "mysql:host=$host;dbname=LPFS;charset=utf8",
    "root",
    "Sio2021",
    [PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION],
);

function get_db(): PDO
{
    global $db;
    return $db;
}
