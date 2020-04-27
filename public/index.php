<?php
?>
<?php

$controller = $_REQUEST['controller'];
$action = $_REQUEST['action'];

switch ($controller) {
    case"user":

        require "../model/User.php";
        require "../controller/UserController.php";

        $ctrl = new UserController();

        switch ($action) {
            case"login":
                $ctrl->login();
                break;

            case"chklogin":
                $ctrl->check_login_user();
                break;

            case"Login_user":
                $ctrl->read_one_user();
                break;

            case "login_update";
                $ctrl->login_update();
                break;


            case"crtlogin":
                $ctrl->create_login();
                break;

            case"del_user":
                $ctrl->delete_user();
                break;

            case"up_user":
                $ctrl->update_user();
                break;
        }

        break;
}

?>