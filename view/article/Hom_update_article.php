<?php foreach ($row as $result) { ?>

    <form action="../../public/LaMineDuNainBlanc.php?controller=article&action=up_article" method="post">
    <label for="update_title"></label>

    <input type="text" name="update_author" required value="<?php echo $result['author'] ?>">

    <input type="hidden" name="update_article_id" value="<?php echo $result['id'] ?>">

    <input type="text" name="update_title" value="<?php echo $result['title'] ?>">

    <textarea name="update_content"><?php echo $result['content'] ?></textarea>

    <p>Choisissez une photo.</p>
    <input type="hidden" name="MAX_FILE_SIZE" value="2097152">
    <input type="file" name="photo"


    <button type="submit" name="update_article">Update</button>


<?php } ?>