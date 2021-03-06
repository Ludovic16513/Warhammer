<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="utf-8">
    <title>La mine du nain blanc</title>
    <link rel="stylesheet" href="css/articles_templates.css">
    <link rel="stylesheet" href="css/admin_template.css">
    <link rel="stylesheet" href="css/footer_template.css">
    <link rel="stylesheet" href="css/header-template.css">
    <link rel="stylesheet" href="css/input_template.css">
    <link rel="stylesheet" href="css/user_template.css">
    <link rel="stylesheet" href="css/calculator.css">
    <link href="https://fonts.googleapis.com/css2?family=Lato:ital,wght@0,100;0,300;0,400;0,700;0,900;1,100;1,300;1,400;1,700;1,900&display=swap" rel="stylesheet">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <script src="js/jquery-3.5.1.js"></script>
</head>

<header>
    <div class="container-header">
        <div class="c0-header"></div>
        <div class="c1-header">LA MINE DU NAIN BLANC</div>
    </div>
    <div class="container-nav">
        <div class="c0-nav"><a href="index.php?controller=article&action=home_articles">GUET</a></div>
        <div class="c1-nav"><a href="index.php?controller=user&action=home_admin">TRÔNE</a></div>
        <div class="c2-nav">DEDALE</div>
        <div class="ar marge">ARMURERIE</div>
        <div class="qg marge">QG</div>
        <div class="bi marge">BIBLIOTHEQUE</div>
        <div class="c3-nav"><a href="index.php?controller=user&action=home_user"><?php echo $_SESSION['user'] ?></a></div>
    </div>

</header>

<body>
<script src="https://www.google.com/recaptcha/api.js?render=6Lc9__cUAAAAAAGD8ysZMYRLlxP8LGJbB6zn0nFq"></script>
<script src="js/menu.js"></script>
</body>

</html>

