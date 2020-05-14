<div>
    <div>
        <?php if (isset($_SESSION['message'])){
            echo ($_SESSION['message']);
            unset($_SESSION['message']);
        } ?>
    </div>
    <div class="container-bouton"><a href="index.php?controller=article&action=admin_article">Retour</a></div>
</div>


<div class="container-titre">
    Creation d'un article
</div>

<div id="bande"></div>


<div id="container-input">
    <form action="index.php?controller=article&action=request_create_article" enctype="multipart/form-data" method="post">

        <p>L'auteur</p>

        <input type="text" name="create_author" required value="">


        <p> Votre titre</p>
        <input type="text" name="create_title" required value="">


        <p>Votre article</p>
        <textarea required name="create_content"
                  placeholder="Ecrivez votre texte ici">
        </textarea>


        <p>Choisissez une photo.</p>
        <input type="hidden" name="MAX_FILE_SIZE" value="2097152">
        <input type="file" name="photo">

        <button type="submit" name="ok">Creer</button>
    </form>

</div>


