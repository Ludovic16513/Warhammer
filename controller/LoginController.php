<?php

class LoginController
{
    private $model;

    public function __construct()
    {
        $this->model = new Login(new db);
    }

    public function CheckLogin()
    {
       $this->model->checkLogin();
    }

    public function CreateLogin()
    {
        $this->model->setCreateUser();
        $this->model->setCreatePassword();
        $this->model->setCreateEmail();
        $this->model->insert_User();
    }

    public function Login()
    {

    }


}