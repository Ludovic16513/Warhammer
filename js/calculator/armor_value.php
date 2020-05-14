<?php

try { //Test erreur.

    /* Connexion via le fichier bd.
    * new mysqli */
    include 'db.php';

    /* Valeur du [select] -> [unit]
    * ex : Guerriers */
    $unit = $db->real_escape_string($_POST['select_unit']);
    /* Valeur du [select] -> [armor]
    * ex : Armures légères */
    $armor = $db->real_escape_string($_POST['select_armor']);

    /* Requête bd avec jointure de la table associative,
     * permet d'obtenir : armure -> coût. */
    $sql = "SELECT armor_cost
    FROM unit
    INNER JOIN assoc
    ON unit.id = assoc.id_unit
    INNER JOIN armor
    ON assoc.id_armor = armor.id
    WHERE unit.name = '$unit' AND armor.armor = '$armor'";


    $result = $db->query($sql); //Lancement de la requête bd.

    /* Boucle le résultat dans un tableau associatif.
    * Puis mise en forme dans un autre tableau pour obtenir du json fonctionnel. */
    while ($row = $result->fetch_assoc()) {
        $value[] = $row;
    }

    echo json_encode($value, JSON_NUMERIC_CHECK); //Encodage en json.


} catch (Exception $e) { // Gestion des erreurs
    echo $e;
}