<?php

/**
 * Class Db
 */
class Db {

    public $db;

    public function __construct()
    {
        $this->db = new mysqli("localhost","root","","warhammer"); //connexion db MYSQLI

        if ($this->db->connect_errno) { // Gestion des erreurs
            echo "Echec lors de la connexion à MySQL : (" . $this->db->connect_errno . ") " . $this->db->connect_error;
        }

        return $this->db;
    }

}