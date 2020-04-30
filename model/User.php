<?php

include('../config/db.php');

/**
 * Class User
 */
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

    /**
     * @param $username
     * @param $password
     * @return array|bool|null
     */
    public function check_login_user($username, $password)
    {
        $sql = "SELECT * FROM user WHERE name = '$username'";
        $query = $this->mysqli->query($sql);
        $row = $query->fetch_assoc();
        if ($query->num_rows > 0 && password_verify($password, $row['password'])) {
            $this->mysqli->close();
            return $this->row[] = $row;
        } else {
            return false;
        }
    }

    /**
     * @param $username
     * @param $password
     * @return array|bool|null
     */
    public function check_login_admin($username, $password)
    {
        $sql = "SELECT * FROM admin WHERE name = '$username'";
        $query = $this->mysqli->query($sql);
        $row = $query->fetch_assoc();
        if ($query->num_rows > 0 && password_verify($password, $row['password'])) {
            $this->mysqli->close();
            return $this->row[] = $row;
        } else {
            return false;
        }
    }

    /**
     * @return bool
     */
    public function disconnect()
{
   return session_destroy();
}

    /**
     *
     */
    public function read_all_user()
    {
        $sql = "SELECT * FROM user";
        $query = $this->mysqli->query($sql);
        while ($row = $query->fetch_assoc()) {
            $this->row[] = $row;
        }
    }

    /**
     * @param $id
     */
    public function delete_user($id)
    {
        $sql = "DELETE FROM `user` WHERE id = '$id'";
        $query = $this->mysqli->query($sql);
    }

    /**
     * @param $session
     * @return array|null
     */
    public function read_one_user($session)
    {
        $sql = "SELECT * FROM user WHERE name = '$session'";
        $query = $this->mysqli->query($sql);
        while ($row = $query->fetch_assoc()) {
           $this->row[] = $row;
        }
        return $row;
    }

    /**
     * @param $session
     * @return array|null
     */
    public function read_one_admin($session)
    {
        $sql = "SELECT * FROM admin WHERE name = '$session'";
        $query = $this->mysqli->query($sql);
        while ($row = $query->fetch_assoc()) {
            $this->row[] = $row;
        }
        return $row;
    }


    /**
     * @param $name
     * @param $pass
     * @param $email
     * @return string
     */
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
        } else {
            echo 'utilisateur ou email existant';
        }
        return $sql;
    }

    /**
     * @param $name
     * @param $pass
     * @param $email
     * @param $id
     * @return string
     */
    public function update_user($name, $pass, $email, $id)
    {
        $hash = password_hash($pass, PASSWORD_BCRYPT);

        $sql = 'UPDATE user SET name=?, password=?, email=? WHERE id=?';

        $stmt = $this->mysqli->prepare($sql);

        $stmt->bind_param('sssi', $name, $hash, $email, $id);
        $stmt->execute();

        if ($stmt->error) {
            echo "FAILURE" . $stmt->error;
        } else echo "Updated {$stmt->affected_rows} rows";
        $stmt->close();

        return $stmt;
    }

    public function escape_string($value)
    {
        return $this->mysqli->real_escape_string($value);
    }
}
