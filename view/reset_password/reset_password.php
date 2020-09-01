<?php

if($_SERVER['REQUEST_METHOD'] === "POST") {
    require_once realpath($_SERVER["DOCUMENT_ROOT"]) . "/../controller/reset_password.php";
    header('Content-type: application/json');

    try {
        NS_Blog\process_post();
        echo json_encode(['status' => 'succes']);
    } catch (NS_Blog\NotFoundInDB $e) {
        echo json_encode(['status' => 'failure']);
    }
    die;
} else {
    $key = filter_input(INPUT_GET, 'key');
    if (!$key) {
        header('Location: index.html');
        die;
    }
}
?>

<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="utf-8" />
    <link rel="stylesheet" href="/style/reset_password.css">
    <script src="/js/form.js" defer></script>
    <script src="js/password_form.js" defer></script>
    <script src="js/send_password.js" defer></script>
    <script type="text/javascript" src="js/newPassword.js" defer></script>
    
    <title>Nouveau Mot de Passe</title>
</head>

<body>
    <div class="container">
        <form action='reset_password.php' id="resetPasssword" method="POST">
            <h2>Nouveau Mot de Passe</h2>
            
            <label for="password">Nouveau Mot de Passe</label>
            <input type="password" id="password1" name="password1" pattern="^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[@$!%*?&])[A-Za-z\d@$!%*?&]{8,72}$" title="Doit contenir au moins un chiffre et une lettre majuscule et minuscule, caractères spéciaux @$!%*?& et au moins 8 caractères ou plus "
                required>

            <label for="password">Confirmer Mot de Passe</label>
            <input type="password" id="password2" name="password2" pattern="^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[@$!%*?&])[A-Za-z\d@$!%*?&]{8,72}$" title="Doit contenir au moins un chiffre et une lettre majuscule et minuscule, caractères spéciaux @$!%*?& et au moins 8 caractères ou plus "
                required>
            
            <input type="button" value="Soumettre">
            <input style="display:none" type="text" name="key" value=<?php echo $key ?> >

            <p id="message"></p>
            <p id="errorMessage" style="visibility: hidden">Nous ne retrouvons pas l'utilisateur en BDD ou le lien n'est plus actif.</p>
        </form>

        <p id="succesMessage" style="visibility: hidden">Votre mot de passe a bien été modifié. <a href="/login">Allez sur la page de login</a> </p>
    </div>

    <div id="requiredCharacters">
        <h3>Le mot de passe doit contenir les éléments suivants &nbsp;:</h3>
        <p id="letter" class="invalid">Lettre<b>minuscule</b></p>
        <p id="capital" class="invalid">Lettre<b>majuscule</b></p>
        <p id="number" class="invalid"><b>Chiffre</b></p>
        <p id="length" class="invalid"><b>8 caractères</b> minimum</p>
        <p id="specialCharacter" class="invalid"><b>caractères spéciaux</b></p>
    </div>

    <h3 id="passIdent">Les deux mot de passe doivent être identiques</h3>

</body>

</html>
