<div class="article">
    <div class="c0-bouton"><a href="index.php?controller=article&action=home_articles">Retour</a></div>
<div class="container-article">
<?php
foreach($row as $result) {
    $timestamp = strtotime($result['date']);
    ?>
    <div class="c0-article"><?php echo $result['title'] ?></div>
    <div class="c1-article"></div>
    <div class="c2-article">Par : <?php echo $result['author'] ?> | <?php echo date("d-m-Y H:i", $timestamp); ?></div>
    <div class="c3-article"><?php echo html_entity_decode($result['content']);?></div>
<?php } ?>
</div>


</div>