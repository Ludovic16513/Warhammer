<?php

class Db {

    public $db;

    public function __construct()
    {
        //Les valeurs sont à remplacer bien entendu
        $this->db = new mysqli("localhost","root","","warhammer");

        if ($this->db->connect_errno) {
            echo "Echec lors de la connexion à MySQL : (" . $this->db->connect_errno . ") " . $this->db->connect_error;
        }

        return $this->db;
    }

}