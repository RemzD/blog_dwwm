<?php
/**
 * Fichier de test de la classe User.
 * 
 * À lancer en ligne de commande.
 * 
 * Nécessite d’avoir un serveur de base de donné en route avec deux utilisateurs
 * 
 *      email: remz@remz.fr         password: Password1234!      pseudo: Remz
 *      email: yannamar@gmail.com   password: eiovr341

 */

require_once('testing_tools.php');
require_once(dirname(__FILE__) . '/../model/user.php');
use NS_Blog\User;

///////////////////////////////////////////////////////////////////////////////////
// teste checkPassword
$testName = 'checkPassword';
$testDescription = 'Le mot de passe est bon';
$user = User::checkPassword('remz@remz.fr', 'Password1234!');
if ($user) {
    $status = "ok";
} else {
    $status = "echec";
}
$formatTestLine($testName, $testDescription, $status);

$testDescription = 'Le mot de passe n’est pas bon';
$user = User::checkPassword('remz@remz.fr', 'bad_password');
if (!$user) {
    $status = "ok";
} else {
    $status = "echec";
}
$formatTestLine($testName, $testDescription, $status);


///////////////////////////////////////////////////////////////////////////////////
// teste getById
$functionName = 'getById';
$testDescription = 'L’id est dans la base de donnée';
try {
    $user = User::getById(1);
    $status = "ok";
} catch (\Error $e) {
    $status = "echec";
}
$formatTestLine($functionName, $testDescription, $status);

$testDescription = 'L’id n’est pas dans la base de donnée';
try {
    $user = User::getById(2);
    $status = "echec";
} catch (\NS_Blog\NotFoundInDB $e) {
    $status = "ok";
}
$formatTestLine($functionName, $testDescription, $status);


///////////////////////////////////////////////////////////////////////////////////
// teste updatePassword
$functionName = 'updatePassword';
$testDescription = 'Le mot de passe est correctement changé';

$user = User::checkPassword('yannamar@gmail.com', 'eiovr341');
$user->updatePassword('toto');
$user = User::checkPassword('yannamar@gmail.com', 'toto');
if ($user) {
    $status = "ok";
    $user->updatePassword('eiovr341');
} else {
    $status = "echec";
}
$formatTestLine($functionName, $testDescription, $status);


///////////////////////////////////////////////////////////////////////////////////
//test checkMail
$functionName = 'checkMail';

class testCheckMail extends User {
    public function __construct() {
        parent::__construct();
    }

    public static function testCheckMail($email) {
        return parent::checkMail($email);
    }
}

$testDescription = 'L’email est dans la base de donnée';
$test = new testCheckMail();
if ($test::testCheckMail('remz@remz.fr')) {
    $status = "ok";
} else {
    $status = "echec";
}
$formatTestLine($functionName, $testDescription, $status);

$testDescription = 'L’email n’est pas dans la base de donnée';
if (!$test::testCheckMail('not@exist.fr')) {
    $status = "ok";
} else {
    $status = "echec";
}
$formatTestLine($functionName, $testDescription, $status);

///////////////////////////////////////////////////////////////////////////////////
//test checkPseudo

$testName = 'CheckPseudo';
$testDescription = 'Le pseudo existe dans la base de donnée.';
if (User::CheckPseudo('Remz')) {
    $status = "ok";
} else {
    $status = "echec";
}
$formatTestLine($testName, $testDescription, $status);

$testDescription = "Le pseudo n'existe pas dans la base de donnée";
if (!User::CheckPseudo('notmypseudo')) {
    $status = "ok";
} else {
    $status = "echec";
}
$formatTestLine($testName, $testDescription, $status);
