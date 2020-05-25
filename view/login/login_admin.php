
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
        <input type="text" class="input_login" pattern="[a-zA-Z0-9]+" name="username_admin" required value="" placeholder="Pseudo">

        <p>Votre password</p>
        <input type="password" class="input_login" pattern="^(?=.*\d)(?=.*[a-z])(?=.*[A-Z])(?!.*\s).*$" name="password_admin" required value="" placeholder="Password">
<p></p>
        <button type="submit"  class="input_login" name="login_admin">Connexion</button>
    </form>
</div>




