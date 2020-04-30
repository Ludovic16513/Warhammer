<div class="container">
    <form action="../../public/LaMineDuNainBlanc.php?controller=article&action=crtarticle" enctype="multipart/form-data" method="post">

    <div>
        <label for="title">Titre</label>
    </div>

    <div>
            <input type="text" name="title">
        </div>

        <div>
            <input type="text" name="author">
        </div>

    <div>
        <div>
            <label for="content">Text</label>
        </div>

        <textarea name="content" rows="10" cols="50">Rédigez votre article ici</textarea>

        <p>Choisissez une photo.</p>
        <input type="hidden" name="MAX_FILE_SIZE" value="2097152">
        <input type="file" name="photo">

    </div>
    <div>

        <button type="submit" name="ok">Envoyer</button>
    </div>
    </form>
</div>
