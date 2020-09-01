<?php

namespace NS_Blog;

require_once('user.php');

class ResetPassword extends User{
    public static function setNewPassword($key, $password) {
        $user = new self();

        $user->fetchByRandomKey($key);
        
        if ($user->randomKeyExpired() == false) {
            $user->cleanKeyfield();
            header('Location: new_pass_redirection.php?state=3');
            die;
        }else {
            $user->updatePassword($password);
            $user->cleanKeyfield();
        } 
    }

    private function fetchByRandomKey($key) {
        $request = $this->db->prepare(
            "SELECT * FROM $this->table WHERE newPasswordKey = :key"
        );
        $request->bindValue(":key", $key);

        $this->fetchInfos($request);
    }

    private function cleanKeyfield() {
        $request = $this->db->prepare(
            "UPDATE user
            SET newPasswordKey = NULL, newPasswordKeyCreationDate = NULL
            WHERE newPasswordKey = :key"
        );
        $request->bindValue(":key", $this->newPasswordKey);
        $request->execute();
    } 

    private function randomKeyExpired() { 
        $now = new \DateTime();
        $pwd_creation_date = new \DateTime($this->newPasswordKeyCreationDate);

        $diff = date_diff($now, $pwd_creation_date);
        if ($diff->d >2) {
            return false;
        } else {
            return true;
        }
    }
}
