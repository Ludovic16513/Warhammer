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

    // <---- PAGE LOGIN MEMBRE ---->

    public function login_user()
    {
        if (isset($_SESSION['user'])) { // verif si utilisateur connecté
            header("Location: index.php?controller=sheet&action=select_sheets");
        } else { // Redirection si non connecté
            include 'view/login/login_user.php';
        }
    }

    // <---- CONNEXION A L'ESPACE MEMBRE ---->

    public function check_login_user()
    {
        if (isset($_POST['login_user'])) { // verif input utilisateur

            $username = $_POST['username'];
            $escape_username = $this->user->escape_string($username);
            $this->user->set_username($escape_username);


            $password = $_POST['password'];
            $escape_password = $this->user->escape_string($password);
            $this->user->set_password($escape_password);



            // Lance la vérification de connexion en base de donnée
            $auth = $this->user->check_login_user();

            if ($auth) { // Connexion refusé -> redirection login
                $_SESSION['user'] = $username; // Valeur de l'utilisateur mise en session, ex: "Louis".
                // Redirection vers la page membre.
                $this->login_user();
            } else
                { // Redirection vers l'espace membre
                $_SESSION['message'] = 'UTILISATEUR ou PASSWORD incorrect';
                include 'view/login/login_user.php';
            }
        }
    }

    // <---- PAGE ESPACE MEMBRE ---->

    public function home_user()
    {
        if ($_SESSION['user']) { // Verif de la connexion d'un utilisateur
            header('Location: index.php?controller=sheet&action=select_sheets');
        }
        else { // Redirection si echec de connexion
            $_SESSION['message'] = 'Veuillez vous connecter';
            include 'view/login/login_user.php';
        }
    }


    // <---- PAGE LOGIN ADMIN ---->

    public function login_admin()
    {
        if (isset($_SESSION['admin'])) { // verif si admin connecté

            $this->user->read_all_user();
            $row = $this->user->getRow();
            include 'view/login/Home_admin.php';

        } else { // Redirection si echec de connexion
            $_SESSION['message'] = 'Veuillez vous connecter';
            include 'view/login/Login_admin.php';
        }
    }

    // <---- CONNEXION A L'ESPACE ADMIN ---->

    public function check_login_admin()
    {
        $username = $_POST['username_admin'];
        $escape_username = $this->user->escape_string($username);
        $this->user->set_username($escape_username);

        $password = $_POST['password_admin'];
        $escape_password = $this->user->escape_string($password);
        $this->user->set_password($escape_password);

        // Lance la verification de connexion en base de données
        $auth = $this->user->check_login_admin();

        if ($auth) { // Connexion refusé -> redirection login
            $_SESSION['user'] = 'Admin59';

            $this->user->read_all_user();
            $row = $this->user->getRow();

            $_SESSION['admin'] = $username;
            header("Location: index.php?controller=user&action=home_admin");
        }
        $_SESSION['message'] = 'UTILISATEUR ou PASSWORD incorrect';
        include 'view/login/login_admin.php';
    }


    // <---- PAGE GESTION MEMBRE---->

    public function home_admin()
    {
        if (isset($_SESSION['admin'])) { // Verif de la connexion d'un Admin

            // Lance l'affichage des utilisateurs et redirige vers la page de gestion des membres.
            if ($this->user->read_all_user())
            {
                $row = $this->user->getRow();
                include 'view/login/Home_admin.php';
            }
        }
        else { // Redirection si echec de connexion
            $_SESSION['message'] = 'Veuillez vous connecter';
            include 'view/login/login_admin.php';
        }
    }

    /* <---- PAGE CREATION D'UN UTILISATEUR ----> */

    public function admin_create_user()
    {
        if (isset($_SESSION['admin'])) {  // verif si admin connecté
            // Redirection vers la page de creation d'un utilisateur.
            include 'view/login/Home_admin_create_user.php';
        } else { // Redirection si echec de connexion
            $_SESSION['message'] = 'Veuillez vous connecter';
            include 'view/login/Login_admin.php';
        }
    }

    // <---- DEMANDE DE  CREATION D 'UN UTILISATEUR ---->

    public function create_user()
    {
        if ($_POST['POST_CreatePassword'] === $_POST['POST_ConfirmPassword']) {

            if (isset($_POST['create'])) { // Récuperation des input -> requête de creation

                $captcha = $_POST['g-recaptcha-response'];

                $username = $_POST['POST_CreateUser'];
                $escape_username = $this->user->escape_string($username);
                $this->user->set_username($escape_username);

                $password = $_POST['POST_CreatePassword'];
                $escape_password = $this->user->escape_string($password);
                $this->user->set_password($escape_password);

                $email = $_POST['POST_CreateEmail'];
                $escape_email = $this->user->escape_string($email);
                $this->user->set_email($escape_email);

                if ($this->user->verify_captcha($captcha)) {
                    $this->user->create_login();
                    $_SESSION['message'] = 'Inscription validé';
                    include 'view/login/login_user.php';
                }
                else {
                    $_SESSION['message'] = 'Captcha non vérifié ';
                    include 'view/login/login_user.php';
                }
            }
        }
        else {
            $_SESSION['message'] = 'Le mot de passe ne correspond pas';
            include 'view/login/login_user.php';
        }

    }

    // <---- PAGE DE MISE A JOUR UTILISATEUR ---->

    public function home_update_user()
    {
        if (isset($_SESSION['admin'])) {  // Connexion admin en cours -> redirection page update


            $id = $_GET['id']; // Valeur id de l'utilisateur ex: 2
            $escape_id = $this->user->escape_string($id);
            $this->user->set_id($escape_id);

            $this->user->read_one_user();
            $row = $this->user->getRow();
            include 'view/login/Home_update_user.php';
        } else {
            $_SESSION['message'] = 'Veuillez vous connecter';
            include 'view/login/login_admin.php';
        }
    }

    // <---- DEMANDE DE MISE A JOUR D'UN UTILISATEUR ---->

    public function update_user()
    {
        if (isset($_POST['update_user'])) { // Récuperation des input -> requête update

            $username = $_POST['update_name'];
            $email = $_POST['update_email'];
            $password = $_POST['update_pass'];
            $id = $_POST['id'];

           $escape_username = $this->user->escape_string($username);
           $escape_password = $this->user->escape_string($password);
           $escape_email = $this->user->escape_string($email);
           $escape_id = $this->user->escape_string($id);

           $this->user->set_username($escape_username);
           $this->user->set_password($escape_password);
           $this->user->set_email($escape_email);
           $this->user->set_id($escape_id);

           $update = $this->user->update_user();

            if (!$update) { // update erreur -> redirection
                $_SESSION['message'] = 'Erreur dans la mise à jour';
                $this->home_admin();
            } else {
                $_SESSION['message'] = 'Mise à jour effectuée';
                $this->home_admin();
            }
        }

    }

    // <---- SUPPRESSION D'UN UTILISATEUR ---->

    public function delete_user()
    {
         $id_delete = $_GET['id'];
         $escape_id = $this->user->escape_string($id_delete);
         $this->user->set_id($escape_id);

        if ($this->user->delete_user()) // Lance la méthode puis redirection vers la page de login.
        {
            header('Location: index.php?controller=user&action=home_admin');
            $_SESSION['message'] = 'Utilisateur supprimé';
        }
        else{
            header('Location: index.php?controller=user&action=home_admin');
            $_SESSION['message'] = 'Utilisateur non supprimé';
        }
    }

    // <---- DECONNEXION D'UN UTILISATEUR ---->

    public function user_disconnect()
    {
        // Lance la méthode puis redirection vers la page de login.
        $this->user->disconnect();
        $_SESSION['message'] = 'Vous avez été deconnecté';
        header("Location: index.php?controller=user&action=user_login");
    }

    // <---- PAGE DE VALIDATION MAIL ---->

    public function user_mail_valid()
    {
        $username = $_GET['username'];
        $escape_username = $this->user->escape_string($username);
        $this->user->set_username($escape_username);

        $key = $_GET['key'];
        $this->user->escape_string($key);

        if ($this->user->model_mail_validation($key))
        {
            echo "Votre compte a bien été activé !";
        }
        else{
            echo "Votre compte est déjà actif ou l'activation a échouée .";
        }
    }
}