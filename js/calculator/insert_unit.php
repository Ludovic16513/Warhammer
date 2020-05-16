<?php

try { //Test erreur.

    /* Connexion via le fichier bd.
    * new mysqli */
    include 'db.php';

    /* Valeur de tous les [select].
    */
    $amount = $db->real_escape_string($_POST['insert_amount']);
    $id = $db->real_escape_string($_POST['insert_id']);
    $armor = $db->real_escape_string($_POST['insert_armor']);
    $weapon = $db->real_escape_string($_POST['insert_weapon']);
    $unit = $db->real_escape_string($_POST['insert_unit']);
    $cost = $db->real_escape_string($_POST['insert_cost']);


    /* Requête bd avec jointure de la table associative,
     * permet d'obtenir : unité -> armure. */
    $sql = "INSERT INTO sheetcontent (id_sheet, weapon, armor, unit, cost, amount) VALUES ('$id','$weapon','$armor','$unit','$cost','$amount');";

    $result = $db->query($sql); //Lancement de la requête bd.

    echo $db->insert_id; //Permet d'obtenir l'id insérée.

} catch (Exception $e) { // Gestion des erreurs
    echo $e;
}