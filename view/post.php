<?php
/**
 * Si la requête est un POST :
 *     Récupère les champs de la requête POST, nettoie le texte reçu
 *     et essaie de créer le post en base.
 * 
 *     Renvoie un JSON le post créé si l’opération a réussi, sinon
 *     renvoie la raison de l’echec.
 * 
 * Sinon
 *     Renvoie les 15 derniers posts
 * 
 */

$serverRoot = realpath($_SERVER['DOCUMENT_ROOT']);
require_once $serverRoot . '/../model/post.php';
require_once $serverRoot . '/../model/user.php';

session_start();
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_SESSION['id'])) {
        $postTitle = filter_input(INPUT_POST, 'postTitle');
        $postContent = filter_input(INPUT_POST, 'postContent');
        
        if ($postTitle && $postContent) {
            try {
                \NS_Blog\Post::createPost($postTitle, $postContent, $_SESSION['id']);
                $lastPost = \NS_Blog\Post::getPosts(1);
                $response = [
                    'status' => 'created',
                    'post' => $lastPost[0]
                ];
            } catch (\NS_Blog\UserNotFound $e) {
                $response = [
                    'status' => 'failure',
                    'reason' => 'unknown user'
                ];
            } catch (\NS_Blog\InsufficientPermissions $e) {
                $response = [
                    'status' => 'failure',
                    'reason' => 'insufficient permissions'
                ];
            }
        } else {
            $response = [
                'status' => 'failure',
                'reason' => 'empty field'
            ];
        }
    } else {
        $response = [
            'status' => 'failure',
            'reason' => 'not logged'
        ];
    }
} else {
    $response = [
        'status' => 'posts list',
        'posts' => \NS_Blog\Post::getPosts(20)
    ];
}


header('Content-type: application/json');
echo json_encode($response);