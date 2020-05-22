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
            $escape_session = $this->sheet->escape_string($session);
            $this->sheet->set_session($escape_session);

            $this->sheet->select_sheets();
            $row = $this->sheet->getRow();

            include 'view/sheet/user_sheet.php';
        } else {
            $_SESSION['message'] = 'Veuillez vous connecter';
            include 'view/login/login_user.php';
        }
    }

    // <---- REQUETE DE CREATION D 'UNE FEUILLE ---->

    public function create_sheet()
    {
        $id_user = $_GET['id_user'];
        $escape_id = $this->sheet->escape_string($id_user);
        $this->sheet->set_id_user($escape_id);

        $this->sheet->insert_sheet();
        $_SESSION['message'] = 'Feuille ajouté';
        $_SESSION['user'];
        header('Location: index.php?controller=sheet&action=select_sheets');
    }


    public function delete_sheet()
    {
        // <---- SUPPRESSION D'UNE FEUILLE ---->

        // Lance la méthode puis redirection vers la page de login.

        $id_sheet = $_GET['id'];
        $escape_id_sheet = $this->sheet->escape_string($id_sheet);
        $this->sheet->set_sheet_id($escape_id_sheet);
        $this->sheet->delete_sheet();
        $_SESSION['Message'] = 'Feuille supprimée';
        header('Location: index.php?controller=sheet&action=select_sheets');
    }


}


