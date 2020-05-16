<?php

require "model/sheet.php";

class SheetController
{

    private $sheet;
    private $user;
    /**
     * SheetController constructor.
     */
    public function __construct()
    {
        $this->sheet = new sheet(new db);
    }

    /**
     *
     */
    public function select_sheets()
    {
        if (isset($_SESSION['user'])) {

            $session = $_SESSION['user'];

            $this->sheet->escape_string($session);

            $this->sheet->select_sheets($session);
            $row = $this->sheet->getRow();

            include 'view/sheet/user_sheet.php';
        } else {
            $_SESSION['message'] = 'Veuillez vous connecter';
            include 'view/login/login_user.php';
        }
    }

    /**
     *
     */
    public function create_sheet()
    {
        // <---- REQUETE DE CREATION D 'UNE FEUILLE ---->

        $id_user = $this->sheet->escape_string($_GET['id']);

        $this->sheet->insert_sheet($id_user);

        $_SESSION['message'] = 'Feuille ajouté';

        $_SESSION['user'];
        header('Location: index.php?controller=sheet&action=select_sheets');
    }


    public function delete_sheet()
    {
        // <---- SUPPRESSION D'UN UTILISATEUR ---->

        // Lance la méthode puis redirection vers la page de login.

        $id = $this->sheet->escape_string($_GET['id']);
        $this->sheet->delete_sheet($id);
        $_SESSION['Message'] = 'Feuille supprimée';
        header('Location: index.php?controller=sheet&action=select_sheets');
    }


}


