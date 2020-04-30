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

    public function home_user()
    {
        session_start();
        if (!$_GET['id']){
            $session =  $_SESSION['user'];
            $this->user->read_one_user($session);
            $row = $this->user->getRow();
        }
    }

    public function home_admin()
    {
        session_start();
        if (!$_GET['id']){
            $session =  $_SESSION['admin'];
            $this->user->read_one_admin($session);
            $row = $this->user->getRow();
        }
    }


    public function login_user()
    {
        session_start();
        if (isset($_SESSION['user'])) {
            $this->user->read_one_user($session);

            $row = $this->user->getRow();
            include '../view/login/Home_user.php';

        } else {
            include '../view/login/login_user.php';
        }
    }

    public function login_admin()
    {
        session_start();
        if (isset($_SESSION['admin'])) {
            $session = $_SESSION['admin'];
            $this->user->read_one_admin($session);
            $row = $this->user->getRow();
            include '../view/login/Home_admin.php';
        } else {
            include '../view/login/Login_admin.php';
        }
    }

    public function check_login_user()
    {
        session_start();
        if (isset($_POST['login_user'])) {
            $username = $this->user->escape_string($_POST['username']);
            $password = $this->user->escape_string($_POST['password']);

            $auth = $this->user->check_login_user($username, $password);
            $row = $this->user->getRow();

            if (!$auth) {
                $_SESSION['message'] = 'Invalid username or password';
                include '../view/login/login_user.php';
            } else {
                $_SESSION['user'] = $username;
                $row = $this->user->getRow();
                include '../view/login/Home_user.php';
            }
        } else {
            $_SESSION['message'] = 'You need to login first';
            include '../view/login/login_user.php';
        }
    }

    public function check_login_admin()
    {
        session_start();
        if (isset($_POST['login_admin'])) {
            $username = $this->user->escape_string($_POST['username']);
            $password = $this->user->escape_string($_POST['password']);

            $auth = $this->user->check_login_admin($username, $password);
            $row = $this->user->getRow();

            if (!$auth) {
                $_SESSION['message'] = 'Invalid username or password';
                include '../view/login/login_user.php';
            } else {
                $_SESSION['admin'] = $username;
                $row = $this->user->getRow();
                include '../view/login/Home_user.php';
            }
        } else {
            $_SESSION['message'] = 'You need to login first';
            include '../view/login/login_user.php';
        }
    }

    public function create_user()
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

    public function home_update_user()
    {
        session_start();
        $session =  $_SESSION['user'];
        $this->user->read_one_user($session);
        $row = $this->user->getRow();
        include '../view/login/Home_update_user.php';
    }

    public function home_member_admin()
    {
        session_start();
        if (isset($_SESSION['admin']))
        {
            $this->user->read_all_user();
            $row = $this->user->getRow();
            include '../view/login/Home_member_admin.php';
        }
        else{
            $_SESSION['message'] = 'You need to login first';
            include '../view/login/Login_admin.php';
        }
    }

    public function update_user()
    {
        if (isset($_POST['update_user'])) {

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