<?php
    $requete = "SELECT * FROM `reseaux`;"; //requete pour selectionner l'ensemble des éléments de la table reseaux_sociaux
    $resultat = mysqli_query($connexion_bdd, $requete);  //on stocke le resultat de la fonction mysqli query dans une variable
    
    function genererRequeteEtResultat($table, $id,$connexion_bdd) {
        $requete_affiche = "SELECT * FROM $table WHERE id = $id"; // requête pour afficher l'élément
        $resultat = mysqli_query($connexion_bdd, $requete_affiche); // exécution de la requête
        return ($resultat);
    } 
?>