let second_step_form = document.querySelector("#pre-admission-form-2");
second_step_form.addEventListener("submit", (e) => {
    const secu_check = secu_number_check();
    if (secu_check !== true) {
        let form_error_p = document.querySelector("#form-error");
        form_error_p.textContent = "Erreur: Numéro de sécurité sociale: ";

        let count = 0;
        if (!secu_check.civ) {
            form_error_p.textContent += "Civilité incorrecte";
            count += 1;
        }
        if (!secu_check.month) {
            form_error_p.textContent += (count > 0 ? ", " : "") + "Mois de naissance incorrect";
            count += 1;
        }
        if (!secu_check.year) {
            form_error_p.textContent += (count > 0 ? ", " : "") + "Année de naissance incorrect";
        }

        form_error_p.scrollIntoView();
        e.preventDefault();
        return false;
    }

    return true;
});

function secu_number_check() {
    const num_secu_input = document.querySelector("input[name=num_secu]");
    const num_secu = num_secu_input.value;

    const civ = document.querySelector("input[name=civilite]").value;
    const civ_check = num_secu.charAt(0) === civ;

    const birth_year = document.querySelector("input[name=date_naissance]").value.substring(2, 4);
    const year_check = num_secu.substring(1, 3) === birth_year;

    const birth_month = document.querySelector("input[name=date_naissance]").value.substring(5, 7);
    const month_check = num_secu.substring(3, 5) === birth_month;

    console.log(`civ = ${civ}, year = ${birth_year}, month = ${birth_month}`);

    if (!civ_check || !year_check || !month_check) {
        return {
            civ: civ_check,
            year: year_check,
            month: month_check
        };
    }
    return true;
}