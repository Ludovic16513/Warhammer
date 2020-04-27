<?php

require_once '../model/User.php';

foreach($row as $result) { ?>
    <form action="../public/index.php?controller=user&action=up_user" method="post">
        <input type="text" name="update_name" required value="<?php echo $result['name'] ?>">
        <input type="password" name="update_pass"  required placeholder="Hfgfg51212" maxlength="20" pattern = "^(?=.*\d)(?=.*[a-z])(?=.*[A-Z])(?!.*\s).*$" value=""<?php echo $result['password'] ?>"">
        <input type="email" name=update_email required
               pattern="[A-Za-z0-9](([_\.\-]?[a-zA-Z0-9]+)*)@([A-Za-z0-9]+)(([_\.\-]?[a-zA-Z0-9]+)*)\.([A-Za-z]{2,})"
               value="<?php echo $result['email'] ?>">
        <input type="hidden" name="id" value="<?php echo $result['id'] ?>">
        <button type="submit" name="update">Update</button>
    </form>
<?php } ?>