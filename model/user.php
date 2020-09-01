<?php

namespace NS_Blog;

require_once('db.php');

class NotFoundInDB extends \Exception {
}

class User extends DB {
    public function __construct() {
        parent::__construct();
        $this->table = 'user';
    }

    public static function checkPassword($email, $password) {
        try {
            $user = self::getByEmail($email);

        } catch (NotFoundInDB $e) {
            return false;
        }
        
        if (password_verify($password, $user->password)) {
            return $user;
        }
        return false;
    }

    public static function getByEmail(string $email) {
        $user = new self();
        $user->fetchByEmail($email);
        return $user;
    }

    public static function getByPseudo(string $pseudo) {
        $user = new self();
        $user->fetchByPseudo($pseudo);
        return $user;
    }

    public static function getById(string $id) {
        $user = new self();
        $user->fetchById($id);
        return $user;
    }

    protected function fetchByEmail($email) {
        $request = $this->db->prepare(
            "SELECT * FROM $this->table WHERE email = :email"
        );
        $request->bindValue(":email", $email);

        $this->fetchInfos($request);
    }

    protected function fetchById($id) {
        $request = $this->db->prepare(
            "SELECT * FROM $this->table WHERE id = :id"
        );
        $request->bindValue(":id", $id);

        $this->fetchInfos($request);
    }

    protected function fetchByPseudo($pseudo) {
        $request = $this->db->prepare(
            "SELECT * FROM $this->table WHERE pseudo = :pseudo"
        );
        $request->bindValue(":pseudo", $pseudo);

        $this->fetchInfos($request);
    }

    protected function fetchInfos($request) {
        $request->setFetchMode(\PDO::FETCH_INTO, $this);
        $request->execute();
        $result = $request->fetch();

        if (!$result) {
            throw new NotFoundInDB();
        }
    }

    public static function updateRandKey($email, $randomKey) {
        $user = new self();
        $request = $user->db->prepare(
            "UPDATE user 
            SET newPasswordKey = :randomKey 
            WHERE email = :email"
        );
        $request->bindValue(":randomKey", $randomKey);
        $request->bindValue(":email", $email);
        $request->execute();
    }

    public static function updateNewPasswordCreationDate($randomKey) {
        $user = new self();
        $request = $user->db->prepare(
            "UPDATE user 
            SET newPasswordKeyCreationDate = NOW()
            WHERE newPasswordKey = :randomKey"
        );
        $request->bindValue(":randomKey", $randomKey);
        $request->execute();
    }

    function updatePassword($new_password) {
        $hashedPass = password_hash($new_password, PASSWORD_DEFAULT);

        $request = $this->db->prepare(
            "UPDATE $this->table
             SET  password = :hashed
             WHERE id = $this->id "
        );
        $request->bindValue(":hashed", $hashedPass);
        $request->execute();
    }

    public static function checkMail($email) {
        try {
            self::getByEmail($email);
        } catch (NotFoundInDB $e) {
            return false;
        }
        
        return true;
    }

    public static function checkPseudo($pseudo) {
        try {
            self::getByPseudo($pseudo);
        } catch (NotFoundInDB $e) {
            return false;
        }
        
        return true;
    }
}
