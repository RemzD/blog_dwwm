class PasswordForm extends Form {
    isValid() {
        if (super.isValid()) {
            let pass = this.form.querySelectorAll("input[type=password]");
            let message = this.form.querySelector("#message");

            if (pass[0].value === pass[1].value) {
                message.textContent = "";
                return true;
            } else {
                message.textContent = "Les mots de passes ne sont pas identiques";
                return false;
            }
        }
    }
}