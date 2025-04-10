<?php 
//ajoute une catégorie
    function addCat($link, $nom, $description) {
                $requete = "INSERT INTO categories (nom, description) VALUES ('$nom', '$description');";
                $resultat= mysqli_query($link, $requete); // Exécution de la requête
    }    
?>