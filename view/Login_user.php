<?php
echo $_SESSION['user'];

foreach($row as $result) { ?>
    <a href="../public/index.php?controller=user&action=login_update">update</a>
        <input type="number" name="id" value="<?php echo $result['id'] ?>">
<?php } ?>

