<?php
include 'db.php';


$title = $_POST['title'];
$id_sheet_prim = $_POST['id_sheet_prim'];

$sql = "UPDATE `sheet` SET `title` = '$title' WHERE `id_sheet_prim`= $id_sheet_prim ";

$db->query($sql);

