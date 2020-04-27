<?php require_once '../model/User.php'; ?>

    <link rel="stylesheet" type="text/css" href="../public/css/style.css" />
    <img src="../public/img/404px-NainsContreDémons.jpg" alt="">

<form action="../public/index.php?controller=user&action=chklogin" method="post">
    <input type="text" name="username" required placeholder="User">
    <input type="password" name="password" required placeholder="Password">
    <button type="submit" name="login">Connexion</button>
</form>

<form action="../public/index.php?controller=user&action=crtlogin" method="post">
    <label for="POST_User">Pseudo</label>
    <input type="text" name="POST_CreateUser" required placeholder="Louis1651" maxlength="20" pattern = "^[A-Za-z0-9_]{1,15}$">

    <label for="POST_Password">Password</label>
    <input type="password" name="POST_CreatePassword"  required placeholder="Hfgfg51212" maxlength="20" pattern = "^(?=.*\d)(?=.*[a-z])(?=.*[A-Z])(?!.*\s).*$">

    <label for="POST_Email"></label>
    <input type="email" name="POST_CreateEmail" required pattern = "[A-Za-z0-9](([_\.\-]?[a-zA-Z0-9]+)*)@([A-Za-z0-9]+)(([_\.\-]?[a-zA-Z0-9]+)*)\.([A-Za-z]{2,})"
           placeholder="Prenom@mail.com">

    <button type="submit" name="create">Create</button>
</form>


<?php foreach($row as $result) {?>
    <li>
        <p><?php echo  $result['name']?></p>
        <p><?php echo  $result['date']?></p>
        <a href="../public/index.php?controller=user&action=read_one&id=<?php echo $result['id']?>">update</a>
<a href="../public/index.php?controller=user&action=del_user&id=<?php echo $result['id']?>">delete</a>
    </li>
<?php } ?>