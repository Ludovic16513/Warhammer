<?php

require '../model/Login.php';
require '../config/db.php';

class LoginManager extends Login
{
    protected $user;
    protected $password;
    protected $mysqli;

    private $db;
    protected $result;
    protected $stmt;

    public function __construct(Db $dbObj)
    {
        $this->mysqli = $dbObj->db;
        parent::__construct();
    }

    public function SelectQuery()
    {
        $this->result = $this->mysqli->query('SELECT password FROM user where name =" '.$this->user.' "');
        while ($row = $this->result->fetch_assoc()) {
            $this->result = $row['password'];
        }
    }

    public function InsertQuery()
    {
        if (!($this->stmt = $this->mysqli->prepare("INSERT INTO user(name, password) VALUES (?,?)"))) {
            echo "Echec de la préparation : (" . $this->mysqli->errno . ") " . $this->mysqli->error;
        }
    }

    public function Get_UserPassword()
    {
        return $this->result;
    }

}



