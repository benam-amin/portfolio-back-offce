<?php 
    //Génération de lien à partir de l'id passé en argument dans la fonction  
    function genererLienModif($id) { //fonction pour générer le lien de modification en fonction de l'id
        return "modifier.php?id=$id";
    }
    function genererLienSupprimer($id) { //fonction pour générer le lien de modification en fonction de l'id
        return "supprimer.php?id=$id";
    }
?>