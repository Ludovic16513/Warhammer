<?php


foreach($row as $result) { ?>
    <?php $result['id'];
    $timestamp = strtotime($result['date']);
    ?>

    <?php  date("d-m-Y", $timestamp); ?>
<?php } ?>
<div>
    <?php if (isset($_SESSION['message'])){
        echo ($_SESSION['message']);
        unset($_SESSION['message']);
    utf8_encode($result['email']) ;
        } ?>
</div>

<div class="container_user">
    <div class="avatar"></div>
    <div class="pseudo"><?php  $_SESSION['user']?></div>
    <div class="joined">Joined :</div>

    <div class="user">Profil</div>
    <div class="sheet">Feuilles</div>
    <div class="rank">Rang</div>
    <div class="title">Titre</div>
    foreach($row as $result) { ?>
    <div></div>

    <div class="date"> date</div>
    <div class="a-delete"></div>
    <div class="victory"> Victoire :</div>
    <div class="interest">Biere et vin</div>
</div>

