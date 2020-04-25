<?php

require '../config/db.php';
require '../model/security.php';

class User
{

    private $mysqli;
    private $row = array();


    public function __construct(Db $dbObj)
    {
        $this->mysqli = $dbObj->db;
        $this->row = $this->getRow();
    }

    public function getRow()
    {
        return $this->row;
    }

    public function check_login($username, $password)
    {
        $sql = "SELECT * FROM user WHERE name = '$username'";
        $query = $this->mysqli->query($sql);
        $row = $query->fetch_assoc();
        if ($query->num_rows > 0 && password_verify($password, $row['password'])) {
            echo 'ok';
            $this->mysqli->close();
            return $this->row[] = $row;

        }
        else {
            return false;
        }
    }

    public function read_user()
    {
        $sql = "SELECT * FROM user";
        $query = $this->mysqli->query($sql);
        while ($row = $query->fetch_assoc()) {
            $this->row[] = $row;
        }
    }

    public function create_login($name, $pass, $email)
    {
        // on crypte le mot de passe
        $hash = password_hash($pass, PASSWORD_BCRYPT);

        $sql = "SELECT * FROM user WHERE name = '$name'";
        $query = $this->mysqli->query($sql);

        if ($query->num_rows === 0) {
            // on prepare la requête en indiquant les lignes à insérer.
            if (!($stmt = $this->mysqli->prepare('INSERT INTO user(name, password, email) VALUES (?,?,?)'))) {
                return "Echec de la préparation : (" . $this->mysqli->errno . ") " . $this->mysqli->error;
            }
            // on ajoute les valeurs à la préparation et on définit leur type.
            if (!$stmt->bind_param("sss", $name, $hash, $email)) {
                return "Echec lors du liage des paramètres : (" . $stmt->errno . ") " . $stmt->error;
            }
            // On execute le la requête.
            if (!$stmt->execute()) {
                return "Echec lors de l'exécution : (" . $stmt->errno . ") " . $stmt->error;
            }
            else {
                return false;
            }
        }
        else {
            echo 'utilisaeur existant';
        }
        return $sql;
    }

    public function escape_string($value)
    {
        return $this->mysqli->real_escape_string($value);
    }
}
