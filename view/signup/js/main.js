let form = new SignupForm("form", "signup.php");

form.onPostResolve = function(request) {
    let creationStatus = JSON.parse(request.responseText);

    let message = document.getElementById('message');

    switch (creationStatus["status"]) {
        case "failed":
            message.textContent = "Ces identifiants sont déjà utilisés";
            break;
        case "created":
            message.textContent =
                "Votre compte a bien été créé, un email de validation vous a été envoyé. ";
            break;
        default:
            message.textContent = "Une erreur est survenue, veuillez réessayer.";

    }
};
