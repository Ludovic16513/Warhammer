<?php
session_start();

if (isset($_SESSION['user'])) { // Test si l'utiliseur connecté

try { //Test erreur.

    /* Connexion via le fichier bd.
    * new mysqli */
    include 'db.php';

    /* Valeur id de l'utilisateur
    * ex : 2 */
    $id = $db->real_escape_string($_GET['id']);

    /* Requête bd avec jointure,
    *  permet d'obtenir : feuille -> contenu. */
    $sql = "SELECT *
    FROM sheetcontent
    INNER JOIN sheet 
    ON sheetcontent.id_sheet = sheet.id
    WHERE sheet.id = $id";

    $result = $db->query($sql); //Lancement de la requête bd.

} catch (Exception $e) { // Gestion des erreurs
    echo $e;
}

?>

<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="utf-8">
    <title>La mine du nain blanc</title>
</head>

<body>
    <!-- Header -->
    <div class="container-title_sheet">
        <div class="back-sheets"><a href="../../index.php?controller=sheet&action=select_sheets">Retour</a></div>
        <div class="title-sheet"></div>
        <div id="total-sheet"></div>
    </div>

    <form action="" method="post">
        <input id="input_id" type="hidden" name="id" value="<?php echo $id; ?>">
    </form>

    <!-- DEBUT: Calculateur -->
    <div class="calculator_container">
        <div id="loading">
            <p>CHARGEMENT/CALCUL DES DONNNES EN COURS...</p>
        </div>
        <!-- Formulaire d'ajout d'unité -->
        <div class="add-form">
            <!-- Selecteur d'unité -->
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
            <input id="input_unit_cost" class="add" type="number" disabled>
            <!-- Selecteur d'arme -->
            <select id="select_weapon" name="select_weapon"></select>
            <input id="input_weapon_cost" class="add" type="number" disabled>
            <!-- Selecteur d'armure -->
            <select id="select_armor" name="select_armor"></select>
            <input id="input_armor_cost" class="add" type="number" disabled>
            <!-- Selecteur de nombre d'unités -->
            <label for="input_unit_multiply">Entrez le nombre d'unité souhaitée</label>
            <input id="input_unit_multiply" type="number" value="1">
            <input id="input_calculator" type="number" disabled>

            <button id="add_button">Ajouter</button>
        </div>

        <!-- Liste d'armée -->
        <div id="army_list">
            <?php while($row = $result->fetch_assoc()) {?>
                <div class="container_unit">
                    <div class="unit">
                        <input id="unit_id" type="hidden" value="<?php echo $row['id_content'];?>">
                        <div><?php echo $row['unit']; ?></div>
                        <div><?php echo $row['weapon']; ?></div>
                        <div><?php echo $row['armor']; ?></div>
                        <div><?php echo $row['amount']; ?></div>
                        <input class="total" value="<?php echo $row['cost']; ?>"/>
                        <a href="#" class="remove_unit">Delete</a>
                    </div>
                </div>
            <?php }?>
        </div>

        <!-- Total -->
        <label for="total_army">Total :</label>
        <input id="total_army" type="number">
    </div>
    <!-- FIN: Calculateur -->
    <?php }?>
</body>

<!-- Post-Chargement des scripts pour éviter de ralentir l'affiche de la page -->
<script src="../jquery-3.5.1.js"></script>
<script type="text/javascript" src="../post.js"></script>

</html>