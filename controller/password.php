<?php 
namespace NS_Blog;

class Password {

    public static function checkPasswords($password, $password2){
        if($password === $password2 && self::checkPatterns($password)){
            return true;
        }else{
            return false;
        }
    }

    protected static function checkPatterns($password){
        $isValid = true;
        $patterns = [
            "lowercase" =>"/[a-z]/",
            "uppercase" =>"/[A-Z]/",
            "digits" =>"/\d/",
            "special_c" =>"/[@$!%*?&]/",
            "spaces_and_length" =>"/^\S{8,72}$/"
        ];
        
        foreach(array_keys($patterns) as $p){
            if(!preg_match($patterns[$p], $password)){
                $isValid = false;
            }
        }
        return $isValid;
    }

    

}

