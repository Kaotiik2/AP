<?php

namespace model;

require_once __DIR__ . "/../lib/config.php";
use function lib\db\get_db;

class Medecin {
	public string $nom;
	public string $prenom;
	public int $discipline;
	public ?int $id;
	public int $id_user;
	public string $nom_service;

	function __construct(string $nom, string $prenom, int $discipline, string $nom_service, int $id = null) {
		$this->nom = $nom;
		$this->prenom = $prenom;
		$this->discipline = $discipline;
		$this->id = $id;
		$this->nom_service = $nom_service;
	}

	public function register(): bool {
		$db = get_db();

		$req = "INSERT INTO medecins (nom, prenom, discipline, nom_service) VALUES (:nom, :prenom, :discipline, :nom_service)";
		$stmt = $db->prepare($req);
		$stmt->bindParam(":nom", $this->nom);
		$stmt->bindParam(":prenom", $this->prenom);
		$stmt->bindParam(":discipline", $this->discipline);
		$stmt->bindParam(":nom_service", $this->nom_service);

		return $stmt->execute();
	}

	public function edit(string $new_nom = null, string $new_prenom = null, string $new_nom_service = null): bool {
		$db = get_db();

		$req = "UPDATE medecins SET nom = :new_nom, prenom = :new_prenom, nom_service = :new_nom_service WHERE id_medecin = :id";
		$stmt = $db->prepare($req);
		$stmt->bindValue(":new_nom", $new_nom ? $new_nom : $this->nom);
		$stmt->bindValue(":new_prenom", $new_prenom ? $new_prenom : $this->prenom);
		$stmt->bindValue(":new_nom_service", $new_nom_service ? $new_nom_service : $this->nom_service);
		$stmt->bindValue(":id", $this->id);

		return $stmt->execute();
	}

	static function all_medecins(): array|false {
		$db = get_db();

		$req = "SELECT * FROM medecins";
		$stmt = $db->prepare($req);

		if (!$stmt->execute())
			return false;

		$result = $stmt->fetchAll();

		$returned = [];
		foreach ($result as $row) {
			$returned[] = new Medecin($row["nom"], $row["prenom"], $row["discipline"], $row["nom_service"], $id = $row["id_medecin"]);
		}

		return $returned;
	}

	static function from_id(int $id): Medecin|false {
		$db = get_db();

		$req = "SELECT * FROM medecins WHERE id_medecin = :id";
		$stmt = $db->prepare($req);
		$stmt->bindParam(":id", $id);

		if (!$stmt->execute())
			return false;

		$result = $stmt->fetchAll();

		if (sizeof($result) != 1)
			return false;

		$row = $result[0];
		return new Medecin($row["nom"], $row["prenom"], $row["discipline"], $row["nom_service"], $id = $row["id_medecin"]);
	}

	static function from_user_id(int $id): Medecin|false {
		$db = get_db();

		$req = "SELECT * FROM medecins WHERE id_user = :id";
		$stmt = $db->prepare($req);
		$stmt->bindParam(":id", $id);

		if (!$stmt->execute())
			return false;

		$result = $stmt->fetchAll();

		if (sizeof($result) != 1)
			return false;

		$row = $result[0];
		return new Medecin($row["nom"], $row["prenom"], $row["discipline"], $row["nom_service"], $id = $row["id_medecin"]);
	}


	static function delete(int $id): bool {
		$db = get_db();

		$req = "DELETE FROM medecins WHERE id_medecin = :id";
		$stmt = $db->prepare($req);
		$stmt->bindParam(":id", $id);

		return $stmt->execute();
	}
}