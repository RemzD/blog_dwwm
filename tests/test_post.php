<?php

/*
 * Fichier de test de la classe Post.
 * 
 * Nécessite un utilisateur avec l’ID 12 et l’authorisation 3 ns la table user
 * Aucune entrée de la table user ne doit avoir l’ID 2
 * Nécessite un utilisateur avec l’ID 1 et l’authorisation INFÉRIEUR à 3
 * 
 */

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

require_once('testing_tools.php');
require(dirname(__FILE__) . '/../model/post.php');

echo "\n";

///////////////////////////////////////////////////////////////////////////////////
// teste getPosts
$testName = 'getPosts';
$testDescription = 'Renvoie la liste des posts.';

$posts = NS_Blog\Post::getPosts();
if (count($posts) > 2
    && isset($posts[0]->id)
) {
    $status = "ok";

} else {
    $status = "echec";
}
$formatTestLine($testName, $testDescription, $status);

$testDescription = 'Renvoie UN post';

$posts = NS_Blog\Post::getPosts(1);
if (count($posts) === 1
    && isset($posts[0]->id)
) {
    $status = "ok";
    
} else {
    $status = "echec";
}
$formatTestLine($testName, $testDescription, $status);

///////////////////////////////////////////////////////////////////////////////////
// teste createPost
$testName = 'createPost';
$testDescription = 'Le post est correctement ajouté';

$lastId = NS_Blog\Post::getPosts(1)[0]->id;
NS_Blog\Post::createPost('Le titre', 'Le contenue', 12);
$createdPost = NS_Blog\Post::getPosts(1)[0];

if ($createdPost->id === $lastId
    || $createdPost->title !== 'Le titre'
    || $createdPost->content !== 'Le contenue'
    || $createdPost->author != 'bao'
) {
    $status = "echec";
    
} else {
    $status = "ok";
}
$formatTestLine($testName, $testDescription, $status);

$testDescription = 'L’utilisateur n’existe pas dans la BDD';
try {
    NS_Blog\Post::createPost('Le titre', 'Le contenue', 2);
    $status = 'echec';
    
} catch (NS_Blog\UserNotFound $e) {
    $status = "ok";
}
$formatTestLine($testName, $testDescription, $status);

$testDescription = 'L’utilisateur n’a pas les droits suffisants';
try {
    NS_Blog\Post::createPost('Le titre', 'Le contenue', 1);
    $status = 'echec';
    
} catch (NS_Blog\InsufficientPermissions $e) {
    $status = "ok";
}
$formatTestLine($testName, $testDescription, $status);
