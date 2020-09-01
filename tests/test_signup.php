<?php
ini_set('display_errors', 1);

require_once('testing_tools.php');
require(dirname(__FILE__) . '/../model/signup.php');
use NS_Blog\SignUp;

///////////// Teste checkMail /////////////////////

$testName = 'CheckMail';
$testDescription = 'Le mail existe dans la base de donnée.';
if (SignUp::checkMail('rem@remz.fr')) {
    $status = "ok";
} else {
    $status = "echec";
}
$formatTestLine($testName, $testDescription, $status);


$testDescription = "Le mail n'existe pas dans la base de donnée";
if (!SignUp::checkMail('not@in.db')) {
    $status = "ok";
} else {
    $status = "echec";
}
$formatTestLine($testName, $testDescription, $status);

///////////// Teste checkPseudo /////////////////////


$testName = 'CheckPseudo';
$testDescription = 'Le pseudo existe dans la base de donnée.';
if (SignUp::checkPseudo('Remz')) {
    $status = "ok";
} else {
    $status = "echec";
}
$formatTestLine($testName, $testDescription, $status);


$testDescription = "Le pseudo n'existe pas dans la base de donnée";
if (!SignUp::checkPseudo('notmypseudo')) {
    $status = "ok";
} else {
    $status = "echec";
}
$formatTestLine($testName, $testDescription, $status);

///////////// Teste createUser /////////////////////

$testName = 'createUser';
$testDescription = "L'utilisateur existe dans la base de donnée.";
try{
    SignUp::createUser('rem@remz.fr','Azerty1!','remz');
    $status = "echec";
    
} catch(\NS_Blog\AlreadyInDB $e) {
    $status = "ok";
}


$formatTestLine($testName, $testDescription, $status);

$testDescription = "L'utilisateur a bien été créé";

try{
    SignUp::createUser('notmymail1@mail.fr','notmypassword1','notmypseudo1');
    
} catch(\NS_Blog\AlreadyInDB $e) {
    $status = "echec";
}
$status = "ok";


$formatTestLine($testName, $testDescription, $status);
