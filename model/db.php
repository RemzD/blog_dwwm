<?php

namespace NS_Blog;

class DB
{
    public $db;

    function __construct()
    {
        try {
            $this->db = new \PDO(
                "mysql:host=localhost;dbname=blog_dwwm_2020",
                "root",
                ""
            );
            //On définit le mode d'erreur de \PDO sur Exception
            $this->db->setAttribute(\PDO::ATTR_ERRMODE, \PDO::ERRMODE_EXCEPTION);
        } catch (\PDOException $e) {
            echo "Erreur : " . $e->getMessage();
        }
    }
}
