<?php
    $requete = "SELECT * FROM $page_courante;"; //requete pour selectionner l'ensemble des éléments de la table en fonction de la page pour les index de chaque sous dossier catégories
    $resultat = mysqli_query($connexion_bdd, $requete);  //on stocke le resultat de la fonction mysqli query dans une variable
    
    function genererRequeteEtResultat($table, $id,$connexion_bdd) { //permet d'avoir la requête d'affichage en fonction de l'id et de la table afin de renvoyer le résultat 
        $requete_affiche = "SELECT * FROM $table WHERE id = $id"; // requête pour afficher l'élément
        $resultat = mysqli_query($connexion_bdd, $requete_affiche); // exécution de la requête
        return ($resultat);
    } 
?>