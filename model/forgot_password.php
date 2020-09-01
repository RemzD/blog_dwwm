<?php
namespace NS_Blog;

require_once('user.php');

class ForgotPassword extends User {
    public static function sendNewPasswordMail($email) {
        $randomKey = md5(rand(0, 10 ** 12));
        self::updateRandKey($email, $randomKey);
        self::updateNewPasswordCreationDate($randomKey);

        $header  = 'MIME-Version: 1.0' . "\r\n";
        $header .= 'Content-type: text/html; charset=utf-8' . "\r\n";
        $header .= 'From: noreply@blog.dwwm.ovh ' . "\r\n";

        $message = 
            '<h2>Votre Mot de passe "LE BLOG DU SIECLE"</h2>
            <p>Bonjour,</p><br>    
            <p>Vous souhaitez modifier votre mot de passe d’accès à votre compte.</p>
            <p>Pour cela, rien de plus simple :
            cliquez sur le lien ci-dessous ou copiez celui-ci directement dans votre navigateur internet :</p>
            <a href=/reset_password/reset_password.php?key='.$randomKey.'>Lien vers nouveauMotDePasse</a>
            <p>A réception de cet email, vous avez 48 heures pour modifier votre mot de passe.</p><br>
            <p>A bientôt sur notre blog .</p>
            <p>Administrateur "LE BLOG DU SIECLE"</p>';

        mail($email, 'Réinitialisation de mot de passe', $message, $header);
    }
}
