
<body>

<div>
    <div>
        <?php if (isset($_SESSION['message'])){
        echo ($_SESSION['message']);
        unset($_SESSION['message']);
        }

        define('SITE_KEY','6LdTAPgUAAAAANxnCIPfTXtwDferCQqgyFhvxnus');
        define('SECRET_KEY','6LdTAPgUAAAAAI-MdO-_mmx9aNldwZ4LFl6JDUES');

/*             <---------  TO DO LOGIN RESPONSE --------->
        if($_POST){
            function getCaptcha($secretkey){

                $response = file_get_contents("https://www.google.com/recaptcha/api/siteverify?secret=".SECRET_KEY."&response={$secretkey}");
                $return = json_decode($response);
                return $return;
            }
            $return = getCaptcha($_POST['captcha-response']);

            if ($response->succes === true && $return->score >0.5)
            {
                echo 'ok';
            }
        }
*/

        ?>
    </div>
    <div class="container-bouton"><a href="index.php?controller=article&action=home_articles">Retour</a></div>
</div>

<div class="container-titre">
    Connexion
</div>

<div id="bande"></div>


<div id="container-login">

    <div class="login">
    <form  action="index.php?controller=user&action=user_chklogin" method="post">


        <p>Votre pseudo</p>
        <input type="text" pattern="[a-zA-Z0-9]+" name="username" required placeholder="Pseudo">


        <p>Votre password</p>
        <input type="password" name="password"  required placeholder="Password">

        <p></p>
        <button type="submit" name="login_user">Connexion</button>
    </form>

    </div>

    <div class="inscription">

        <form action="index.php?controller=user&action=crt_user" method="post">
<p>Vous n'êtes pas encore un nain?</p>
            <p> Inscrivez vous c'est gratuit et vous pourrez creer vos fiches d'armée !</p>
            <br>
            <p>Pseudo<p>
            <input class="post" type="text" name="POST_CreateUser" required  placeholder="Louis1651" minlength="6" maxlength="20" pattern = "[a-zA-Z0-9]+">
            <p>Password</p>
            <input type="password" name="POST_CreatePassword"  required  placeholder="Hfgfg51212" minlength="8" maxlength="20" pattern = "^(?=.*\d)(?=.*[a-z])(?=.*[A-Z])(?!.*\s).*$">
            <input type="hidden" id="captcha-response" name="captcha-response">
            <p>Email</p>
            <input type="email" name="POST_CreateEmail" required  pattern = "[A-Za-z0-9](([_\.\-]?[a-zA-Z0-9]+)*)@([A-Za-z0-9]+)(([_\.\-]?[a-zA-Z0-9]+)*)\.([A-Za-z]{2,})"
                   placeholder="Prenom@mail.com">
            <p></p>
            <button type="submit" name="create">Inscription</button>
        </form>
    </div>

</div>

</body>

