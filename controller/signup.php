<?php


require_once(dirname(__FILE__) . '/../model/signup.php');

function createUser(string $email, string $password, string $pseudo) : Array {
    try {
        \NS_Blog\SignUp::createUser($email, $password, $pseudo);
    } catch (\NS_Blog\AlreadyInDB $e) {
        return [
            'status' => 'failed',
            'reason' => 'already in DB'
        ];
    }
    return [
        'status' => 'created'
    ];
}