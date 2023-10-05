let form = document.querySelector("#pre-admission-form-1");

form.addEventListener("submit", (e) => {
    const postal_code_input = document.querySelector("input[name=code_postal]")
    if (postal_code_input.value.length > 5) {
        error_show("Le code postal ne doit pas dépasser 5 chiffres");
        e.preventDefault();
        return false;
    }

    const tel_input = document.querySelector("input[name=telephone]");
    if (tel_input.value.length > 14) {
        error_show("Le numéro de téléphone ne doit pas dépasser 14 chiffres");
        e.preventDefault();
        return false;
    }
    return true;
});

function error_show(message) {
    let error_p = document.querySelector("#form-error");
    error_p.textContent = message;
    error_p.scrollIntoView();
}