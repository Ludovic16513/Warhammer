<?php
include('config/db.php');

/**
 * Class article
 */
class article
{
    private $mysqli;
    private $row = array();
    private $title;
    private $content;
    private $picture;
    private $author;
    private $id_article;

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
     * @return int
     */
    public function get_id_article()
    {
        return $this->id_article;
    }

    /**
     * @return string
     */
    public function get_title()
    {
        return $this->title;
    }

    /**
     * @return string
     */
    public function get_content()
    {
        return $this->content;
    }

    /**
     * @return string
     */
    public function get_author()
    {
        return $this->author;
    }

    /**
     * @return string
     */
    public function get_picture()
    {
        return $this->picture;
    }


    // < ----- SET ------>

    public function set_id_article(int $id_article)
    {
        $this->id_article = $id_article;
    }

    public function set_title(string $title)
    {
        $this->title = $title;
    }

    public function set_content(string $content)
    {
        $this->content = $content;
    }

    public function set_author(string $author)
    {
        $this->author = $author;
    }

    public function set_picture(string $picture)
    {
        $this->picture = $picture;
    }


    // < ------ LISTER TOUS LES ARTICLES ---->

    /**
     * @return array|null
     */
    public function read_all_articles()
    {
        $sql = "SELECT * FROM articles ORDER BY date DESC "; //selection des articles par date décroissante.
        $query = $this->mysqli->query($sql);
        while ($row = $query->fetch_assoc()) {
            $this->row[] = $row;
        }
        return $row;
    }

    // < ------ LISTER UN ARTICLE ---->
    /**
     * @return array|null
     */
    public function read_one_article()
    {
        $id_article = $this->get_id_article();
        $stmt = $this->mysqli->prepare("SELECT * FROM articles WHERE id_article = ?");
        $stmt->bind_param("i", $id_article);
        $stmt->execute();
        $result = $stmt->get_result();
        while ($row = $result->fetch_assoc()) {
            $this->row[] = $row;
            return $this->row;
        }
    }


// < ------ UPLOAD DES PHOTOS  ---->

    public function upload_picture()
    {
        if ($_FILES['photo']['error']) { // < --- gestion des erreurs de l'upload -->

            switch ($_FILES['photo']['error']) {
                case 1:
                    $_SESSION['message'] = "La taille du fichier est plus grande que la limite autorisée par le serveur (paramètre upload_max_filesize du fichier php.ini).";
                    include 'view/article/Home_create_admin.php';
                    return false;
                    break;

                case 2:
                    $_SESSION['message'] = "La taille du fichier est plus grande que la limite autorisée par le formulaire (paramètre post_max_size du fichier php.ini).";
                    include 'view/article/Home_create_admin.php';
                    return false;
                    break;

                case 3:
                    $_SESSION['message'] = "L'envoi du fichier a été interrompu pendant le transfert.";
                    include 'view/article/Home_create_admin.php';
                    return false;

                case 4: // < --- image vide  mais on execute l'upload -->
                    $path = 'img/'; //
                    move_uploaded_file($_FILES['photo']['tmp_name'], $path . $_FILES['photo']['name']); // < --- DEPLACEMENT DU FICHIER -->Déplacement du fichier du répertoire temporaire, puis stocké dans le répertoire de destination.
                    return true;
                    break;
            }
        }
        else { // < --- execution de l'upload -->
            if ((isset($_FILES['photo']['name']) && ($_FILES['photo']['error'] == UPLOAD_ERR_OK))) {
                $path = 'img/';
                move_uploaded_file($_FILES['photo']['tmp_name'], $path . $_FILES['photo']['name']);
                return true;
            }
            else{
                return false;
            }
        }
    }


    // < ---- CREATION D'UN ARTICLE ---->

    public function create_article_admin()
    {
        $title = $this->get_title();
        $content = $this->get_content();
        $picture = $this->get_picture();
        $author = $this->get_author();

        if (!($stmt = $this->mysqli->prepare('INSERT INTO articles(title,content,picture,author) VALUES (?,?,?,?)'))) {
            echo  "Echec de la préparation : (" . $this->mysqli->errno . ") " . $this->mysqli->error;
        }
        $stmt->bind_param("ssss", $title, $content, $picture, $author);
        // On execute le la requête.
        if ($stmt->execute()) {
          return true;
        }
        else{
            return false;
        }
    }


    // < ------ SUPPRESSION D'UN ARTICLE ---->

    /**
     * @return bool
     */
    public function delete_article()
    {
        $id = $this->get_id_article();
        $sql = "DELETE FROM `articles` WHERE id_article = '$id'";
        $query = $this->mysqli->query($sql);

        $sql = 'DELETE FROM `articles` WHERE id_article=?';
        $stmt = $this->mysqli->prepare($sql);
        $stmt->bind_param('i', $id);
        $stmt->execute();
        if ($stmt->error) {
            echo "FAILURE" . $stmt->error;
            return false;
        } else
            $stmt->close();
        return true;
    }


    // < ------ MISE A JOUR D'UN ARTICLE ---->

    public function update_article_admin()
    {
        $title = $this->get_title();
        $content = $this->get_content();
        $picture = $this->get_picture();
        $id = $this->get_id_article();

        $sql = 'UPDATE articles SET title=?, content=?, picture=? WHERE id_article=?';
        $stmt = $this->mysqli->prepare($sql);
        $stmt->bind_param('sssi', $title,$content, $picture, $id);

        $stmt->execute();
        if ($stmt->error) {
            echo "FAILURE" . $stmt->error;
            return false;
        }
        else
        $stmt->close();
        return true;
    }


    // < ------ METHODE DE SECURITE ---->
    /**
     * @param $value
     * @return string
     */
    public function escape_string($value)
    {
        return $this->mysqli->real_escape_string($value);
    }



}
