const form = document.getElementById("loginForm");

form.addEventListener("submit", function(event) {

    const email = document.getElementById("email");
    const password = document.getElementById("password");

    document.querySelectorAll(".error-message").forEach(function(error) {
        error.remove();
    });

    let valid = true;

    if (email.value.trim() === "") {
        showError(email, "Email is required");
        valid = false;
    }
    else if (!email.value.includes("@") || !email.value.includes(".")) {
        showError(email, "Email is not valid");
        valid = false;
    }

    if (password.value.trim() === "") {
        showError(password, "Password is required");
        valid = false;
    }

    if (!valid) {
        event.preventDefault();
    }
});

function showError(input, message) {

    const error = document.createElement("span");

    error.className = "error-message";
    error.textContent = message;

    input.after(error);
}