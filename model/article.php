<?php
include('config/db.php');

class article
{
    private $mysqli;
    private $row = array();

    public function __construct(Db $dbObj)
    {
        $this->mysqli = $dbObj->db;
    }

    /**
     * @return array
     */
    public function getRow()
    {
        return $this->row;
    }

    /**
     * @param $title
     * @param $content
     * @param $picture
     * @param $author
     * @return false|mysqli_stmt
     */
    public function create_article_admin($title, $content, $picture, $author)
    {
        // on prepare la requête en indiquant les lignes à insérer.
        if (!($stmt = $this->mysqli->prepare('INSERT INTO articles(title,content,picture,author) VALUES (?,?,?,?)'))) {
            echo  "Echec de la préparation : (" . $this->mysqli->errno . ") " . $this->mysqli->error;
        }
        // on ajoute les valeurs à la préparation et on définit leur type.
        if (!$stmt->bind_param("ssss", $title, $content, $picture, $author)) {
            echo "Echec lors du liage des paramètres : (" . $stmt->errno . ") " . $stmt->error;
        }
        // On execute le la requête.
        if (!$stmt->execute()) {
            echo "Echec lors de l'exécution : (" . $stmt->errno . ") " . $stmt->error;
        }
    }

    /**
     * @param $value
     * @return string
     */
    public function escape_string($value)
    {
        return $this->mysqli->real_escape_string($value);
    }

    /**
     * @return array|null
     */
    public function read_all_articles()
    {
        $sql = "SELECT * FROM articles ORDER BY date DESC ";
        $query = $this->mysqli->query($sql);
        while ($row = $query->fetch_assoc()) {
        $this->row[] = $row;
        }
        return $row;
    }

    /**
     * @param $id
     * @return array|null
     */
    public function read_one_article($id)
    {
        $sql = "SELECT * FROM articles WHERE id_article = '$id'";
        $query = $this->mysqli->query($sql);
        while ($row = $query->fetch_assoc()) {
            $this->row[] = $row;
        }
        return $row;
    }

    /**
     * @param $id
     */
    public function delete_article($id)
    {
        $sql = "DELETE FROM `articles` WHERE id_article = '$id'";
        $query = $this->mysqli->query($sql);

    }

    /**u
     * @param $title
     * @param $content
     * @param $picture
     * @param $id
     * @return true|mysqli_stmt
     */
    public function update_article_admin($title, $content, $picture, $id)
    {
        $sql = 'UPDATE articles SET title=?, content=?, picture=? WHERE id_article=?';
        $stmt = $this->mysqli->prepare($sql);
        $stmt->bind_param('sssi', $title,$content, $picture, $id);
        $stmt->execute();
        if ($stmt->error) {
            echo "FAILURE" . $stmt->error;
        } else echo "Updated {$stmt->affected_rows} rows";
        $stmt->close();
        return $stmt;
    }

}
