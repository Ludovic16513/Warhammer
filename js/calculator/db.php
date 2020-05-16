<?php

// connection a la bd
$db = new mysqli("localhost","u349200383_NainBlanc ","NainBlanc","u349200383_Calculator");

// message si erreur de connection.
if (mysqli_connect_errno()) {
    printf("Échec de la connexion : %s\n", mysqli_connect_error());
    exit();
}