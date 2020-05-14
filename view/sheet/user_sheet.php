 <div class="c1">
     <?php


     foreach($row as $result) { ?>
         <?php $result['id'];
         $timestamp = strtotime($result['date_joined']);
         $result['id'];
         ?>
     <?php } ?>

     <html class="background_user">
     <div>
         <?php if (isset($_SESSION['message'])){
             echo ($_SESSION['message']);
             unset($_SESSION['message']);
             utf8_encode($result['email']) ;
         } ?>
     </div>

     <div class="container_user">
         <div class="avatar"></div>
         <div class="pseudo : "><?php echo $_SESSION['user']?></div>
         <div class="joined">Joined : <?php  echo date("d-m-Y", $timestamp); ?></div>

         <div class="user">Profil</div>
         <div class="sheet">MES FEUILLES</div>
         <div class="rank">Rang</div>

         <div class="victory"> Victoire :</div>
         <div class="interest">Biere et vin</div>
         <?php
         foreach($row as $result) {
             $timestamp = strtotime($result['date']);
             ?>
             <div class="title">Titre</div>
             <div class="sheet-title">
                 <a href="js/calculator/calculator.php?id=<?php echo utf8_encode($result['id'])?>"><?php echo utf8_encode($result['title'])?></a>
             </div>
             <div class="date">date</div>
             <div class="sheet-date">
                 <?php  echo date("d-m-Y", $timestamp); ?>
             </div>
             <div class="delete">delete</div>
             <div class="sheet-delete">
                 <a class="a-delete" href="index.php?controller=sheet&action=delete_sheet&id=<?php echo $result['id_sheet']?>"></a>
             </div>
         <?php } ?>
     </div>
     </html>

