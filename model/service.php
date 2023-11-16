<?php

namespace model;

require_once "../lib/config.php";

use function lib\db\get_db;

class Service
{
    public string $service_name;
    public int $service_id;
    public array $service_staff;

    function __construct(string $name, int $id, array $staff)
    {
        $this->service_name = $name;
        $this->service_id = $id;
        $this->service_staff = $staff;
    }

    static function all_services(): array
    {
        return [];
    }

    public static function get_service(int $id): Service|false
    {
        $db = get_db();

        $req = "SELECT * FROM services WHERE id = :id";
        $stmt = $db->prepare($req);
        $stmt->bindParam(":id", $id);

        if (!$stmt->execute())
            return false;

        $result = $stmt->fetchAll();

        if (sizeof($result) != 1)
            return false;

        $row = $result[0];
        return new Service($row["nom_service"], $row["id_service"], User::users_from_service($row["id"]));
    }
}
