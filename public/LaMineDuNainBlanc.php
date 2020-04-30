<?php
?>
<?php
//On transmet dans des variables les paramètres action et controller de l'url.
$controller = $_REQUEST['controller'];
$action = $_REQUEST['action'];

// on inclu le header connecté ou non connecté, si l'utilisateur est connecté ou non.

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

        require "../model/User.php";
        require "../controller/UserController.php";

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

            case "home_update_user";
                $ctrl->home_update_user();
                break;

            case"crt_user":
                $ctrl->create_user();
                break;

            case"del_user":
                $ctrl->delete_user();
                break;

            case"up_user":
                $ctrl->update_user();
                break;

            case"home_user":
                $ctrl->home_user();
                break;

            case"home_admin":
                $ctrl->home_admin();
                break;

            case"home_admin_member":
                $ctrl->home_member_admin();
                break;
        }

        break;
}


switch ($controller) {
    case"article":

        require "../model/User.php";
        require "../model/article.php";
        require "../controller/ArticleController.php";

        $ctrl = new ArticleController();

        switch ($action) {
            case"create_article":
                $ctrl->home_create_article();
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


        break;
}

include 'footer.php'
?>