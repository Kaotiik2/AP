<?php
$db = create_db();

function create_db()
{
    try {
        $host = "172.17.0.2";
        $database = new PDO(
            "mysql:host=$host;dbname=LPFS;charset=utf8",
            "root",
            "password",
            [PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION],
        );
        return $database;
    } catch (Exception $e) {
        echo $e->getMessage();
        exit(-1);
    }
}
