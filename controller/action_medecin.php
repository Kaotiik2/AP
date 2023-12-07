<?php


require_once "../model/security.php";
require_once "../model/medecins.php";

global $SECURITY_ADMIN_LEVEL;
$SECURITY_ADMIN_LEVEL->authorize();

use model\Medecin;

$action = $_GET["action"];

switch ($action) {
	case "create":
	{
		var_dump($_POST);
		extract($_POST);

		$medecin = new Medecin($nom, $prenom, $discipline, $nom_service);

		$referer = $_SERVER["HTTP_REFERER"];

		$route = match ($medecin->register()) {
			true => "$referer" . "?success=1",
			false => "$referer" . "?success=0"
		};

		header("Location: $route");
		exit;
	}
	case "delete":
	{
		extract($_POST);

		$referer = $_SERVER["HTTP_REFERER"];

		$route = match (Medecin::delete($id)) {
			true => "$referer" . "?success=1",
			false => "$referer" . "?success=0"
		};

		header("Location: $route");
		exit;
	}

	case "update": {
		extract($_POST);

		$medecin = Medecin::from_id($id);

		$referer = $_SERVER["HTTP_REFERER"];

		$route = match ($medecin->edit($new_nom, $new_prenom, $new_nom_service = $new_nom_service)) {
			true => "$referer" . "?success=1",
			false => "$referer" . "?success=0"
		};

		header("Location: $route");
		exit;
	}

	default:
	{
		http_response_code(404);
		header("Location: /");
		exit;
	}
}