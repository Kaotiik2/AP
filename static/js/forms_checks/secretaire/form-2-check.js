let second_step_form = document.querySelector("#pre-admission-form-2");
second_step_form.addEventListener("submit", (e) => {
    const secu_check = secu_number_check();
    if (!secu_check) {
        e.preventDefault();
        let form_error_p = document.querySelector("#form-error");
        form_error_p.textContent = "Erreur: Numéro de sécurité sociale invalide"; // TODO: Mettre le message en rouge
        form_error_p.scrollIntoView();
        return false;
    }

    return true;
});

function secu_number_check() {
    const num_secu_input = document.querySelector("input[name=num_secu]");
    const num_secu = num_secu_input.value;

    // Vérification que la civilité de la personne est cohérente
    const civ = document.querySelector("input[name=civilite]").value;
    console.log("civ = " + civ);
    // Vérification que le numéro de sécu est cohérent avec la date de naissance de la personne
    const birth_year = document.querySelector("input[name=date_naissance]").value.substring(2, 4);
    console.log("year = " + birth_year);
    // Idem pour le mois de naissance
    const birth_month = document.querySelector("input[name=date_naissance]").value.substring(5, 7);
    console.log("month = " + birth_month);
    if (num_secu.charAt(0) !== civ || num_secu.substring(1, 3) !== birth_year || num_secu.substring(3, 6) !== birth_month) {
        alert("Numéro de sécurité sociale invalide.");
        return true;
    }
    return true;
}