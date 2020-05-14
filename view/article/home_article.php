<div class="c0-bouton"><a href="index.php?controller=article&action=home_articles">Retour</a></div>
<div class="container-article">
<?php
foreach($row as $result) {
    $timestamp = strtotime($result['date']);
    ?>
    <div class="c0-article"><?php echo utf8_encode($result['title']) ?></div>
    <div class="c2-article"><?php echo date("d-m-Y H:i", $timestamp); ?></div>
    <div class="c1-article"></div>
    <div class="c3-article"><?php echo utf8_encode($result['content']);?></div>
<?php } ?>
</div>

