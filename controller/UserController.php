<?php
require_once '../model/User.php';

class UserController
{
    private $user;

    public function __construct()
    {
        $this->user = new User(new db);
    }


    public function login()
    {
        $this->user->read_user();
        $row = $this->user->getRow();
        include '../view/View_Login.php';
    }

    public function check_login()
    {
        session_start();
        if (isset($_POST['login'])) {
            $username = $this->user->escape_string($_POST['username']);
            $password = $this->user->escape_string($_POST['password']);

            $auth = $this->user->check_login($username, $password);
            $row = $this->user->getRow();

            if (!$auth) {
                $_SESSION['message'] = 'Invalid username or password';
                include '../view/View_Login.php';
            } else {
                $_SESSION['user'] = $auth;
                $row = $this->user->getRow();
                include '../view/LoginOk.php';
            }
        } else {
            $_SESSION['message'] = 'You need to login first';
            include '../view/View_Login.php';
        }
    }


    public function create_login()
    {
        if (isset($_POST['create'])) {

            $username = $this->user->escape_string($_POST['POST_CreateUser']);
            $pass = $this->user->escape_string($_POST['POST_CreatePassword']);
            $email = $this->user->escape_string($_POST['POST_CreateEmail']);

            $auth = $this->user->create_login($username, $pass, $email);

            if ($auth) {
                $_SESSION['message'] = 'Inscription effectuée';
            }
            else{
                $_SESSION['message'] = 'L inscription a été annulée';
            }
        }
    }
}