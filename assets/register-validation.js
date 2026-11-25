const form = document.getElementById("registerForm");

form.addEventListener("submit", function(event) {

    const username = document.getElementById("username");
    const email = document.getElementById("email");
    const password = document.getElementById("password");
    const confirmPassword = document.getElementById("password_confirm");

    // Supprimer les anciens messages
    document.querySelectorAll(".error-message").forEach(function(error) {
        error.remove();
    });

    let valid = true;

    // Vérifier le username
    if (username.value.trim() === "") {
        showError(username, "Username is required");
        valid = false;
    }

    // Vérifier l'email
    if (email.value.trim() === "") {
        showError(email, "Email is required");
        valid = false;
    }
    else if (!email.value.includes("@") || !email.value.includes(".")) {
        showError(email, "Email is not valid");
        valid = false;
    }

    // Vérifier le mot de passe
    if (password.value.length < 8) {
        showError(password, "Password must contain at least 8 characters");
        valid = false;
    }

    // Vérifier la confirmation
    if (confirmPassword.value !== password.value) {
        showError(confirmPassword, "Passwords do not match");
        valid = false;
    }

    // Empêcher l'envoi si le formulaire n'est pas valide
    if (!valid) {
        event.preventDefault();
    }
});


// Afficher un message près du champ
function showError(input, message) {

    const error = document.createElement("span");

    error.className = "error-message";
    error.textContent = message;

    input.after(error);
}