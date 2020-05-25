
<body>

<div>
    <div>
        <?php if (isset($_SESSION['message'])){
        echo ($_SESSION['message']);
        unset($_SESSION['message']);
        }

        define('SITE_KEY','6LdTAPgUAAAAANxnCIPfTXtwDferCQqgyFhvxnus');
        define('SECRET_KEY','6LdTAPgUAAAAAI-MdO-_mmx9aNldwZ4LFl6JDUES');

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
        <input class="input_login" type="text" pattern="[a-zA-Z0-9]+" name="username" required placeholder="Pseudo">

        <p>Votre password</p>
        <input  class="input_login" type="password" name="password"  required placeholder="Password">

        <p></p>
        <button class="input_login" type="submit" name="login_user">Connexion</button>
    </form>
    </div>

    <div class="inscription">

        <form action="index.php?controller=user&action=crt_user" method="post">
<p>Vous n'êtes pas encore un nain?</p>
            <p> Inscrivez vous c'est gratuit et vous pourrez creer vos fiches d'armée !</p>
            <br>
            <p>Pseudo<p>
            <input class="input_login" type="text" name="POST_CreateUser" pattern = "[a-zA-Z0-9]+" placeholder="Louis1651" minlength="6" maxlength="20" >
            <p>Password</p>
            <input  class="input_login" type="password" name="POST_CreatePassword"  required  placeholder="ex : Louis59740" minlength="8" maxlength="20" pattern = "^(?=.*\d)(?=.*[a-z])(?=.*[A-Z])(?!.*\s).*$">
            <input type="hidden" id="g-recaptcha-response" name="g-recaptcha-response">
            <p>Confirmez</p>
            <input  class="input_login" type="password" name="POST_ConfirmPassword"  required  placeholder="ex : Louis59740" minlength="8" maxlength="20" pattern = "^(?=.*\d)(?=.*[a-z])(?=.*[A-Z])(?!.*\s).*$">
            <p>Email</p>
            <input type="email" class="input_login" name="POST_CreateEmail" required  pattern = "[A-Za-z0-9](([_\.\-]?[a-zA-Z0-9]+)*)@([A-Za-z0-9]+)(([_\.\-]?[a-zA-Z0-9]+)*)\.([A-Za-z]{2,})"
                   placeholder="Prenom@mail.com">
            <p></p>
            <button type="submit" class="input_login" name="create">Inscription</button>
            <p></p>
        </form>
    </div>

</div>

</body>

<script>
    grecaptcha.ready(function () {
        grecaptcha.execute('6Lc9__cUAAAAAAGD8ysZMYRLlxP8LGJbB6zn0nFq', { action: 'login' }).then(function (token) {
            var recaptchaResponse = document.getElementById('g-recaptcha-response');
            recaptchaResponse.value = token;
        });
    });
</script>