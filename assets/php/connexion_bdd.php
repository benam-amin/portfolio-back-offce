<?php
    require_once('id_bdd.php');//récupération des identifiants de connexion au SGBDR

    $connexion_bdd = mysqli_connect($id_bdd['host'], $id_bdd['username'],$id_bdd['pwd'],$id_bdd['dtb_name']); //connexion à la base de données.

    if ($connexion_bdd -> connect_error) { //test pour vérifier la réussite de la connexion
        die("Connexion échouée : ". mysqli_connect_error());
        exit(); //ne fait pas les instructions plus bas si la connexion a échouée. 
    }
    

?>