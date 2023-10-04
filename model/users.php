<?php

define("PASSWORD_LIFE", 90);

class User
{
    public string $mail;
    public int $id_user;
    public int $id_role;
    public bool $has_connected_before;
    public bool $must_change_password;

    public static function from_database(string $mail, string $password): User|int
    {
        return login($mail, $password);
    }
}

function login(string $mail, string $password): User|int
{
    include("../lib/config.php");

    $req = "SELECT id, id_poste, premiere_connexion, date_mdp FROM `utilisateurs` 
            WHERE mail = '$mail'
            AND mot_de_passe = '$password';
    ";

    $stmt = $db->prepare($req);
    $result = $stmt->execute();

    $response = $stmt->fetchAll();
    $len = count($response);

    if ($len == 1) {
        $id_user = $response[0]["id"];
        $id_role = $response[0]["id_poste"];
        $hcb = $response[0]["premiere_connexion"] == '1';
        $mcp = diff_in_days($response[0]["date_mdp"]) >= PASSWORD_LIFE;
        $user = new User();
        $user->$mail = $mail;
        $user->id_user = $id_user;
        $user->id_role = $id_role;
        $user->has_connected_before = $hcb;
        $user->must_change_password = $mcp;
        return $user;
    }
    // No user found with these credentials
    else if ($len == 0) {
        return 0;
    }
    // Database error
    else {
        return 1;
    }
}

function diff_in_days($date)
{
    $now = time();
    $datediff = $now - $date;

    return round($datediff / (60 * 60 * 24));
}
