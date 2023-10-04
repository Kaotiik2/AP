function error(code, reason) {
    return {
        code: code,
        reason: reason
    };
}

// TODO: Maybe move error codes to another file ?
const login_errors = [
    error(0, "Utilisateur et/ou mot de passe incorrect(s)"),
    error(1, "Erreur base de données"),
    error(5, "Captcha incorrect")
];

const queryString = window.location.search;
const urlParams = new URLSearchParams(queryString);

const error_code = urlParams.get("error");
if (error_code != null) {
    document.querySelector("#error-display").textContent = login_errors.find((value) => value.code == error_code).reason;
}