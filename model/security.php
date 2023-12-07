<?php

namespace model;

require_once("users.php");

use model\User;

class Security {
	public array $authorized;

	public function __construct(array $authorized) {
		$this->authorized = $authorized;
	}

	public function is_current_user_authorized(): bool
	{
		$user = User::from_session();
		if (!$user)
			return false;

		return in_array($user->id_role, $this->authorized) || $user->id_role == 0;
	}

	public function authorize() {
		if (!$this->is_current_user_authorized()) {
			http_response_code(401);
			header("Location: /views/forbidden.html");
		}
	}
}

static $SECURITY_ADMIN_LEVEL = new Security([ 0 ]);
static $SECURITY_SECRETARY_LEVEL = new Security([ 3 ]);