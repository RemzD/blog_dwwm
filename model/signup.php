<?php

namespace NS_Blog;

require_once('user.php');
require(dirname(__FILE__) . '/../controller/password.php');

class AlreadyInDB extends \Exception {
}
class SignUp extends User {

    public function __construct() {
        parent::__construct();
        $this->table = 'signup_pending';
    }

    public static function checkMail($email) {
        if (parent::checkMail($email)) {
            return true;
        }

        $signup = new self();
        try {
            $signup->fetchByEmail($email);
        } catch (NotFoundInDB $e) {
            return false;
        }
        return true;
    }


    public static function checkPseudo($pseudo) {
        if (parent::checkPseudo($pseudo)) {
            return true;
        }

        $signup = new self();
        try {
            $signup->fetchByPseudo($pseudo);
        } catch (NotFoundInDB $e) {
            return false;
        }
        return true;
    }


    public static function createUser($email, $password, $pseudo) {
        if (self::checkPseudo($pseudo) || self::checkMail($email)) {
            throw new AlreadyInDB();
        } 
        $signup = new self();
        $random_key = md5(rand(0, 10 ** 12));
        $hashedPass = password_hash($password, PASSWORD_DEFAULT);
        $request = $signup->db->prepare(
            "INSERT INTO signup_pending (password, email, pseudo, random_key)
            VALUES  (:hashed, :email, :pseudo, :key) "
        );
        
        $request->execute([
            ":hashed" => $hashedPass,
            ":email" => $email,
            ":pseudo" => $pseudo,
            ":key" => $random_key
        ]);
        
      self::sendValidationMail($pseudo, $random_key, $email);
    }

    public static function moveUser(string $pseudo){
        $signup = new self();
        $request = $signup->db->prepare( 
            "INSERT INTO user (pseudo, email, password)
                SELECT pseudo, email, password 
                FROM signup_pending
                WHERE pseudo = :pseudo
             ;
             
             DELETE FROM signup_pending
             WHERE pseudo = :pseudo"
         );

        $request->execute([
            ":pseudo" => $pseudo
        ]);
    }
        
    
    public static function sendValidationMail($pseudo, $key, $email) {
        $header  = 'MIME-Version: 1.0' . "\r\n";
        $header .= 'Content-type: text/html; charset=utf-8' . "\r\n";
        $header .= 'From: noreply-admin@blog.dwwm.ovh ' . "\r\n";

        $message =
            '<h1> Bonjour ' . $pseudo  . '</h1>,
            <h2>Bienvenue sur "LE BLOG DU SIECLE"</h2>,
            <p>Vous venez de vous inscrire pour la première fois sur notre site.
            Afin de finaliser la dernière étape de votre inscription et activer votre compte, 
            veuillez cliquer sur le lien ci-dessous ou copier/coller dans votre navigateur Internet.</p>
             
            <a href=/signup/activation.php?pseudo='
            . urlencode($pseudo)
            . '&key=' . urlencode($key)
            . '>Veuillez cliquez sur ce lien de confirmation</a>
            <br>
             
            ---------------
            <p>Ceci est un mail automatique, merci de ne pas y répondre.</p>
             
            <p>A bientôt sur notre blog .</p>
            <p>Administrateur "LE BLOG DU SIECLE"</p>';
        $retour = mail($email, 'Confirmation de votre inscription', $message, $header);
    }
}
