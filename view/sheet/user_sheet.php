<?php
foreach ($row as $result) { ?>
    <?php $result['id'];
    $timestamp = strtotime($result['date_joined']);
    ?>
<?php } ?>
<body class="background_user">
<div class="container_user-0">

     <div>
         <?php if (isset($_SESSION['message'])){
             echo ($_SESSION['message']);
             unset($_SESSION['message']);
         } ?>
     </div>

     <div class="container_user-1">
         <div class="pseudo"><?php echo $_SESSION['user'] ?></div>
         <div class="joined">Joined : <?php echo date("d-m-Y", $timestamp); ?></div>
         <div class="disconnect"><a href="index.php?controller=user&action=user_disconnect&id_user=<?php echo $result['id']?>">Deconnexion</a></div>
     </div>

     <div class="container_user-2">
         <div class="user">PROFIL</div>
         <div class="sheet-add"><a href="index.php?controller=sheet&action=add_sheet&id_user=<?php echo $result['id']?>">Ajouter une feuille</a></div>
         <div class="sheet">MES FEUILLES</div>
     </div>

     <div class="container_user-3">
         <div class="rank">Rang: </div>
         <div class="victory"> Victoire:</div>
     </div>

    <div class="container_user-4">
    <div class="title">Titre</div>
    <div class="date">Date</div>
    <div class="delete">Supprimer</div>
    </div>

     <div class="container_user-5">
         <?php
         foreach ($row as $result) {
             $timestamp = strtotime($result['date']);
             ?>
             <div class="sheet-title">
                 <a href="js/calculator/calculator.php?id_user=<?php echo $result['id_sheet_prim'] ?>"><?php echo $result['title'] ?></a>
             </div>
             <div class="sheet-date">
                 <?php echo date("d-m-Y", $timestamp); ?>
             </div>
             <div class="sheet-delete"><a class="a-delete" href="index.php?controller=sheet&action=delete_sheet&id=<?php echo $result['id_sheet_prim'] ?>"></a></div>
         <?php } ?>
     </div>

     </div>
</body>