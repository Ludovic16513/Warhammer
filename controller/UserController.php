<?php
require_once '../model/User.php';

class UserController
{
    private $user;

    public function __construct()
    {
        $this->user = new User(new db);
    }


    public function delete_user()
    {
        $id =  $_GET['id'];
        $this->user->delete_user($id);
    }

    public function read_one_user()
    {
        session_start();
        if (!$_GET['id']){
            $session =  $_SESSION['user'];
            $this->user->read_one_user($session);
            $row = $this->user->getRow();
        }
    }

    public function login()
    {
        session_start();
        if (isset($_SESSION['user'])) {
            $session = $_SESSION['user'];
            $this->user->read_one_user($session);
            $row = $this->user->getRow();
            include '../view/Login_user.php';
        }
    else{
        $this->user->read_all_user();
        $row = $this->user->getRow();
        include '../view/View_Login.php';
    }

    }

    public function login_update()
    {
        session_start();
        $session =  $_SESSION['user'];
        $this->user->read_one_user($session);
        $row = $this->user->getRow();
        include '../view/Login_update.php';
    }


    public function check_login_user()
    {
        session_start();
        if (isset($_POST['login'])) {
            $username = $this->user->escape_string($_POST['username']);
            $password = $this->user->escape_string($_POST['password']);

            $auth = $this->user->check_login_user($username, $password);
            $row = $this->user->getRow();

            if (!$auth) {
                $_SESSION['message'] = 'Invalid username or password';
                include '../view/View_Login.php';
            } else {
                $_SESSION['user'] = $username;
                $row = $this->user->getRow();
                include '../view/Login_user.php';
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
                echo 'Inscription effectuée';
            }
            else{
                echo 'L inscription a été annulée';
            }
        }
    }

    public function update_user()
    {
        if (isset($_POST['update'])) {

            $name = $this->user->escape_string($_POST['update_name']);
            $email = $this->user->escape_string($_POST['update_email']);
            $pass = $this->user->escape_string($_POST['update_pass']);
            $id = $this->user->escape_string($_POST['id']);

            $auth = $this->user->update_user($name,$pass,$email,$id);

            if ($auth) {
                echo 'Update effectué';
            }
            else{
                echo 'L update a été annulée';
            }
        }
    }
}