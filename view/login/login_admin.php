
<div>
    <?php if (isset($_SESSION['message'])){
        echo ($_SESSION['message']);
        unset($_SESSION['message']);
    } ?>
</div>

<div>
    <div class="container-bouton"><a href="index.php?controller=article&action=home_articles">Retour</a></div>
</div>

<div class="container-titre">
    Connexion Administrateur
</div>

<div id="bande"></div>


<div id="container-input">

    <form action="index.php?controller=user&action=admin_chklogin" method="post">

        <p>Votre pseudo</p>
        <input type="text" name="username_admin" required placeholder="Pseudo">

        <p>Votre password</p>
        <input type="password" name="password_admin" required placeholder="Password">

        <button type="submit" name="login_admin">Connexion</button>
    </form>
</div>



