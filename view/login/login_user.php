
<body>
<div>
    <div>
        <?php if (isset($_SESSION['message'])){
        echo ($_SESSION['message']);
        unset($_SESSION['message']);
        } ?>
    </div>
    <div class="container-bouton"><a href="index.php?controller=article&action=home_articles">Retour</a></div>
</div>

<div class="container-titre">
    Connexion
</div>

<div id="bande"></div>


<div id="container-login">

    <div class="login">
    <form action="index.php?controller=user&action=user_chklogin" method="post">


        <p>Votre pseudo</p>
        <input type="text" name="username" required placeholder="Pseudo">


        <p>Votre password</p>
        <input type="password" name="password" required placeholder="Password">

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
            <input class="post" type="text" name="POST_CreateUser" required placeholder="Louis1651" maxlength="20" pattern = "^[A-Za-z0-9_]{1,15}$">

            <p>Password</p>
            <input type="password" name="POST_CreatePassword"  required placeholder="Hfgfg51212" maxlength="20" pattern = "^(?=.*\d)(?=.*[a-z])(?=.*[A-Z])(?!.*\s).*$">

            <p>Email</p>
            <input type="email" name="POST_CreateEmail" required pattern = "[A-Za-z0-9](([_\.\-]?[a-zA-Z0-9]+)*)@([A-Za-z0-9]+)(([_\.\-]?[a-zA-Z0-9]+)*)\.([A-Za-z]{2,})"
                   placeholder="Prenom@mail.com">
            <p></p>
            <button type="submit" name="create">Inscription</button>
        </form>
    </div>

</div>
</body>

