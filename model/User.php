<?php

include('config/db.php');

/**
 * Class User
 */
class User
{
    private $mysqli;
    private $row = array();
    private $username;
    private $password;
    private $email;
    private $id;


    /**
     * User constructor.
     * @param Db $dbObj
     */
    public function __construct(Db $dbObj)
    {
        $this->mysqli = $dbObj->db;
        $this->row = $this->getRow();
    }


    // < ------ GET ---->

    /**
     * @return string
     */
    public function get_username()
    {
        return $this->username;

    }

    /**
     * @return int
     */
    public function get_id()
    {
        return $this->id;
    }

    /**
     * @return string
     */
    public function get_password()
    {
        return $this->password;
    }

    /**
     * @return mixed
     */
    public function get_email()
    {
        return $this->email;
    }

    /**
     * @return array|mixed
     */
    public function getRow()
    {
        return $this->row;
    }

    // < ----- SET ------>

    public function set_id(int $id)
    {
        $this->id = $id;
    }

    public function set_username(string $username)
    {
        $this->username = $username;
    }

    public function set_password(string $password)
    {
        $this->password = $password;
    }


    public function set_email(string $email)
    {
        $this->email = $email;
    }


    // < --------- CONNEXION UTILISATEUR --------->

    /**
     * @return bool
     */
    public function check_login_user()
    {
        // REQUEST
        $username = $this->get_username();
        $password = $this->get_password();

        $sql = "SELECT * FROM user WHERE name = ?";
        $stmt = $this->mysqli->prepare($sql);

        $stmt->bind_param("s", $username);
        $stmt->execute();

        // RESULT

        $result = $stmt->get_result();
        $row = $result->fetch_assoc();
        if ($result->num_rows > 0 && password_verify($password, $row['password']) && $row['active'] == 1) {
            return true;
        } else {
            return false;
        }
    }

    // < ---- SUPPRIME UN UTILISATEUR --->

    /**
     * @param $id
     * @return bool
     */
    public function delete_user()
    {
        $id = $this->get_id();
        $stmt = $this->mysqli->prepare("DELETE FROM `user` WHERE id = ?");
        $stmt->bind_param("i", $id);
        if ($stmt->execute()) {
            return true;
        } else {
            return false;
        }
    }

    // < ---- VERIFICATION DU MAIL --->

    /**
     * @param $key
     * @return bool
     */
    public function model_mail_validation($key)
    {

        // <---- Requête pour obtenir la clé de l'utilisateur ---->

        $username = $this->get_username();

        $stmt = $this->mysqli->prepare("SELECT user_key,active FROM user WHERE name=?");
        $stmt->bind_param("s", $username);
        $stmt->execute();


        // <---- Comparaison de la clé utilisateur avec le lien envoyé par email---->

        $result = $stmt->get_result();
        $row = $result->fetch_assoc();

        $user_key = $row['user_key'];
        $active = $row['active'];

        if ($active == '1') // Si le compte est déjà actif
        {
            return false;
        } else // Sinon le compte est bien désactivé
        {
            if ($key == $user_key) //compare les deux clés
            {
                $active = 1; // Si ça correspond, lance la requete et active le compte

                $stmt = $this->mysqli->prepare("UPDATE user SET active=? WHERE name=?");
                $stmt->bind_Param('is', $active, $username); // La requête va passer le champ active de 0 à 1
                $stmt->execute();
                return true;
            } else { // clés différentes
                return false;
            }
        }
    }

    // < --------- DECONNEXION UTILISATEUR ---------->

    /**
     * @return bool
     */
    public function disconnect()
    {
        // vide la session user et admin
        unset($_SESSION['user']);
        unset($_SESSION['admin']);
        return true;
    }

     // <------- LISTER UN UTILISATEUR ------->

    /**
     * @return array|null
     */
    public function read_one_user()
    {
        $id = $this->get_id();
        $sql = "SELECT * FROM user WHERE id = '$id'";
        $query = $this->mysqli->query($sql);
        while ($row = $query->fetch_assoc()) {
            $this->row[] = $row;
        }
        return $row;
    }

    // <------- LISTE DES UTILISATEURS ------->

    /**
     * @return bool
     */
    public function read_all_user()
    {
        $sql = "SELECT * FROM `user`";
        if ($query = $this->mysqli->query($sql)) {
            while ($row = $query->fetch_assoc()) {
                $this->row[] = $row;
            }
            return true;
        } else {
            return false;
        }
    }

    // <--------- CONNEXION ADMIN --------->

