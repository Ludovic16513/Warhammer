<?php
require "model/article.php";

/**
 * Class ArticleController
 */
class ArticleController
{
    private $article;

    /**
     * ArticleController constructor.
     */
    public function __construct()
    {
        $this->article = new article(new db); // Instanciation + injection par dépendance de la bd.
    }

    // <---- PAGE D'ACCEUIL ---->

    public function home_articles()
    {
        /* Affichage de tous les articles puis redirection vers l'acceuil. */
        $this->article->read_all_articles();
        $row = $this->article->getRow();
        include 'view/article/home_articles.php';
    }


    // <---- PAGE D'UN ARTICLE ---->

    public function home_article()
    {
        $id = $_GET['id'];
        $escape_id = $this->article->escape_string($id);  // Valeur du paramêtre url id = (ex 2) de l'article et affiche l'article de la valeur (id).
        $this->article->set_id_article($escape_id);
        $this->article->read_one_article();
        $row = $this->article->getRow();
        include 'view/article/home_article.php';
    }

    // <---- PAGE GESTION DES ARTICLES ---->

    public function admin_articles()
    {
        if (isset($_SESSION['admin'])) {
            // Affichage de tous les articles puis redirection vers la page de gestion.
            $this->article->read_all_articles();
            $row = $this->article->getRow();
            include 'view/article/home_article_admin.php';
        } else {
            $_SESSION['message'] = 'Veuillez vous connecter';
            include 'view/login/login_admin.php';
        }
    }

    // <---- PAGE DE CREATION D UN ARTICLE---->

    public function admin_create_article()
    {
        // Verif si admin et redirection vers la bonne page.
        if (isset($_SESSION['admin'])) {
            include 'view/article/Home_create_admin.php';
        } else {
            $_SESSION['message'] = "Veuillez vous connecter";
            include 'view/login/login_admin.php';
        }
    }

    // <---- DEMANDE DE CREATION D UN ARTICLE---->

    public function create_article()
    {
        $picture = $_FILES['photo']['name'];
        $escape_picture = $this->article->escape_string($picture);
        $this->article->set_picture($escape_picture);

        $title = $_POST['create_title'];
        $this->article->set_title($title);

        $content = $_POST['create_content'];
        $this->article->set_content($content);

        $author = $_POST['create_author'];
        $this->article->set_author($author);

        if ($this->article->upload_picture()){

            if ($this->article->create_article_admin()){
                $_SESSION['message'] = "Votre article a été créé avec succès";
                $this->admin_articles();
            }
        }
        else{
            $_SESSION['message'] = "Erreur lors de la création de votre article";
            $this->admin_articles();
        }
    }

    // <---- PAGE MISE A JOUR D'ARTICLE ---->

    public function home_update_article_admin()
    {
        // Valeur du paramêtre url [id] = (ex: 2) de l'article et affiche l'article de la valeur [id].

        if (isset($_SESSION['admin'])) {

            $id_article = $_GET['id'];
            $escape_id_article = $this->article->escape_string($id_article);
            $this->article->set_id_article($escape_id_article);

            $this->article->read_one_article();
            $row = $this->article->getRow();
            include 'view/article/Hom_update_article.php';
        } else {
            include 'view/login/login_admin.php';
        }

    }

    // <---- REQUETE MISE A JOUR D'UN ARTICLE ---->

    public function update_article_admin()
    {
        if (isset($_POST['update_article'])) {

            $picture = $_FILES['photo']['name'];
            $id_article = $_POST['update_article_id'];
            $content = $_POST['update_content'];
            $title = $_POST['update_title'];

            $escape_picture = $this->article->escape_string($picture);
            $escape_article_id = $this->article->escape_string($id_article);


            $this->article->set_picture($escape_picture);
            $this->article->set_id_article($escape_article_id);
            $this->article->set_content($content);
            $this->article->set_title($title);

            if ($this->article->upload_picture()) {
                $this->article->update_article_admin();
                $_SESSION['message'] = "Votre article a été mis à jour avec succès";
                $this->admin_articles();
            }
            else {
                $_SESSION['message'] = "Erreur lors de la mise à jour de votre article";
                $this->admin_articles();
            }
        }
    }
    // <---- SUPPRESSION D UN ARTICLE ---->

    public function delete_article()
    {
        // <---- SUPPRESSION DES ARTICLES---->

        $id = $_GET['id'];
        $escape_id =  $this->article->escape_string($id);
        $this->article->set_id_article($escape_id);

        if ($this->article->delete_article()){ // supprime l'article de la valeur (id)
            $_SESSION['message'] = "Votre article a été supprimé avec succès";
            $this->admin_articles();
        }
    }
}


