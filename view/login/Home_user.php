<?php
echo $_SESSION['user'];

foreach($row as $result) { ?>
    <a href="../../public/LaMineDuNainBlanc.php?controller=user&action=login_update">update</a>
        <input type="number" name="id" value="<?php echo $result['id'] ?>">
<?php } ?>
