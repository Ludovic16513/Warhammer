<?php require_once '../model/User.php'; ?>

    <link rel="stylesheet" type="text/css" href="../public/css/header.css" />
    <img src="../../img/404px-NainsContreDémons.jpg" alt="">

    <form action="../../public/LaMineDuNainBlanc.php?controller=user&action=chklogin" method="post">
        <input type="text" name="username" required placeholder="User">
        <input type="password" name="password" required placeholder="Password">
        <button type="submit" name="login">Connexion</button>
    </form>


<?php foreach($row as $result) {?>
    <li>
        <p><?php echo  $result['name']?></p>
        <p><?php echo  $result['date']?></p>
        <a href="../../public/LaMineDuNainBlanc.php?controller=user&action=read_one&id=<?php echo $result['id']?>">update</a>
        <a href="../../public/LaMineDuNainBlanc.php?controller=user&action=del_user&id=<?php echo $result['id']?>">delete</a>
    </li>
<?php } ?>