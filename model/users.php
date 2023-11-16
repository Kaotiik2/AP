<?php

namespace model;

require_once "lib/config.php";

use lib\db;

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
    public string $birth_date;
    public string $telephone;
    public string $name;
    public string $surname;
    public int $service_id;

    public function __construct(int $id, string $name, string $surname, string $mail, string $birth, string $telephone, int $id_role, string $password, bool $first_connection, bool $mcp, string $salt, int $service_id)
    {
        $this->id_user = $id;
        $this->name = $name;
        $this->surname = $surname;
        $this->mail = $mail;
        $this->birth_date = $birth;
        $this->telephone = $telephone;
        $this->id_role = $id_role;
        $this->password = $password;
        $this->has_connected_before = $first_connection;
        $this->must_change_password = $mcp;
        $this->password_salt = $salt;
        $this->service_id = $service_id;
    }

    protected static function from_row(array $row): User
    {
        extract($row);
        return new User($id, $nom, $prenom, $mail, $date_naissance, $telephone, $id_poste, $mot_de_passe, $premiere_connexion, diff_in_days($date_mdp) >= PASSWORD_LIFE, $password_salt, $service_id);
    }

    public static function get_all(): array|false
    {
        $db = db\get_db();
        $sql = "SELECT * FROM utilisateurs";
        $stmt = $db->prepare($sql);
        $result = $stmt->execute();

        if (!$result) return false;

        $returned = [];
        foreach ($stmt->fetchAll() as $row) {
            $returned[] = User::from_row($row);
        }

        return $returned;
    }

    /// Selects the user associated with the database
    public static function from_database(string $mail): User|int
    {
        return User::user_by_mail($mail);
    }

    /// Tries to login with the mail and the password passed as parameters
    /// Returns a ``User`` object if login is successful, false otherwise
    public static function login(string $mail, string $password): User|false
    {
        $user = User::from_database($mail);

        if (is_int($user))
            return false;

        if ($user->validate_login($password))
            return $user;
        else
            return false;
    }

    private static function user_by_mail(string $mail): User|int
    {
        $db = db\get_db();

        $req = "SELECT * FROM `utilisateurs` 
            WHERE mail = :mail
    ";

        $stmt = $db->prepare($req);
        $stmt->bindValue(":mail", $mail);

        $result = $stmt->execute();

        $response = $stmt->fetchAll();
        $len = count($response);

        if ($len == 1) {
            return User::from_row($response[0]);
        }
        // No user found with these credentials
        else if ($len == 0) {
            echo "C'est zéro";
            return 0;
        }
        // Database error
        else {
            var_dump($response);
            return 1;
        }
    }

    /// Registers a new user in the database
    public static function register(string $name, string $surname, string $mail, string $birth_date, $telephone, int $id_poste, string $password, int $service_id): User|false
    {
        $db = db\get_db();
        $req = "INSERT INTO utilisateurs(nom, prenom, mail, date_naissance, telephone, id_poste, mot_de_passe, premiere_connexion, date_mdp, password_salt, service_id)
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
            :generated_salt,
            :service_id
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
        $stmt->bindParam(":service_id", $service_id);

        $result = $stmt->execute();

        if (!$result) {
            return false;
        }
        return User::from_database($mail);
    }

    /// Checks that the password passed in parameters is the same as the one in database.
    public function validate_login($password): bool
    {
        return password_verify($password . $this->password_salt, $this->password);
    }

    static function users_from_service(int $service_id): array|false
    {
        $db = db\get_db();

        $req = "SELECT * FROM utilisateurs WHERE service_id = :service_id";
        $stmt = $db->prepare($req);
        $stmt->bindParam(":service_id", $service_id);

        $result = $stmt->execute();

        if (!$result)
            return false;

        $rows = $stmt->fetchAll();
        $returned = [];

        foreach ($rows as $row) {
            extract($row);
            $returned[] = User::from_row($row);
        }
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
    $db = db\get_db();

    $req = "SELECT mot_de_passe FROM utilisateurs WHERE id = :id";

    $stmt = $db->prepare($req);
    $stmt->bindValue(":id", $user_id);
    $result = $stmt->execute();

    if (!$result) return null;

    else return $stmt->fetch()["mot_de_passe"];
}

function update_user_password(int $user_id, string $new_password): bool
{
    $db = db\get_db();

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
