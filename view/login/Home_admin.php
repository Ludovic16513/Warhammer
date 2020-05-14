<body>
<div>
    <?php if (isset($_SESSION['message'])){
        echo ($_SESSION['message']);
        unset($_SESSION['message']);
    } ?>
</div>


<div class="container-menu">
    <div class="c0-menu"><a href="index.php?controller=article&action=admin_article">Gestion des Articles</a></div>
</div>

<div class="container-title">
    <div class="c0-title">GESTION DES MEMBRES</div>
</div>

<div class="container-bar">
    <div class="c0-bar"></div>
    <div class="c1-bar">Nom des Membres</div>
    <div class="c2-bar">Date</div>
    <div class="c3-bar">Supprimer</div>
    <div class="c4-bar"></div>
</div>


<div class="container-c0">
    <div class="c0"></div>
    <?php
    foreach ($row as $result) {
        $timestamp = strtotime($result['date']);?>
        <div class="c1"><a href="index.php?controller=user&action=update_user&id=<?php echo $result['id']?>"><?php echo utf8_encode($result['name'])?></a></div>
        <div class="c2"><?php echo date("d-m-Y H:i", $timestamp)?></div>
        <div class="c3"><a class="a-delete" href="index.php?controller=user&action=del_user&id=<?php echo $result['id']?>"></a></div>
        <div class="c4"></div>
    <?php } ?>
</div>
</body>