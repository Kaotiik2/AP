<?php

namespace model;

require_once __DIR__ . "/../lib/config.php";
require_once "users.php";

use function lib\db\get_db;
use model\User;

class Service
{
    public string $service_name;
    public array $service_staff;

    function __construct(string $name, array $staff)
    {
        $this->service_name = $name;
        $this->service_staff = $staff;
    }

	/// Returns all services from the table ``services``.
    static function all_services(): array|false
    {
		$db = get_db();

		$req = "SELECT nom_service FROM services";
		$stmt = $db->prepare($req);

		if (!$stmt->execute())
			return false;

		$result = $stmt->fetchAll();

		$returned = [];
		foreach ($result as $row) {
			$returned[] = Service::get_service($row["nom_service"]);
		}

		return $returned;
    }

	/// Returns a service from the table ``services`` where its name == $service_name.
    public static function get_service(string $service_name): Service|false
    {
        $db = get_db();

        $req = "SELECT * FROM services WHERE nom_service = :service_name";
        $stmt = $db->prepare($req);
        $stmt->bindParam(":service_name", $service_name);

        if (!$stmt->execute())
            return false;

        $result = $stmt->fetchAll();

        if (sizeof($result) != 1)
            return false;

        $row = $result[0];
        return new Service($row["nom_service"], User::users_from_service($row["nom_service"]));
    }

	public static function new_service(string $service_name): bool
	{
		$db = get_db();

		$req = "INSERT INTO services (nom_service) VALUES (:service_name)";
		$stmt = $db->prepare($req);
		$stmt->bindParam(":service_name", $service_name);

		return $stmt->execute();
	}

	public function delete_service(): bool
	{
		$db = get_db();

		$req = "DELETE FROM services WHERE nom_service = :service_name";
		$stmt = $db->prepare($req);
		$stmt->bindParam(":service_name", $this->service_name);

		return $stmt->execute();
	}


}
