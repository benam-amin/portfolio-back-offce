<?php
    function getSectionElements($connexion_bdd, $section) {
        $requete = "SELECT * FROM contenu WHERE section = '$section';";
        $resultat = mysqli_query($connexion_bdd, $requete);
        //retourne le tableau associatif pour la section
        return mysqli_fetch_assoc($resultat);
    }


?>