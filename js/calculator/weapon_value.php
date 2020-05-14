<?php

try { //Test erreur.

    /* Connexion via le fichier bd.
    * new mysqli */
    include 'db.php';

    /* Valeur du [select] -> [unit]
    * ex : Guerriers */
    $unit = $db->real_escape_string($_POST['select_unit']);

    /* Valeur du [select] -> [weapon]
    * ex : Arquebuses */
    $weapon = $db->real_escape_string($_POST['select_weapon']);

    /* Requête bd avec jointure de la table associative,
    *  Permet d'obtenir : arme -> coût. */
    $sql = "SELECT weapon_cost
    FROM unit
    INNER JOIN assoc
    ON unit.id = assoc.id_unit
    INNER JOIN weapon
    ON assoc.id_weapon = weapon.id
    WHERE unit.name = '$unit' AND weapon.weapon = '$weapon'";

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