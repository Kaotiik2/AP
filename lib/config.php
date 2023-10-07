<?php
$host = "192.168.20.70";

$db = new PDO(
    "mysql:host=$host;dbname=LPFS;charset=utf8",
    "dev",
    "azerty1234+",
    [PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION],
);
