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

<div class="container-titre">PAGE DE CONTACT</div>

<div id="bande"></div>


<div id="container-login">

    <div class="login">
        <form action="index.php?controller=user&action=send_mail" method="post">
            <p>Votre email</p>
            <input type="text" name="email_user" required  pattern = "[A-Za-z0-9](([_\.\-]?[a-zA-Z0-9]+)*)@([A-Za-z0-9]+)(([_\.\-]?[a-zA-Z0-9]+)*)\.([A-Za-z]{2,})" placeholder="email">
            <p>Votre message</p>
            <textarea required name="mail_content" placeholder="Ecrivez votre message ici"></textarea>
            <input type="hidden" id="g-recaptcha-response" name="g-recaptcha-response">
            <button type="submit" name="login_user">Envoyer</button>
        </form>
    </div>

    <div class="inscription">
            <p>Vous voulez parler au roi??</p>
            <p>Il répondra au plus vite à votre demande !</p>
            <br>
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