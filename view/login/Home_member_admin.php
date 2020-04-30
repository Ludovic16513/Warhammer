<?php
foreach($row as $result) {?>
    <li>
        <p><?php echo  $result['name']?></p>
        <p><?php echo  $result['date']?></p>
        <a href="../../public/LaMineDuNainBlanc.php?controller=user&action=read_one&id=<?php echo $result['id']?>">update</a>
        <a href="../../public/LaMineDuNainBlanc.php?controller=user&action=del_user&id=<?php echo $result['id']?>">delete</a>
    </li>
<?php } ?>