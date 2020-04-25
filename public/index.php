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
                $ctrl->check_login();
                break;

            case"crtlogin":
                $ctrl->create_login();
                break;
        }

        break;
}

?>