    /**
     * @return bool
     */
    public function check_login_admin()
    {
        // REQUEST
        $password = $this->get_password();
        $username = $this->get_username();

        $sql = "SELECT * FROM admin WHERE name = ?";
        $stmt = $this->mysqli->prepare($sql);

        $stmt->bind_param("s", $username);
        $stmt->execute();

        // RESULT
        $result = $stmt->get_result();
        $row = $result->fetch_assoc();

        if ($result->num_rows > 0 && password_verify($password, $row['password'])) {
            return true;
        } else {
            return false;
        }
    }

    //<----- CREATION D UN UTILISATEUR ------>

    /**
     * @return string
     */
    public function create_login()
    {
        $username = $this->get_username();
        $password = $this->get_password();
        $email = $this->get_email();

        //génère une clé
        $key = md5(microtime(TRUE) * 100000);

        // crypte le mot de passe
        $hash = password_hash($password, PASSWORD_BCRYPT);

        // <-- PREMIERE VERIFICATION -->

        $sql = "SELECT * FROM user WHERE name = ?";
        $stmt = $this->mysqli->prepare($sql);

        $stmt->bind_param("s", $username);
        $stmt->execute();

        $result = $stmt->get_result();
        $result->fetch_assoc();
        if ($result->num_rows === 0) {

            // <-- SECONDE VERIFICATION -->

            $sql = "SELECT * FROM user WHERE email = ?";
            $stmt->bind_param("s", $email);
            $stmt->execute();

            $result = $stmt->get_result();
            $result->fetch_assoc();

            if ($result->num_rows === 0) {

                // < -- INSERTION D UN UTILISATEUR -->

                // on prepare la requête en indiquant les lignes à insérer.
                $stmt = $this->mysqli->prepare('INSERT INTO user(name, password, email, user_key) VALUES (?,?,?,?)');
                // on ajoute les valeurs à la préparation et on définit leurs types.
                $stmt->bind_param("ssss", $username, $hash, $email, $key);
                // On execute le la requête.
                $stmt->execute();

                // < --- ENVOI DU MAIL --->
                $recipient = $email;
                $subject = "Activation de votre compte";
                $heading = "From: inscription@LamineDuNainBlanc.com";

                $message =
                    'Bienvenue sur LamineDuNainBlanc
                    Pour activer votre compte, veuillez cliquer sur le lien ci-dessous
                    ou copier/coller dans votre navigateur Internet.
                    http://creationalsite.com/Warhammer/index.php?controller=user&action=user_mail-valid&username=' . urlencode($username) . '&key=' . urlencode($key) . '
          
                    ---------------
                    Ceci est un mail automatique, Merci de ne pas y répondre.';

                ini_set('display_errors', 1);

                mail($recipient, $subject, $message, $heading);
                return $_SESSION['message'] = 'Inscription validée';
            } else {
                return $_SESSION['message'] = 'Utilisateur ou Email déjà existant';
            }

        } else {
            return $_SESSION['message'] = 'Utilisateur ou Email déjà existant';
        }
    }

    // < ---- MISE A JOUR UTILISATEUR ---->

    /**
     * @return bool
     */
    public function update_user()
    {
        $password = $this->get_password();
        $username = $this->get_username();
        $email = $this->get_email();
        $id = $this->get_id();
        $hash = password_hash($password, PASSWORD_BCRYPT);

        $sql = 'UPDATE user SET name=?, password=?, email=? WHERE id=?';
        $stmt = $this->mysqli->prepare($sql);
        $stmt->bind_param('sssi', $username, $hash, $email, $id);

        if ($stmt->execute()) {
            return true;
        } else {
            return false;
        }
    }

    // < ---- METHODE DE  SECURITE ---->

    /**
     * @param $value
     * @return string
     */
    public function escape_string($value)
    {
        return $this->mysqli->real_escape_string($value);
    }


    // < ---- CAPTCHA VERIFY ---->

    /**
     * @param $captcha
     * @return bool
     */
    public function verify_captcha($captcha)
    {
        $recaptcha_url = 'https://www.google.com/recaptcha/api/siteverify';
        $recaptcha_secret = "6Lc9__cUAAAAAKO4MQ8c-ftSIGSc9Ofcs6pb_MPq";
        $url = $recaptcha_url . '?secret=' . $recaptcha_secret . '&response=' . $captcha;
        $verifyResponse = file_get_contents($url);
        $verifyResponse = json_decode($verifyResponse);
        if ($verifyResponse->score >= 0.5) {
            return true; // captcha vérifié
        }
        return false; // captcha n'est pas vérifié
    }
}
