<?php

namespace NS_Blog;

use Exception;


require(dirname(__FILE__) . '/../model/signup.php');

class Activation extends Signup {
    public function __construct() {
        parent::__construct();
        $this->table = 'signup_pending';
    }

    public static function activateUser(string $pseudo, string $key) {
        $req_user = new self();
        try{
            $req_user->fetchByPseudo($pseudo);
        } catch (NS_Blog\NotFoundInDB $e) {
            return ['status' => 'already_in_db'];
        } 
            if ($req_user->random_key === $key) {
                parent::moveUser($pseudo);
                return ['status' => 'activated'];
            } else {
                return ['status' => 'already_in_db'];
            }
        }
    }
	
