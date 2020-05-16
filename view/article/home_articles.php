<body class="articles">

<div class="container-js">
       <p class="c0-js" >Les nouvelles de l'éclaireur</p>
</div>


<div class="container-articles">
<?php
foreach ($row as $article){
$content = utf8_encode($article['content']);
?>
<div class="c0-articles" style="background-image: url('<?php echo "img/".$article['picture']?>')">
</div>

    <div class="c1-articles">
        <a href="index.php?controller=article&action=home_article&id=<?php echo utf8_encode($article['id_article']) ?>"><?php echo $article['title'] ?></a>
        <div class="c2-articles"><?php echo substr($content, 1, 300) . ' ...' ?>
        </div>
    </div>
    <?php
}
?>

</div>

</body>