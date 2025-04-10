<?php 
//ajoute un media dans la base de donnée
    function addMedia($connexion_bdd, $titre, $label, $idCategories, $mediasPath, $alt) {
    
        // Requête d'insertion
        $requete = "INSERT INTO medias (titre, label, idCategories, lien, alt) VALUES ('$titre', '$label', '$idCategories', '$mediasPath', '$alt')";
    
        // Affichage pour débogage
        var_dump($_POST, $mediasPath);
    
        // Exécution de la requête
        if (mysqli_query($connexion_bdd, $requete)) {
            echo "<p class='text-green-500 text-lg font-semibold'>Média ajouté avec succès !</p> <a href='./' class='text-red-500'>Retour</a></div>";
        } else {
            $error_msg = "Erreur lors de l'ajout du média.";
            echo "<p class='text-red-500 text-sm mt-2'>Erreur : " . mysqli_error($connexion_bdd) . "</p>";
        }
    
        return "success";
    }
    
?>