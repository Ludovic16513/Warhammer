<?php

try { //Test erreur.

    /* Connexion via le fichier bd.
    * new mysqli */
    include 'db.php';

    /* Valeur du [select] -> [unit]
    * ex : Guerriers */
    $unit = $db->real_escape_string($_POST['select_unit']);

    /* Requête bd avec jointure de la table associative,
     * permet d'obtenir : unité -> coût. */
    $sql = "SELECT cost FROM unit WHERE name = '$unit'";


    $result = $db->query($sql); //Lancement de la requête bd.


    /* Boucle le résultat dans un tableau associatif.
     * Puis mise en forme dans un autre tableau pour obtenir du json fonctionnel. */
    while ($row = $result->fetch_assoc()) {
        $int[] = $row;
    }


    echo json_encode($int, JSON_NUMERIC_CHECK); //Encodage en json.

} catch (Exception $e) { // Gestion des erreurs
    echo $e;
}
