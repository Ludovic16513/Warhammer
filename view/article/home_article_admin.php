<div class="container-menu">
    <div class="c0-menu"><a href="index.php?controller=user&action=home_admin">Gestion Membres</a></div>
</div>



<div class="container-title">
    <div class="c0-title">GESTION DES ARTICLES</div>
</div>

<div class="container-bar">
    <div class="c0-bar"></div>
    <div class="c1-bar">Titre des articles</div>
    <div class="c2-bar">Date</div>
    <div class="c3-bar">Supprimer</div>
    <div class="c4-bar"></div>
</div>


<div class="container-c0">
    <div class="c0"><a class="a-add" href="index.php?controller=article&action=admin_create_article"></a></div>
    <?php
    foreach ($row as $article) { $timestamp = strtotime($article['date']); ?>
    <div class="c1"><a href="index.php?controller=article&action=upgrade_article&id=<?php echo utf8_encode($article['id_article'])?>"><?php echo utf8_encode($article['title'])?></a></div>
    <div class="c2"><?php echo date("m-d-Y", $timestamp)?></div>
        <div class="c3"><a class="a-delete" href="index.php?controller=article&action=request_delete_article&id=<?php echo $article['id_article']?>"></a></div>
    <div class="c4"></div>
    <?php } ?>
</div>
