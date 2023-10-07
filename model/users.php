<?php

define("PASSWORD_LIFE", 90);

class User
{
    public string $mail;
    public int $id_user;
    public int $id_role;
    public bool $has_connected_before;
    public bool $must_change_password;
    public string $password_salt;
    public string $password;

    /// Selects the user associated with the database
    public static function from_database(string $mail): User|int
    {
        return user_by_mail($mail);
    }

    public static function login(string $mail, string $hashed_password): User|false
    {
        $user = User::from_database($mail);

        if (is_int($user)) {
            return false;
        }

        if ($user->validate_login($hashed_password)) {
            return $user;
        }
    }

    // Registers a new user in the database
    public static function register(string $name, string $surname, string $mail, string $birth_date, $telephone, int $id_poste, string $password): User|false
    {
        include("../lib/config.php");
        $req = "INSERT INTO utilisateurs(nom, prenom, mail, date_naissance, telephone, id_poste, mot_de_passe, premiere_connexion, date_mdp, password_salt)
        VALUES(
            :nom,
            :prenom,
            :mail,
            :birth_date,
            :tel,
            :id_poste,
            :hashed_password,
            '0',
            '0',
            :generated_salt
        )";

        $salt = generate_salt();
        $hashed_password = password_hash($password . $salt, PASSWORD_ARGON2ID);

        $stmt = $db->prepare($req);
        $stmt->bindValue(":nom", $name);
        $stmt->bindValue(":prenom", $surname);
        $stmt->bindValue(":mail", $mail);
        $stmt->bindValue(":birth_date", $birth_date);
        $stmt->bindValue(":tel", $telephone);
        $stmt->bindValue(":id_poste", $id_poste);
        $stmt->bindParam(":hashed_password", $hashed_password);
        $stmt->bindParam(":generated_salt", $salt);

        $result = $stmt->execute();

        if (!$result) {
            return false;
        }

        return User::from_database($mail);
    }

    public function test_password(string $input): bool
    {
        return $this->hash_password($input) == $this->password;
    }

    private function validate_login($password): bool
    {
        $hashed = $this->hash_password($password);

        return $hashed == $this->password;
    }

    private function hash_password($password): string
    {
        // password_hash(password_hash($clear_password, ...) + password_salt, PASSWORD_ARGON2ID);
        return password_hash($password . $this->password_salt, PASSWORD_ARGON2ID);
    }
}

function user_by_mail(string $mail): User|int
{
    include("../lib/config.php");

    $req = "SELECT id, id_poste, premiere_connexion, date_mdp, mot_de_passe, password_salt FROM `utilisateurs` 
            WHERE mail = :mail
    ";

    $stmt = $db->prepare($req);
    $stmt->bindValue(":mail", $mail);

    $result = $stmt->execute();

    $response = $stmt->fetchAll();
    $len = count($response);

    if ($len == 1) {
        $row = $response[0];
        $id_user = $row["id"];
        $id_role = $row["id_poste"];
        $hcb = $row["premiere_connexion"] == '1';
        $mcp = diff_in_days($row["date_mdp"]) >= PASSWORD_LIFE;
        $user = new User();
        $user->mail = $mail;
        $user->id_user = $id_user;
        $user->id_role = $id_role;
        $user->has_connected_before = $hcb;
        $user->must_change_password = $mcp;
        $user->password = $row["mot_de_passe"];
        $user->password_salt = $row["password_salt"];
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

function get_user_password(int $user_id): string|null
{
    include("../lib/config.php");

    $req = "SELECT mot_de_passe FROM utilisateurs WHERE id = :id";

    $stmt = $db->prepare($req);
    $stmt->bindValue(":id", $user_id);
    $result = $stmt->execute();

    if (!$result) return null;

    else return $stmt->fetch()["mot_de_passe"];
}

function update_user_password(int $user_id, string $new_password): bool
{
    include("../lib/config.php");

    $req = "
        UPDATE utilisateurs
            SET mot_de_passe = :new_password,
            premiere_connexion = '1',
            date_mdp = :date
            WHERE id = :id
        ";

    $datenow = time();
    $stmt = $db->prepare($req);
    $stmt->bindValue(":new_password", $new_password);
    $stmt->bindValue(":date", $datenow);
    $stmt->bindValue(":id", $user_id);

    return $stmt->execute();
}

function generate_salt(int $len = 255): string
{
    $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
    $salt = '';

    for ($i = 0; $i < $len; $i++) {
        $salt .= $characters[rand(0, strlen($characters) - 1)];
    }

    return $salt;
}
