<?php
session_start();

if (isset($_SESSION['user'])) { // Test si l'utiliseur connecté

    /* Connexion via le fichier bd.
    * new mysqli */
    include 'db.php';

    /* Valeur id de l'utilisateur
    * ex : 2 */
    $id = $db->real_escape_string($_GET['id_user']);

    /* Requête bd avec jointure,
    *  permet d'obtenir : feuille -> contenu. */
    $sql = "SELECT *
    FROM sheetcontent
    INNER JOIN sheet 
    ON sheetcontent.id_sheet = sheet.id_sheet_prim
    WHERE sheet.id_sheet_prim = $id";
    $result = $db->query($sql); //Lancement de la requête bd.
?>



<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="utf-8">
    <title>La mine du nain blanc</title>
    <link rel="stylesheet" href="../../css/calculator.css">
    <meta name="viewport" content="width=device-width, initial-scale=1">
</head>

<body class="calculator">

    <!-- Header -->
    <div class="container-title_sheet">
        <div class="back-sheets"><a href="../../index.php?controller=sheet&action=select_sheets">Retour</a></div>

        <div class="title">
           <?php $row = mysqli_fetch_array($result) ?>
               <input id="input_title" type="text" value="<?php echo $row['title'];?>" name="title_sheet">
               <input id="id_sheet_user" type="hidden" name="id_sheet_user" value="<?php echo $row['id_user']; ?>">
        </div>
    </div>

    <div class="container_total">
        <p id="total_army">total :</p>
        <input id="total_input_value" type="hidden">
    </div>

    <!-- DEBUT: Calculateur -->
        <div id="loading"><p>CHARGEMENT/CALCUL DES DONNNES EN COURS...</p></div>
        <!-- Formulaire d'ajout d'unité -->

    <div class="container_add-form">

        <!-- Selecteur d'unité -->
        <div>
            <select id="select_unit">
                <option name="guerriers" value="Guerriers">Guerriers</option>
                <option name="rangers" value="Rangers">Rangers</option>
                <option name="mineurs" value="Mineurs">Mineurs</option>
                <option name="Marteliers" value="Marteliers">Marteliers</option>
                <option name="Longues-Barbes" value="Longues-Barbes">Longues-Barbes</option>
                <option name="Brise-Fer" value="Brise-Fer">Brise-Fer</option>
                <option name="Tueurs-de-troll" value="Tueurs-de-troll">Tueurs-de-troll</option>
                <option name="Arquebusiers" value="Arquebusiers">Arquebusiers</option>
            </select>
            <input id="input_unit_cost" class="add" type="hidden" disabled>
        </div>

        <!-- Selecteur d'arme -->
        <div>
            <select id="select_weapon" name="select_weapon"></select>
            <input id="input_weapon_cost" class="add" type="hidden" disabled>
        </div>

        <!-- Selecteur d'armure -->
        <div>
            <select id="select_armor" name="select_armor"></select>
            <input id="input_armor_cost" class="add" type="hidden" disabled>
        </div>
        <!-- Selecteur de nombre d'unités -->
        <div>
                <input id="input_unit_multiply" type="number" size="2" value="1">
        </div>

        <div><input id="input_calculator" type="number" disabled></div>

        <div><button id="add_button">Ajouter</button></div>

    </div>
        <!-- Liste d'armée -->
        <div id="army_list">
            <?php while($row = $result->fetch_assoc()) {?>
                    <div class="unit">
                        <input id="unit_id" type="hidden" value="<?php echo $row['id_content'];?>">
                        <div class="container_unit">

                        <div class="number_unit"><?php echo $row['amount']; ?></div>
                        <div class="name_unit"><?php echo $row['unit'];?></div>
                        <div class="pts"> <?php echo $row['cost']; ?> pts</div>
                            <input class="total" type="hidden" value="<?php echo $row['cost']; ?>">
                        </div>

                        <div class="container_letter">
                            <div class="empty"></div>
                            <div class="M">M</div>
                            <div class="CC">C</div>
                            <div class="F">F</div>
                            <div class="E">E</div>
                            <div class="PV">P</div>
                            <div class="I">I</div>
                            <div class="A">A</div>
                            <div class="CD">C</div>
                        </div>

                        <div class="container_crt">
                            <div><?php echo $row['unit'];?></div>
                            <div class="c1">3</div>
                            <div class="c2">4</div>
                            <div class="c3">4</div>
                            <div class="c4">4</div>
                            <div class="c5">1</div>
                            <div class="c6">4</div>
                            <div class="c7">2</div>
                            <div class="c8">9</div>
                        </div>

                        <div class="container_weapon">
                        <div class="armes">Equipement: <?php echo $row['weapon']?>, <?php echo $row['armor']; ?></div>
                        </div>
                        <div class="container_options">
                            <div class="options">Options: musicien, étendard, chef</div>
                        </div>
                        <div class="container_object">
                            <div class="object">Objets:</div>
                        </div>
                         <a href="#" class="remove_unit">Delete</a>
                </div>
            <?php }}?>
        </div>
        <!-- Total -->

    <!-- FIN: Calculateur -->
    <form action="" method="post">
        <input id="input_id" type="hidden" name="id" value="<?php echo $id; ?>">
    </form>
</body>


<!-- Post-Chargement des scripts pour éviter de ralentir l'affiche de la page -->
<script src="../jquery-3.5.1.js"></script>
<script type="text/javascript" src="../post.js"></script>

</html>