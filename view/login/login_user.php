<link rel="stylesheet" type="text/css" href="../../css/header_user.css" />

<form action="../../public/LaMineDuNainBlanc.php?controller=user&action=chklogin" method="post">
    <input type="text" name="username" required placeholder="User">
    <input type="password" name="password" required placeholder="Password">
    <button type="submit" name="login">Connexion</button>
</form>

<form action="../../public/LaMineDuNainBlanc.php?controller=user&action=crtlogin" method="post">
    <label for="POST_User">Pseudo</label>
    <input type="text" name="POST_CreateUser" required placeholder="Louis1651" maxlength="20" pattern = "^[A-Za-z0-9_]{1,15}$">

    <label for="POST_Password">Password</label>
    <input type="password" name="POST_CreatePassword"  required placeholder="Hfgfg51212" maxlength="20" pattern = "^(?=.*\d)(?=.*[a-z])(?=.*[A-Z])(?!.*\s).*$">

    <label for="POST_Email"></label>
    <input type="email" name="POST_CreateEmail" required pattern = "[A-Za-z0-9](([_\.\-]?[a-zA-Z0-9]+)*)@([A-Za-z0-9]+)(([_\.\-]?[a-zA-Z0-9]+)*)\.([A-Za-z]{2,})"
           placeholder="Prenom@mail.com">
    <button type="submit" name="create">Create</button>
</form>


