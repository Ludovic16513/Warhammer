<?php
include('config/db.php');

class sheet
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

    public function select_sheets($session)
    {
        $sql = "SELECT *
    FROM `user`
    INNER JOIN
    `sheet` ON sheet.id_user = user.id
    WHERE user.name = '$session'";
        $query = $this->mysqli->query($sql);

        if ($query->num_rows === 0)
        {
            $sql = "SELECT * FROM user WHERE name = '$session'";
            $query = $this->mysqli->query($sql);

            while ($row = $query->fetch_assoc()) {
             $this->insert_sheet($row['id']);
             $this->select_sheets($session);
            }
        }
        else{
            while ($row = $query->fetch_assoc()) {

                $this->row[] = $row;
            }
        }
    }


    /**
     * @param $id
     */
    public function delete_sheet($id)
    {

        if (!($stmt = $this->mysqli->prepare("DELETE FROM `sheet` WHERE id_sheet_prim = ?"))) {
            $_SESSION['message'] = "Echec lors de la préparation : (" . $this->mysqli->errno . ") " . $this->mysqli->error;
        }

        /* Requête préparée, étape 2 : lie les valeurs et exécute la requête */
        if (!$stmt->bind_param("i", $id)) {
            $_SESSION['message'] = "Echec lors du liage des paramètres : (" . $stmt->errno . ") " . $stmt->error;
        }

        if (!$stmt->execute()) {
            $_SESSION['message'] = "Echec lors de l'exécution de la requête : (" . $stmt->errno . ") " . $stmt->error;
        }


    }


    public function insert_sheet($id_user)
    {
        if (!($stmt = $this->mysqli->prepare("INSERT INTO sheet(id_user) VALUES (?)"))) {
            $_SESSION['message'] = "Echec lors de la préparation : (" . $this->mysqli->errno . ") " . $this->mysqli->error;
        }

        /* Requête préparée, étape 2 : lie les valeurs et exécute la requête */
        if (!$stmt->bind_param("i", $id_user)) {
            $_SESSION['message'] = "Echec lors du liage des paramètres : (" . $stmt->errno . ") " . $stmt->error;
        }

        if (!$stmt->execute()) {
            $_SESSION['message'] = "Echec lors de l'exécution de la requête : (" . $stmt->errno . ") " . $stmt->error;
        }
    }

    public function escape_string($value)
    {

        return $this->mysqli->real_escape_string($value);
    }

}