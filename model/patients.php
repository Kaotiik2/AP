<?php

namespace model;

require_once "../lib/config.php";

use lib\db;

class Patient
{
    public string $healthcare_serial;
    public string $healthcare_organism;
    public bool $has_insurance;
    public bool $has_ald;
    public string|null $insurance_name;
    public string|null $insurance_serial;
    public int $room_type;
    public int $civility;
    public string $name;
    public string $wife_name;
    public string $surname;
    public string $birth_date;
    public string $address;
    public string $zip;
    public string $city;
    public string $email;
    public string $tel;

    public static function from_database(string $healthcare_serial): Patient|mixed
    {
        $db = db\get_db();

        $req = "SELECT * FROM patients WHERE num_secu = :serial";
        $stmt = $db->prepare($req);
        $stmt->bindValue(":serial", $healthcare_serial);

        $result = $stmt->execute();
        if (!$result) {
            return $db->errorCode();
        }

        if ($stmt->rowCount() > 1) {
            return 1;
        }

        $row = $stmt->fetch();
        $patient = new Patient();
        $patient->healthcare_serial = $row["num_secu"];
        $patient->healthcare_organism = $row["organisme_secu"];
        $patient->has_insurance = $row["assurance"] == "1";
        $patient->insurance_name = $row["nom_mutuelle"];
        $patient->insurance_serial = $row["num_adherent_mutuelle"];
        $patient->room_type = intval($row["type_chambre"]);
        $patient->civility = intval($row["civilite"]);
        $patient->name = $row["nom_naissance"];
        $patient->wife_name = $row["nom_epouse"];
        $patient->surname = $row["prenom"];
        $patient->birth_date = $row["date_naissance"];
        $patient->address = $row["adresse"];
        $patient->zip = $row["code_postal"];
        $patient->city = $row["ville"];
        $patient->email = $row["email"];
        $patient->tel = $row["telephone"];

        return $patient;
    }
}
