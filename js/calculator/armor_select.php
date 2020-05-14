<?php


try { //Test erreur.

    /* Connexion via le fichier bd.
    * new mysqli */
    include 'db.php';

    /* Valeur du [select] -> [unit]
    * ex : Guerriers */
    $unit = $db->real_escape_string($_POST['select_unit']);

    /* Requête bd avec jointure de la table associative.
     * Permet d'obtenir : unité -> armure. */
    $sql = "SELECT armor
    FROM unit
    INNER JOIN assoc
    ON unit.id = assoc.id_unit
    INNER JOIN armor
    ON assoc.id_armor = armor.id
    WHERE unit.name = '$unit'";

    $result = $db->query($sql); //Lancement de la requête bd.

   /* Boucle le résultat dans un tableau associatif.
    * Puis mise en forme dans un autre tableau pour obtenir du json fonctionnel. */
    while ($row = $result->fetch_assoc()) {
        $armor[] = $row;
    }

    echo json_encode($armor, JSON_NUMERIC_CHECK); //Encodage en json.



} catch (Exception $e) { // Gestion des erreurs
    echo $e;
}






