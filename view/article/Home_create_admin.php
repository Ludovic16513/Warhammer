<div>
    <div class="container-bouton"><a href="index.php?controller=article&action=admin_article">Retour</a></div>
</div>


<div class="container-titre">
    Creation d'un article
</div>

<div id="bande"></div>


<div id="container-input">
    <form action="index.php?controller=article&action=request_create_article" enctype="multipart/form-data" method="post">

        <p>L'auteur</p>

        <input type="text"  pattern = "[A-Za-z\s?]+\" maxlength="20" name="create_author" required>


        <p>Votre titre</p>
        <input type="text" pattern = "[A-Za-z\s?]+\" maxlength="50" name="create_title" required>


        <p>Votre article</p>
        <textarea required name="create_content" placeholder="Ecrivez votre texte ici">
        </textarea>


        <p>Choisissez une photo.</p>
        <input type="hidden" name="MAX_FILE_SIZE" value="200000">
        <input type="file" name="photo">

        <button type="submit" name="ok">Creer</button>
    </form>

</div>


