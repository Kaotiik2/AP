let password_input = document.querySelector("input[name=new_password]");
let password_repeat = document.querySelector("input[name=password_repeat]");
let submit_button = document.querySelector("input[name=submit]");

let requirements = {
    "size": false,
    "lowercase": false,
    "uppercase": false,
    "special": false,
    "numbers": false
};

// Checks that the password fullfills ANSSI password requirements, which means:
// 1 - Must be 16 characters long
// 2 - Must contain lowercase AND uppercase characters
// 3 - Must contain special characters that are not alphanumeric
password_input.addEventListener("keyup", (e) => {
    const password = password_input.value;

    requirements.size = password.length >= 16;
    requirements.lowercase = (/[a-z]+/.exec(password) !== null);
    requirements.uppercase = (/[A-Z]+/.exec(password) !== null);
    requirements.special = (/[^a-zA-Z0-9]/.exec(password) !== null);
    requirements.numbers = (/[0-9]+/.exec(password) !== null);

    update_validity_indicators(requirements);
});

const control_submit_button_state = (e) => {
    if (password_input.value === password_repeat.value && is_password_valid(requirements)) {
        submit_button.classList.remove("cursor-not-allowed");
        submit_button.disabled = false;
    }
    else {
        submit_button.classList.add("cursor-not-allowed");
        submit_button.disabled = true;
    }

};

password_input.addEventListener("keyup", (e) => control_submit_button_state(e));
password_repeat.addEventListener("keyup", (e) => control_submit_button_state(e));

function update_validity_indicators(requirements) {
    set_class_state(document.querySelector("#size-p"), requirements.size);
    set_class_state(document.querySelector("#lowercase-p"), requirements.lowercase);
    set_class_state(document.querySelector("#uppercase-p"), requirements.uppercase);
    set_class_state(document.querySelector("#special-p"), requirements.special);
    set_class_state(document.querySelector("#numbers-p"), requirements.numbers);
}

function set_class_state(obj, state) {
    if (state) {
        obj.classList.add("text-green-500");
        obj.classList.remove("text-red-500");
    } else {
        obj.classList.add("text-red-500");
        obj.classList.remove("text-green-500");
    }
}

function is_password_valid(requirements) {
    return requirements.size && requirements.lowercase && requirements.uppercase && requirements.special && requirements.numbers;
}