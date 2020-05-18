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

    /**
     * Controller pour l'appel d'une creation d'article
     */
    public function create_article()
    {
        // <---- REQUETE CREATION DES ARTICLES---->
            /* Valeur de l'input Titre
             * ex : Première forge
             * */
            $title = $this->article->escape_string($_POST['create_title']);

            /* Valeur de l'input pour le contenu d'article
             * ex : Saepissime igitur mihi de amicitia cogitanti........
             * */
            $content = $this->article->escape_string($_POST['create_content']);

            /* Valeur de l'input pour l'auteur
             * ex : Louis
             * */
            $author = $this->article->escape_string($_POST['create_author']);

            // < --- GESTION DES ERREURS DE L UPLOAD PHOTO-->
            if ($_FILES['photo']['error']) {

                switch ($_FILES['photo']['error']) {

                    case 1:
                        $_SESSION['message'] = "La taille du fichier est plus grande que la limite autorisée par le serveur (paramètre upload_max_filesize du fichier php.ini).";
                        include 'view/article/Home_create_admin.php';
                        break;

                    case 2:
                        $_SESSION['message'] ="La taille du fichier est plus grande que la limite autorisée par le formulaire (paramètre post_max_size du fichier php.ini).";
                        include 'view/article/Home_create_admin.php';
                        break;

                    case 3:
                        $_SESSION['message'] = "L'envoi du fichier a été interrompu pendant le transfert.";
                        include 'view/article/Home_create_admin.php';
                        break;
                    case 4:
                        $_SESSION['message'] = "La taille du fichier que vous avez envoyé est nulle.";
                        include 'view/article/home_article_admin.php';
                        break;
                }
            }

            // < --- EXECUTION DE  L UPLOAD -->
            else {
                if ((isset($_FILES['photo']['name']) && ($_FILES['photo']['error'] == UPLOAD_ERR_OK))) {
                    $path = 'img/';
                    $picture =$this->article->escape_string($_FILES['photo']['name']);

                    /* < --- DEPLACEMENT DU FICHIER -->
                     * Déplacement du fichier du répertoire temporaire,
                     * puis stocké dans le répertoire de destination.
                    */
                    move_uploaded_file($_FILES['photo']['tmp_name'], $path . $_FILES['photo']['name']);

                    /* < --- LANCEMENT REQUETE -->
                    *  Appel  de la méthode pour creer un article
                     * puis redirection vers la page de création d'article avec message
                    */
                    $this->article->create_article_admin($title, $content, $picture, $author);
                    $_SESSION['message'] = "Votre article a été créé avec succès";
                    $this->admin_articles();

                }
            }

    }

    /**
     * Acces à la page de creation d'article
     */
    public function admin_create_article()
    {
        // <---- CREATION DES ARTICLES---->

        // Verif si admin et redirection vers la bonne page.
        if (isset($_SESSION['admin'])) {
            include 'view/article/Home_create_admin.php';
        } else {
            $_SESSION['message'] = "Veuillez vous connecter";
            include 'view/login/login_admin.php';
        }
    }

    /**
     * Appel d'une suppression d'article
     */
    public function delete_article()
    {
        // <---- SUPPRESSION DES ARTICLES---->

        /* Valeur du paramêtre url id = (ex 2) de l'article,
           et supprime l'article de la valeur (id)
        */
        $id = $this->article->escape_string($_GET['id']);
        $this->article->delete_article($id);

        /* Affichage de tous les articles
           puis redirection vers la bonne page.
         * */
        $_SESSION['message'] = "Votre article a été supprimé avec succès";
        $this->admin_articles();
    }

    /**
     *  Suppression d'article
     */
    public function home_articles()
    {
        // <---- ESPACE ACCEUIL UTILISATEURS---->

        /* Affichage de tous les articles puis redirection vers l'acceuil. */
        $this->article->read_all_articles();
        $row = $this->article->getRow();
        include 'view/article/home_articles.php';
    }


    /**
     *
     */
    public function admin_articles()
    {
        // <---- PAGE GESTION DES ARTICLES ADMIN ---->

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

    /**
     * Affichage d'un seul article
     */
    public function home_article(){

        // <---- PAGE D'UN ARTICLE ---->

        // Valeur du paramêtre url id = (ex 2) de l'article et affiche l'article de la valeur (id).
        $id = $this->article->escape_string($_GET['id']);
        $this->article->read_one_article($id);
        $row = $this->article->getRow();
        include 'view/article/home_article.php';
    }

    /**
     * Affichage d'une mise à jour d'article
     */
    public function home_update_article_admin()
    {
        // <---- PAGE MISE A JOUR D'ARTICLE ---->

        // Valeur du paramêtre url [id] = (ex: 2) de l'article et affiche l'article de la valeur [id].

        if (isset($_SESSION['admin'])) {
            $id = $this->article->escape_string($_GET['id']);
            $this->article->read_one_article($id);
            $row = $this->article->getRow();
            include 'view/article/Hom_update_article.php';
        }

        else{
            include 'view/login/login_admin.php';
        }

    }

    /**
     * Appel d'une mise à jour d'article
     */
    public function update_article_admin()
    {

        // <---- REQUETE MISE A JOUR D'UN ARTICLE ---->

        if (isset($_POST['update_article'])) {

            /* Valeur de l'input Titre
              * ex : Première forge
             */
            $title = $this->article->escape_string($_POST['update_title']);

            /* Valeur de l'input pour le contenu d'article
             * ex : Saepissime igitur mihi de amicitia cogitanti........
             * */
            $content = $this->article->escape_string($_POST['update_content']);

            /* Valeur de l'input pour l'id de l'article
            * ex : 2.
            */
            $id = $this->article->escape_string($_POST['update_article_id']);

            // < --- GESTION DES ERREURS DE L UPLOAD-->
            if ($_FILES['photo_update']['error']) {

                switch ($_FILES['photo_update']['error']) {
                    case 1:
                        $_SESSION['message'] = "La taille du fichier est plus grande que la limite autorisée par le serveur (paramètre upload_max_filesize du fichier php.ini).";
                        include 'view/article/home_article_admin.php';
                        break;

                    case 2:
                        $_SESSION['message'] ="La taille du fichier est plus grande que la limite autorisée par le formulaire (paramètre post_max_size du fichier php.ini).";
                        include 'view/article/home_article_admin.php';
                        break;
                    case 3:
                        $_SESSION['message'] = "L'envoi du fichier a été interrompu pendant le transfert.";
                        include 'view/article/home_article_admin.php';
                        break;
                    case 4:
                        $_SESSION['message'] = "La taille du fichier que vous avez envoyé est nulle.";
                        include 'view/article/home_article_admin.php';
                        break;
                }
            }
            // < --- EXECUTION DE  L UPLOAD -->
            else {
                if ((isset($_FILES['photo_update']['name']) && ($_FILES['photo_update']['error'] == UPLOAD_ERR_OK))) {
                    $path = 'img/';
                    $picture = $_FILES['photo_update']['name'];

                    /* < --- DEPLACEMENT DU FICHIER -->

                     * Déplacement du fichier du répertoire temporaire,
                     * puis stocké dans le répertoire de destination.
                     */
                    move_uploaded_file($_FILES['photo_update']['tmp_name'], $path . $_FILES['photo_update']['name']);
                    /* < --- LANCEMENT REQUETE -->
                     *  Appel  de la méthode pour creer un article
                     * puis redirection vers la page de création d'article avec un gentil message :)
                    */
                    $this->article->update_article_admin($title,$content,$picture,$id);

                    $_SESSION['message'] = "Votre article a été mis à jour avec succès";
                    $this->admin_articles();
                }

            }
        }
    }
}


