<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="utf-8">
    <title>La mine du nain blanc</title>
    <link rel="stylesheet" href="../css/header_user.css">
    <link rel="stylesheet" href="../css/articles.css">
    <link href="https://fonts.googleapis.com/css2?family=Lato:wght@900&display=swap" rel="stylesheet">
</head>
<header>
    <div class="container_title">
        <div class="logo"></div>
        <div class="titre">LA MINE DU NAIN BLANC</div>
    </div>
</header>

<div class="nav">
    <div class="menu">LA BIBLIOTHEQUE</div>
    <div class="menu">LA FORGERUNE</div>
    <div class="menu">L'ARMURERIE</div>
    <div class="menu"><a href="LaMineDuNainBlanc.php?controller=user&action=home_user"><?php echo $_SESSION['user']?> (connected)</a></div>

</div>


