<?php 
    $formulaire_soumis = (!empty($_POST)); //variable stockant un bool => permet de savoir si le formulaire est soumis
    $entree_mise_a_jour = array_key_exists('id', $_GET); // permet de voir s'il y a un id qui est passé dans l'url  
    $entite = null; //initialise la variable à null pour éviter les erreurs
    $error_msg = ""; //initialise le msg dans une chaîne vide dans le cas où il n'y a pas d'erreur

    if ($entree_mise_a_jour) { //s'il y a bien un id à modifier
        $id = mysqli_real_escape_string($connexion_bdd, $_GET["id"]); //se protège des injections sql
        $resultat_affiche = genererRequeteEtResultat($page_courante, $id, $connexion_bdd); //récupère la requête est le résultat d'affichage
        $entite = mysqli_fetch_assoc($resultat_affiche); //stock le retour dans la variable entité
    }

?>