<?php
require_once 'model/User.php';

/**
 * Class UserController
 */
class UserController
{

    private $user;

    /**
     * UserController constructor.
     */
    public function __construct()
    {
        $this->user = new User(new db);
    }

    /**
     *
     */
    public function user_disconnect(){

        // <---- DECONNECTION D'UN UTILISATEUR ---->

        // Lance la méthode puis redirection vers la page de login.
        $this->user->disconnect();
        $_SESSION['message'] = 'Vous avez été deconnecté';
        include 'view/login/login_user.php';
}

    public function delete_user()
    {
        // <----  REQUETE SUPPRESSION D'UN UTILISATEUR ---->

        // Lance la méthode puis redirection vers la page de login.
        $id =  $_GET['id'];
        $this->user->escape_string($id);

        $this->user->delete_user($id);
        $_SESSION['message'] = 'Utilisateur supprimé';
        $this->home_admin();
    }

    public function home_user()
    {
        // <---- PAGE MEMBRE ---->


        if ($_SESSION['user']){ // Verif de la connexion d'un utilisateur
            $session =  $_SESSION['user'];
            $this->user->escape_string($session);

            // Lance l'affichage d'un utilisateur puis redirection vers la page de l'utilisateur.
            $this->user->read_one_login_user($session);
            $row = $this->user->getRow();
            include 'view/login/Home_user.php';
        }
        else{ // Redirection si echec de connexion
            $_SESSION['message'] = 'Veuillez vous connecter';
            include 'view/login/login_user.php';
        }
    }

    /**
     *
     */
    public function home_admin()
    {
        // <---- PAGE ADMIN  / GESTION MEMBRE---->

        if (isset($_SESSION['admin'])) { // Verif de la connexion d'un Admin

            // Lance l'affichage des utilisateurs et redirige vers la page de gestion des membres.
            $this->user->read_all_user();
            $row = $this->user->getRow();
            include 'view/login/Home_admin.php';
        }

        else { // Redirection si echec de connexion
            $_SESSION['message'] = 'Veuillez vous connecter';
            include 'view/login/login_admin.php';
        }
    }

    /**
     *
     */
    public function login_user()
    {
        // <---- PAGE LOGIN UTILISATEUR ---->


        if (isset($_SESSION['user'])) { // verif si utilisateur connecté
            $_SESSION['user'];
            // Lance l'affichage des utilisateurs puis redirection vers l'espace membre.
            $session =  $_SESSION['user']; // Valeur de l'utilisateur, ex: "Louis".
            $this->user->escape_string($session);
            $this->user->read_one_login_user($session);
            $row = $this->user->getRow();
            include 'view/login/Home_user.php';

        } else { // Redirection si echec de connexion
            include 'view/login/login_user.php';
        }
    }

    /**
     *
     */
    public function admin_create_user()
    {
        // <---- PAGE CREATION D'UN UTILISATEUR ---->

        if (isset($_SESSION['admin'])) {  // verif si admin connecté

            // Redirection vers la page de creation d'un utilisateur.
            include 'view/login/Home_admin_create_user.php';
        }
        else{ // Redirection si echec de connexion
            $_SESSION['message'] = 'Veuillez vous connecter';
            include 'view/login/Login_admin.php';
        }
    }

    /**
     *
     */
    public function login_admin()
    {
         // <---- PAGE LOGIN admin ---->

        if (isset($_SESSION['admin'])) { // verif si admin connecté

            // redirection vers la page d'acceuil admin / gestion membre.
            $_SESSION['admin'];
            $this->user->read_all_user();
            $row = $this->user->getRow();
            include 'view/login/Home_admin.php';
        } else { // Redirection si echec de connexion
            $_SESSION['message'] = 'Veuillez vous connecter';
            include 'view/login/Login_admin.php';
        }
    }

