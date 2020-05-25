<?php
//On transmet dans des variables les paramètres action et controller de l'url.
$controller = $_REQUEST['controller'];
$action = $_REQUEST['action'];

// on inclu le header connecté ou non connecté, si l'utilisateur est connecté ou non.
session_start();

if (!isset($_SESSION['user']))
{
    include "header_disconnected.php";
}
else {
    include "header_connected.php";
}


//un switch qui appellera le bon controller en fonction des parametres.
switch ($controller) {

    case"user":

        require "controller/UserController.php";

        $ctrl = new UserController();

        switch ($action) {

            // <------ ADMIN CASE  ------->

            case"admin_login"; // lance la page de login a l'espace admin
                $ctrl->login_admin();
                break;

            case"admin_chklogin": // lance la requete de connexion a l'espace admin
                $ctrl->check_login_admin();
                break;

            case"home_admin": // lance la page gestion membre de l'espace admin
                $ctrl->home_admin();
                break;

            case "update_user"; // lance la page de mise a jour utilisateur
                $ctrl->home_update_user();
                break;

            case"request_update_user": // lance la requete de mise a jour utilisateur
                $ctrl->update_user();
                break;

            case"admin_create_user": // lance la page de creation d'un utilisateur coté admin
                $ctrl->admin_create_user();
                break;

            case"request_create_user": // lance une requete de creation d'un utilisateur coté admin
                $ctrl->create_user_admin();
                break;

            case"del_user": // lance une requete de suppression d'un utilisateur coté admin
                $ctrl->delete_user();
                break;

            // <------ USER CASE  ------->

            case"user_login":
                $ctrl->login_user();
                break;

            case"user_chklogin":
                $ctrl->check_login_user();
                break;

            case"crt_user":
                $ctrl->create_user();
                break;

            case"home_user":
                $ctrl->home_user();
                break;

            case"user_disconnect":
                $ctrl->user_disconnect();
                break;

            case"user_mail-valid":
                $ctrl->user_mail_valid();
                break;

            case"contact_page":
                $ctrl->contact_page();
                break;

            case"send_mail":
                $ctrl->send_mail();
                break;

        }

        break;
}


switch ($controller) {
    case"article":

        require "controller/ArticleController.php";

        $ctrl = new ArticleController();

        switch ($action) {

            case"admin_article":
                $ctrl->admin_articles();
                break;

            case"admin_create_article":
                $ctrl->admin_create_article();
                break;

            case"request_create_article":
                $ctrl->create_article();
                break;


            case"request_delete_article":
                $ctrl->delete_article();
                break;

            case"home_articles":
                $ctrl->home_articles();
                break;

            case"home_article":
                $ctrl->home_article();
                break;

            case"upgrade_article":
                $ctrl->home_update_article_admin();
                break;

            case"request_upgrade_article":
                $ctrl->update_article_admin();
                break;

        }
        break;
}

switch ($controller) {

    case"sheet":

        require "controller/SheetController.php";

        $ctrl = new SheetController();


        switch ($action) {
            case"select_sheets":
                $ctrl->select_sheets();
                break;

            case"add_sheet":
                $ctrl->create_sheet();
                break;

            case"delete_sheet":
                $ctrl->delete_sheet();
                break;

        }
        break;
}
include 'footer.php';

