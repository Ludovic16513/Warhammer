
<div>
    <?php if (isset($_SESSION['message'])){
        echo ($_SESSION['message']);
        unset($_SESSION['message']);
    } ?>

</div>

<div>
    <div class="container-bouton"><a href="index.php?controller=user&action=Home_admin">Retour</a></div>
</div>


<div class="inscription_admin">

        <form action="index.php?controller=user&action=crt_user" method="post">
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