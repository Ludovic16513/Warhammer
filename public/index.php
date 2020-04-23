<?php
?>
<?php

$controller = $_REQUEST['controller'];
$action = $_REQUEST['action'];

switch($controller)
{
    case"chklogin":

        require "../model/Login.php";
        require "../controller/LoginController.php";

        $ctrl = new LoginController();

        switch($action)
        {
            case"Login":
                $ctrl->Login();
                break;

            case"CheckLogin":
                $ctrl->CheckLogin();
                break;

            case "CreateLogin":
                $ctrl->CreateLogin();
                break;
        }

        break;
}

?>