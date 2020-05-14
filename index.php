<?php
?>
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


//un switch qui appellera le bon controller en fonction des variables.
switch ($controller) {
    case"user":

        require "controller/UserController.php";

        $ctrl = new UserController();

        switch ($action) {
            case"user_login":
                $ctrl->login_user();
                break;

            case"admin_login":
                $ctrl->login_admin();
                break;

            case"user_chklogin":
                $ctrl->check_login_user();
                break;

            case"admin_chklogin":
                $ctrl->check_login_admin();
                break;

            case "update_user";
                $ctrl->home_update_user();
                break;

            case"request_update_user":
                $ctrl->update_user();
                break;

            case"crt_user":
                $ctrl->create_user();
                break;

            case"admin_create_user":
                $ctrl->admin_create_user();
                break;


            case"del_user":
                $ctrl->delete_user();
                break;


            case"home_user":
                $ctrl->home_user();
                break;

            case"home_admin":
                $ctrl->home_admin();
                break;


            case"user_disconnect":
                $ctrl->user_disconnect();
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
        }


        switch ($action) {
            case"admin_create_article":
                $ctrl->admin_create_article();
                break;
        }

        switch ($action) {
            case"request_create_article":
                $ctrl->create_article();
                break;
        }


        switch ($action) {
            case"request_create_article":
                $ctrl->create_article();
                break;
        }

        switch ($action) {
            case"request_delete_article":
                $ctrl->delete_article();
                break;
        }

        switch ($action) {
            case"home_articles":
                $ctrl->home_articles();
                break;
        }

        switch ($action) {
            case"home_article":
                $ctrl->home_article();
                break;
        }

        switch ($action) {
            case"upgrade_article":
                $ctrl->home_update_article_admin();
                break;
        }

        switch ($action) {
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
        }


        switch ($action) {
            case"add_sheet":
                $ctrl->create_sheet();
                break;
        }
        switch ($action) {
            case"delete_sheet":
                $ctrl->delete_sheet();
                break;
        }

        break;
}

include 'footer.php'
?>