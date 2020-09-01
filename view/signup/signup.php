<?php

require_once(dirname(__FILE__) . '/../../controller/signup.php');

$email = filter_input(INPUT_POST, 'email');
$password = filter_input(INPUT_POST, 'password');
$password2 = filter_input(INPUT_POST, 'password2');
$pseudo = filter_input(INPUT_POST, 'pseudo');

if (\NS_Blog\Password::checkPasswords($password, $password2)) {
    echo json_encode(createUser($email, $password, $pseudo));
}
