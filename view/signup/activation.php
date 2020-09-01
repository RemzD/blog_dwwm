<?php
    require_once(realpath($_SERVER["DOCUMENT_ROOT"])  . '/../controller/activation.php');
?>

<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/style.css">
    <meta http-equiv="refresh" content="5; url = /login" />
    <title>Document</title>
</head>

<body id="redirection">
    <img src="images/redirection.png" alt="redirection">
    <p>
        <?php
        $pseudo = filter_input(INPUT_GET, 'pseudo');
        $key = filter_input(INPUT_GET, 'key');

        if ($pseudo && $key) {
            $state = NS_Blog\Activation::activateUser($pseudo, $key);
            switch ($state['status']) {
                case 'already_in_db':
                    echo 'Votre compte a déjà été validé.';
                    break;
                case 'activated':
                    echo 'Votre compte a bien été validé.';
                    break;
                default:
                    echo 'Une erreur est survenue.';
            }
        }
        ?>
    </p>
    <p>Vous allez être bientôt redirigé vers la page de login...</p>
</body>

</html>
