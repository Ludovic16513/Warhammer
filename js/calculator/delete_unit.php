<?php


try {

    /* Connexion via le fichier bd.
    * new mysqli */
    include 'db.php';

    /* Valeur id du contenu unité.
     * ex : 8 */
    $id_delete = $db->real_escape_string($_GET['delete_id']);

    /* Requête bd.
    *  Permet de supprimer un contenu d'unité via l'id*/
    $sql = "DELETE FROM sheetcontent WHERE id_content = $id_delete";

    //Lancement de la requête bd.
    $result = $db->query($sql);

} catch (Exception $e) { // Gestion des erreurs
    echo $e;
}
