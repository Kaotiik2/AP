const success_p = document.querySelector("#success_message");
const error_p = document.querySelector("#error_message");
const status_div = document.querySelector("#status");

const queryString = window.location.search;
const urlParams = new URLSearchParams(queryString);
const error_details = urlParams.get("error");
const success = urlParams.get("success") != null;

if (success || error_details)
    status_div.classList.remove("hidden");

if (success)
    success_p.classList.remove("hidden");

else if (error_details) {
    error_p.classList.remove("hidden");
    error_p.innerHTML += error_details;
}

document.querySelector("form").addEventListener("submit", (e) => {
    let password_field = document.querySelector("input[name='password']");
    const password = password_field.value;

    let repeat_field = document.querySelector("input[name='repeat_password']")
    const repeat = repeat_field.value;

    if (password === repeat) {
        return true;
    }
    else {
        console.log(`left: ${password}, right: ${repeat}`);
        e.preventDefault();
        return false;
    }
});