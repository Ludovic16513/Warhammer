<?php foreach ($row as $result) {
?>

<div>
    <div class="container-bouton"><a href="index.php?controller=user&action=home_admin">Retour</a></div>
</div>

<div class="container-titre">
    Mise à jour d'un utilisateur
</div>

<div id="bande"></div>


<div id="container-input">

    <form action="index.php?controller=user&action=request_update_user" method="post">

        <p>Votre pseudo</p>

        <input type="text" name="update_name" required value="<?php echo utf8_encode($result['name']) ?>">


        <p>Votre password</p>
        <input type="password" name="update_pass"  required placeholder="Hfgfg51212" maxlength="20" pattern = "^(?=.*\d)(?=.*[a-z])(?=.*[A-Z])(?!.*\s).*$" value=""<?php echo $result['password'] ?>"">


        <p>Votre email</p>
        <input type="email" name=update_email required
               pattern="[A-Za-z0-9](([_\.\-]?[a-zA-Z0-9]+)*)@([A-Za-z0-9]+)(([_\.\-]?[a-zA-Z0-9]+)*)\.([A-Za-z]{2,})"
               value="<?php echo utf8_encode($result['email']) ?>">

        <p>Activation</p>
        <input type="number" value="<?php echo $result['active'] ?>" name="update_active" required placeholder="0 ou 1" maxlength="1">


        <input type="hidden" name="id" value="<?php echo $result['id'] ?>">

        <button type="submit" name="update_user">Mettre à jour</button>
    </form>
    <?php } ?>
</div>
