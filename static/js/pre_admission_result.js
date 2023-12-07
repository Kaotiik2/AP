const success_p = document.querySelector("#success_message");
const error_p = document.querySelector("#error_message");

const queryString = window.location.search;
const urlParams = new URLSearchParams(queryString);
const error_details = urlParams.get("error");

if (!error_details)
    success_p.classList.remove("hidden");

else {
    error_p.classList.remove("hidden");
    error_p.content += error_details;
}