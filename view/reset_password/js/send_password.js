let passwordForm = new PasswordForm('resetPasssword', 'reset_password.php');

passwordForm.onPostResolve = function(request) {
    let parsedResponse = JSON.parse(request.responseText);

    switch (parsedResponse["status"]) {
        case "succes":
            document.getElementById('succesMessage').style.visibility = 'visible';
            document.getElementById('errorMessage').style.visibility = 'hidden';
            passwordForm.form.style.visibility = 'hidden';
            break;

        case 'failure':
            document.getElementById('errorMessage').style.visibility = 'visible';
            break;

        default:
            throw new Error('Unexpected status received');
    }
}