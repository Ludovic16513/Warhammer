<body>
<div class="case_article"></div>
<div class="news">News and guides</div>

<?php
foreach ($row as $article) { $content =
    utf8_encode($article['content']); ?>

    <div class="container_article">
        <div class="article_picture">
            <img class="picture" src="../img/<?php echo $article['picture']?>" alt="img">

        </div>

            <div class="article_content">
                <div class="article_title"><a href="LaMineDuNainBlanc.php?controller=article&action=home_article&id=<?php echo $article['id']?>"><?php echo utf8_encode($article['title'])?></a>
                </div>
                 <p></p>
                <div class="article_text">
                    <?php echo substr($content,1,255) .' ...' ?>
                </div>
                </div>
        </div>
<?php } ?>
</body>


