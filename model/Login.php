<?php

require '../config/db.php';
require '../model/Mail.php';


class Login
{
    use Mail;

    //Var des POST
    private $password;
    private $user;

    //Var pour la creation des données
    private $createUser;
    private $createPassword;
    private $createEmail;

    // var des requêtes  SQL
    private $mysqli;
    private $query;
    private $stmt;

    //Var pour obtenir le résultat fetch name et password du select
    private $GetPassword;
    private $GetUser;

    // Var De protection
    private $hash;


    public function __construct(Db $dbObj)
    {
        //Injection par dépendance base de données
        $this->mysqli = $dbObj->db;
    }


    // 1) set pour la connexion des utilisateurs
    public function set_LoginPassword()
    {
      $this->password = $_POST['POST_Password'];
      return $this->password;
    }

    public function set_LoginUser()
    {
        $this->user = $_POST['POST_User'];
        return $this->user;
    }


    // 1.2) set pour la creation des utilisateurs
    public function setCreateUser()
    {
        $this->createUser = $this->valid_data($_POST['POST_CreateUser']);
        return $this->createUser;
    }


    public function setCreatePassword(){
        $this->createPassword = $this->valid_data($_POST['POST_CreatePassword']);
        return $this->createPassword;
    }

    public function setCreateEmail()
    {
        $this->createEmail = $this->valid_data($_POST['POST_CreateEmail']);
        return $this->createEmail;
    }

    // 2) protection des données à envoyer sur la base de données.

    private function valid_data($data){
        //supprime les espaces en fin de chaine de caractère.
        $data = trim($data);
        //supprime les antislashs
        $data = stripslashes($data);
        //convertit les caractères spéciaux en entités HTML.
        $data = htmlspecialchars($data);
        //créer une chaîne SQL valide
        $data = $this->mysqli->real_escape_string($data);
        return $data;
    }

    private function hash_password(){
        //permet de crypter le password lors de la creation du compte.
        $this->hash = password_hash($this->createPassword, PASSWORD_DEFAULT);
        return $this->hash;
    }



    // 3) Requête SQL
    private function selectQuery()
    {
        //Requete pour une selection de base de données
        $this->query = $this->mysqli->query("SELECT * FROM user where name = '$this->user'");
    }

    // on Obtient le résultat de la requête Select
    public function getSelect() {
            while ($row = $this->query->fetch_assoc()) {
            $this->GetPassword = $row['password'];
            $this->GetUser = $row['name'];
        }
}


    public function insert_User()
    {
        // on crypte la variable contenant le _POST pour le password.
        $this->hash_password();
        // on prepare la requête en indiquant les lignes à insérer.
        if (!($this->stmt = $this->mysqli->prepare('INSERT INTO user(name, password, email) VALUES (?,?,?)'))) {
            echo "Echec de la préparation : (" . $this->mysqli->errno . ") " . $this->mysqli->error;
        }
        // on ajoute les valeurs à la préparation et on définit leur type.
        if (!$this->stmt->bind_param("sss",$this->createUser,$this->hash,$this->createEmail)) {
            echo "Echec lors du liage des paramètres : (" . $this->stmt->errno . ") " . $this->stmt->error;
        }
// On execute le la requête.
        if (!$this->stmt->execute()) {
            echo "Echec lors de l'exécution : (" . $this->stmt->errno . ") " . $this->stmt->error;
        }
    }


    // 4) Verification des informations et connexion utilisateurs ou Admin
    public function checkLogin()
    {
        // On récupère les variables_POST
        $this->set_LoginPassword();
        $this->set_LoginUser();

        //On lance la requête
        $this->selectQuery();
        $this->getSelect();

        // Puis on compare les résultats des fetch_assoc avec les POST
        if (password_verify($this->password, $this->GetPassword) && $this->user === $this->GetUser) {
            echo 'Connexion avec le foyer bienvenue' ;
        }

        else
        {
            echo 'Connexion refusé password ou user incorrect';
        }
    }


}
