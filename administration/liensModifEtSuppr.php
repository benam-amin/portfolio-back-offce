<?php 
    //Génération de lien à partir de l'id passé en argument dans la fonction  
    function genererLienModif($id) {
        return "modifier.php?id=$id";
    }
    function genererLienSupprimer($id) {
        return "supprimer.php?id=$id";
    }
?>