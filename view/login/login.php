<?php
require(dirname(__FILE__) . '/../../model/user.php');

header('Content-type: application/json');

session_start();

$email = filter_input(INPUT_POST, 'email');
$password = filter_input(INPUT_POST, 'password');

if ($email && $password) {
    $user = \NS_Blog\User::checkPassword($email, $password);

    if ($user) {
        $_SESSION['id'] = $user->id;
        echo json_encode([
            'pseudo' => $user->pseudo,
            'authorisations' => $user->authorisations
        ]);
     
    } else {
        echo json_encode(['error' => 'mauvais ID']);
    }
    
} else {
        echo json_encode([
        'error' => 'Invalid POST',
        'email' => $email,
        'password' => $password
    ]);
}
