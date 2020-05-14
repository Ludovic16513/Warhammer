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
        while ($row = $query->fetch_assoc()) {
            $this->row[] = $row;
        }
        return $sql;
    }


    /**
     * @param $id
     */
    public function delete_sheet($id)
    {
        $sql = "DELETE FROM `sheet` WHERE id = '$id'";
        $this->mysqli->query($sql);
    }

    public function insert_sheet($id_user)
    {
        $sql = "INSERT INTO sheet (`id_user`) VALUES ('$id_user')";
        $this->mysqli->query($sql);
    }


    public function escape_string($value)
    {
        return $this->mysqli->real_escape_string($value);
    }

}