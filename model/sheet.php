<?php
include('config/db.php');

class sheet
{

    private $mysqli;
    private $row = array();
    private $sheet_id;
    private $id_user;
    private $session;

    public function __construct(Db $dbObj)
    {
        $this->mysqli = $dbObj->db;
        $this->row = $this->getRow();
    }

    // <--------- GET ----------->


    public function getRow()
    {
        return $this->row;
    }

    public function get_sheet_id()
    {
        return $this->sheet_id;
    }

    public function get_session()
    {
        return $this->session;
    }

    public function get_id_user()
    {
        return $this->id_user;
    }

    // <--------- SET ----------->


    public function set_sheet_id(int $id)
    {
        $this->sheet_id = $id;
    }

    public function set_session($session)
    {
      $this->session = $session;
    }

    public function set_id_user($id_user)
    {
        $this->id_user = $id_user;
    }


    // < ------- SELECTIONNE LES FICHES DE L'UTILITEUR -------->

    public function select_sheets()
    {
        $session = $this->get_session();

        $sql = "SELECT * FROM `user` INNER JOIN `sheet` ON sheet.id_user = user.id WHERE user.name = ?";
        $stmt = $this->mysqli->prepare($sql);
        $stmt->bind_param("s", $session);
        $stmt->execute();

        // RESULT
        $result = $stmt->get_result();
        $result->fetch_assoc();
        if ($result->num_rows === 0) {
            $sql = "SELECT * FROM user WHERE name = ?";
            $stmt = $this->mysqli->prepare($sql);
            $stmt->bind_param("s", $session);
            $stmt->execute();
            $result = $stmt->get_result();
            while ($row = $result->fetch_assoc()) {
                $this->set_id_user($row['id']);
             $this->insert_sheet();
             $this->select_sheets();
            }
        }
        else{
            $sql = "SELECT * FROM `user` INNER JOIN `sheet` ON sheet.id_user = user.id WHERE user.name = ?";
            $stmt = $this->mysqli->prepare($sql);
            $stmt->bind_param("s", $session);
            $stmt->execute();
            $result = $stmt->get_result();
            while ($row = $result->fetch_assoc()) {
                $this->row[] = $row;
            }
        }
    }


     // < ------- INSERER UNE FICHE -------->

    public function insert_sheet()
    {
        $id_user = $this->get_id_user();

         $stmt = $this->mysqli->prepare("INSERT INTO sheet(id_user) VALUES (?)");
         $stmt->bind_param("i", $id_user);
         if ($stmt->execute())
         {
             return true;
         }
       else{
           return false;
       }
    }


    // < ------- SUPPRIMER UNE FICHE -------->


    public function delete_sheet()
    {
        $id = $this->get_sheet_id();

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


    // < ------- FUNCTION DE SECU -------->


    public function escape_string($value)
    {

        return $this->mysqli->real_escape_string($value);
    }

}