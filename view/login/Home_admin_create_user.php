
<body>

<div>
    <?php if (isset($_SESSION['message'])){
        echo ($_SESSION['message']);
        unset($_SESSION['message']);
        define('SITE_KEY','6LdTAPgUAAAAANxnCIPfTXtwDferCQqgyFhvxnus');
        define('SECRET_KEY','6LdTAPgUAAAAAI-MdO-_mmx9aNldwZ4LFl6JDUES');
    } ?>
</div>
<div>
    <div class="container-bouton"><a href="index.php?controller=user&action=home_admin">Retour</a></div>
</div>

<div class="inscription_admin">
        <form action="index.php?controller=user&action=request_create_user" method="post">
            <p>Pseudo<p>
            <input class="post" type="text" name="POST_CreateUser" required placeholder="Louis1651" maxlength="20" pattern = "^[A-Za-z0-9_]{1,15}$">

            <p>Password</p>
            <input type="password" name="POST_CreatePassword"  required placeholder="Hfgfg51212" minlength="8" maxlength="20" pattern = "^(?=.*\d)(?=.*[a-z])(?=.*[A-Z])(?!.*\s).*$">

            <input type="hidden" id="g-recaptcha-response" name="g-recaptcha-response">
            <p>Confirmez</p>
            <input type="password" name="POST_ConfirmPassword"  required  placeholder="ex : Louis59740" minlength="8" maxlength="20" pattern = "^(?=.*\d)(?=.*[a-z])(?=.*[A-Z])(?!.*\s).*$">

            <p>Email</p>
            <input type="email" name="POST_CreateEmail" required pattern = "[A-Za-z0-9](([_\.\-]?[a-zA-Z0-9]+)*)@([A-Za-z0-9]+)(([_\.\-]?[a-zA-Z0-9]+)*)\.([A-Za-z]{2,})"
                   placeholder="Prenom@mail.com">

            <p>Activation</p>
            <input type="number" name="POST_active" required placeholder="0 ou 1" maxlength="1">

            <button type="submit" name="create">Inscription</button>
        </form>
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