    /**
     *
     */
    public function check_login_user()
    {
        // <---- REQUETE DE LOGIN UTILISATEUR ---->

        if (isset($_POST['login_user'])) { // verif input utilisateur
            $username = $_POST['username'];
            $this->user->escape_string($username);
            $password = $_POST['password'];
            $this->user->escape_string($password);


            // Lance la verification de connexion en base de donnée
            $auth = $this->user->check_login_user($username, $password);
            $row = $this->user->getRow();

            if (!$auth) { // Connexion refusé -> redirection login
                $_SESSION['message'] = 'UTILISATEUR ou PASSWORD incorrect';
                include 'view/login/login_user.php';
            } else { // Redirection vers l'espace membre

                // Valeur de l'utilisateur mise en session, ex: "Louis".
                $_SESSION['user'] = $username;

                // Redirection vers la page membre.
                $this->login_user();
            }
        }
    }

    /**
     *
     */
    public function check_login_admin()
    {

        // <---- REQUETE DE LOGIN ADMIN ---->

        if (isset($_POST['login_admin'])) { // Verif de l'input Admin

            $username = $_POST['username_admin'];
            $this->user->escape_string($_POST['username_admin']);
            $password = $_POST['password_admin'];
            $this->user->escape_string($_POST['username_admin']);

            // Lance la verification de connexion en base de donnée
            $auth = $this->user->check_login_admin($username, $password);

            if (!$auth) { // Connexion refusé -> redirection login
                $_SESSION['message'] = 'UTILISATEUR ou PASSWORD incorrect';
                include 'view/login/login_user.php';
            }
            else { // Connexion autorisé -> redirection espace admin
                $this->user->read_all_user();
                $row = $this->user->getRow();

                $_SESSION['admin'] = $username;
                include 'view/login/Home_admin.php';
            }
        }

        else { // Redirection si echec de connexion
            $_SESSION['message'] = 'Veuillez vous connecter';
            include 'view/login/login_admin.php';
        }
    }

    /**
     *
     */
    public function home_update_user()
    {
        // <---- PAGE DE MISE A JOUR UTILISATEUR ---->

        if (isset($_SESSION['admin'])) {  // Connexion admin en cours -> redirection page update

            // valeur id de l'utilisateur ex: 2
            $id = $_GET['id'];
            $this->user->escape_string($_GET['id']);
            $this->user->read_one_user($id);
            $row = $this->user->getRow();
            include 'view/login/Home_update_user.php';
        }
        else {
            $_SESSION['message'] = 'Veuillez vous connecter';
            include 'view/login/login_admin.php';
        }
    }

    /**
     *
     */
    public function create_user()
    {

        // <---- REQUETE DE CREATION D 'UN UTILISATEUR ---->

        if (isset($_POST['create'])) { // Récuperation des input -> requête de creation

            $username = $_POST['POST_CreateUser'];
            $pass = $_POST['POST_CreatePassword'];
            $email = $_POST['POST_CreateEmail'];

            $this->user->escape_string($username);
            $this->user->escape_string($pass);
            $this->user->escape_string($email);

            $this->user->create_login($username, $pass, $email);

            $_SESSION['message'] = 'Utilisateur ajouté';
            include 'view/login/login_user.php';
        }

        else{
            $_SESSION['message'] = 'Requête refusé';
            include 'view/login/login_user.php';
        }
    }

    public function update_user()
    {
        // <---- REQUETE DE MISE A JOUR D 'UN UTILISATEUR ---->

        if (isset($_POST['update_user'])) { // Récuperation des input -> requête update

            $name = $_POST['update_name'];
            $email = $_POST['update_email'];
            $pass = $_POST['update_pass'];
            $id = $_POST['id'];

            $this->user->escape_string($name);
            $this->user->escape_string($email);
            $this->user->escape_string($email);
            $this->user->escape_string($id);

            $this->user->update_user($name,$pass,$email,$id);

            $_SESSION['message'] = 'Mise à jour effectuée';
            $this->home_admin();

        }
    }

}