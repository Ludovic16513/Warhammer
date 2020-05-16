<?php foreach ($row as $result) {
?>
<div>
    <div class="container-bouton"><a href="index.php?controller=article&action=admin_article">Retour</a></div>
</div>



<div class="container-titre">
    Mise à jour d'un article
</div>

<div id="bande"></div>


<div id="container-input">

    <form action="index.php?controller=article&action=request_upgrade_article" enctype="multipart/form-data" method="post">

        <input type="hidden" name="update_article_id" required value="<?php echo $result['id_article'] ?>">

        <p>Votre titre</p>
        <input type="text" name="update_title" required maxlength="50" value="<?php echo $result['title']?>">


        <p>Votre article</p>
        <textarea name="update_content"
           maxlength="1000"  required placeholder="Ecrivez votre texte ici"><?php echo $result['content'] ?>
        </textarea>
<?php } ?>

        <p>Choisissez une photo.</p>
        <input type="hidden" name="MAX_FILE_SIZE" value="2097152">
        <input type="file" name="photo_update">

        <button type="submit" name="update_article">Update</button>

    </form>
</div>

