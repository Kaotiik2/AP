// Checks that all fields marked as .numbers only contain numbers.
// Must look like a foolish idea but it is useful for, for example, phone numbers.

let form_error_p = document.querySelector("#form-error");
document.querySelector("form").addEventListener("submit", (e) => {
    let can_continue = true;

    document.querySelector("form").querySelectorAll(".numbers").forEach(element => {
        const value = element.value;
        if (isNaN(parseInt(value))) {
            form_error_p.textContent = `Erreur: L'entrée ${element.name} doit contenir un nombre.`; // TODO: Mettre le message en rouge
            form_error_p.scrollIntoView();
            can_continue = false;
        }
    });
    if (!can_continue)
        e.preventDefault();

    return can_continue;
});