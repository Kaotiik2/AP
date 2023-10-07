document.querySelector("form").addEventListener("submit", (e) => {
    let password_field = document.querySelector("input[name='password']");
    const password = password_field.value;

    let repeat_field = document.querySelector("input[name='repeat_password']")
    const repeat = repeat_field.value;

    if (password_field === repeat_field) {
        return true;
    }
    else {
        e.preventDefault();
        return false;
    }
});