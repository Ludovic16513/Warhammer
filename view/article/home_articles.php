<div class="articles">

<div class="container-js">
       <p class="c0-js" >Les nouvelles de l'éclaireur</p>
</div>


<div class="container-articles">
<?php

foreach ($row as $article){
?>
<div class="c0-articles" style="background-image: url('<?php echo "img/".$article['picture']?>')">
</div>

    <div class="c1-articles">
        <a href="index.php?controller=article&action=home_article&id=<?php echo $article['id_article'] ?>"><?php echo $article['title'] ?></a>
        <div class="c2-articles"><?php echo substr($article['content'], 0, 300) . ' ...' ?>
        </div>
    </div>

    <?php
}
?>

</div>

</div>