<?php

namespace model;

use lib\db;

class Role
{
    public int $role_id;
    public string $role_name;

    public function __construct(int $role_id, string $role_name)
    {
        $this->role_id = $role_id;
        $this->role_name = $role_name;
    }

    public static function get_roles(): array|int
    {
        $db = db\get_db();
        $req = "SELECT * FROM postes";
        $stmt = $db->prepare($req);

        if (!$stmt->execute())
            return -1;

        $returned = [];
        foreach ($stmt->fetchAll() as $row) {
            $returned[] = new Role($row["id"], $row["intitule_poste"]);
        }
    }
}
