<?php
require_once '../model/article.php';

class ArticleController
{
    private $article;

    public function __construct()
    {
        $this->article = new article(new db);
    }

    public function create_article()
    {
        if (isset($_POST['ok'])) {
            $title = $this->article->escape_string($_POST['title']);
            $content = $this->article->escape_string($_POST['content']);
            $author = $this->article->escape_string($_POST['author']);

            if ($_FILES['photo']['error']) {
                switch ($_FILES['photo']['error']) {
                    case 1: // UPLOAD_ERR_INI_SIZE
                        echo "La taille du fichier est plus grande que la limite autorisée par le serveur (paramètre upload_max_filesize du fichier php.ini).";
                        break;
                    case 2: // UPLOAD_ERR_FORM_SIZE
                        echo "La taille du fichier est plus grande que la limite autorisée par le formulaire (paramètre post_max_size du fichier php.ini).";
                        break;
                    case 3: // UPLOAD_ERR_PARTIAL
                        echo "L'envoi du fichier a été interrompu pendant le transfert.";

                        break;
                    case 4: // UPLOAD_ERR_NO_FILE
                        echo "La taille du fichier que vous avez envoyé est nulle.";
                        break;
                }
            } else {
                if ((isset($_FILES['photo']['name']) && ($_FILES['photo']['error'] == UPLOAD_ERR_OK))) {
                    $path = '../public/view/img';
                    $picture = $_FILES['photo']['name'];

                    //déplacement du fichier du répertoire temporaire (stocké(
                    //par défaut) dans le répertoire de destination
                    move_uploaded_file($_FILES['photo']['tmp_name'], $path . $_FILES['photo']['name']);
                    echo "Le fichier " . $_FILES['photo']['name'] . " a été copié dans le répertoire photos";

                    // execution de la requete
                    $this->article->create_article_admin($title, $content, $picture, $author);

                }
            }
        }

    }

    public function home_create_article()
    {
        include '../view/article/Home_create_admin.php';
    }

    public function delete_article()
    {
        $id =  $_GET['id'];
        $this->article->delete_article($id);
    }

    public function home_articles(){
        $this->article->read_all_articles();
        $row = $this->article->getRow();
        include '../view/article/home_articles.php';
    }

    public function home_article(){
        $id =  $_GET['id'];
        $this->article->read_one_article($id);
        $row = $this->article->getRow();
        include '../view/article/Home_article.php';
    }

    public function home_update_article_admin()
    {
        $id = $_GET['id'];
        $this->article->read_one_article($id);
        $row = $this->article->getRow();
        include '../view/article/Hom_update_article.php';
    }

    public function update_article_admin()
    {
        if (isset($_POST['update_article'])) {

            $title = $this->article->escape_string($_POST['update_title']);
            $content = $this->article->escape_string($_POST['update_content']);
            $id = $this->article->escape_string($_POST['update_article_id']);
            $picture = $this->article->escape_string($_FILES['photo']['name']);


            if ($_FILES['photo']['error']) {
                switch ($_FILES['photo']['error']) {
                    case 1: // UPLOAD_ERR_INI_SIZE
                        echo "La taille du fichier est plus grande que la limite autorisée par le serveur (paramètre upload_max_filesize du fichier php.ini).";
                        break;
                    case 2: // UPLOAD_ERR_FORM_SIZE
                        echo "La taille du fichier est plus grande que la limite autorisée par le formulaire (paramètre post_max_size du fichier php.ini).";
                        break;
                    case 3: // UPLOAD_ERR_PARTIAL
                        echo "L'envoi du fichier a été interrompu pendant le transfert.";

                        break;
                    case 4: // UPLOAD_ERR_NO_FILE
                        echo "La taille du fichier que vous avez envoyé est nulle.";
                        break;
                }
            } else {
                if ((isset($_FILES['photo']['name']) && ($_FILES['photo']['error'] == UPLOAD_ERR_OK))) {
                    $path = '../public/view/img';
                    $picture = $_FILES['photo']['name'];

                    //déplacement du fichier du répertoire temporaire (stocké(
                    //par défaut) dans le répertoire de destination
                    move_uploaded_file($_FILES['photo']['tmp_name'], $path . $_FILES['photo']['name']);
                    echo "Le fichier " . $_FILES['photo']['name'] . " a été copié dans le répertoire photos";

                    $auth = $this->article->update_article_admin($title,$content,$picture,$id);
                    if ($auth) {
                        echo 'Update effectué';
                    }
                    else{
                        echo 'L update a été annulée';
                    }

                }

            }


        }
    }



}


