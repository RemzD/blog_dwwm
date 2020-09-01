<?php

namespace NS_Blog;

require_once(dirname(__FILE__) . '/../model/forgot_password.php');
require_once(dirname(__FILE__) . '/../model/reset_password.php');

function process_post() {
    if (isset($_POST["email"])) {
        sendNewPasswordMail(filter_input(INPUT_POST, 'email'));
    } elseif (isset($_POST["key"])) {
        ResetPassword::setNewPassword(
            filter_input(INPUT_POST, 'key'),
            filter_input(INPUT_POST, 'password1')
        );
    } else {
        throw new \Exception('paramètres invalides');
    }
}

function sendNewPasswordMail(string $email): void {
    if (User::checkMail($email)) {
        ForgotPassword::sendNewPasswordMail($email);
    } else {
        throw new NotFoundInDB();
    }
}
