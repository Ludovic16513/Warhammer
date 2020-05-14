
<div class="container-menu">
    <div class="c0-menu"><a href="index.php?controller=user&action=home_user">Retour profil</a></div>
</div>



<div class="container-title">
    <div class="c0-title">GESTION DES FEUILLES</div>
</div>

<div class="container-bar">
    <div class="c0-bar"></div>
    <div class="c1-bar">Titre des feuilles</div>
    <div class="c2-bar">Date</div>
    <div class="c3-bar">Supprimer</div>
    <div class="c4-bar"></div>
</div>


<div class="container-c0">
    <div class="c0">
        <?php
        foreach ($row as $sheet) { ?>
        <?php } ?>
        <a href="index.php?controller=sheet&action=add_sheet&id_user=<?php echo $sheet['id_user']?>"></a>
    </div>

    <?php
    foreach ($row as $sheet) {
        $timestamp = strtotime($sheet['date']);
        ?>
    <div class="c1"><a href="js/calculator/calculator.php?id=<?php echo utf8_encode($sheet['id'])?>"><?php echo utf8_encode($sheet['title'])?></a>
    <p></p></div>
    <div class="c2"><?php echo date("d-m-Y", $timestamp); ?></div>
    <div class="c3"><a class="a-delete" href="index.php?controller=sheet&action=delete_sheet&id=<?php echo $sheet['id']?>"></a></div>
    <div class="c4"></div>
    <?php } ?>
</div>