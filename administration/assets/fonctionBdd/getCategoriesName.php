<?php 
    function getCategoriesName($connexion_bdd, $categorieId) {
        $requeteCategorieNom = "SELECT nom FROM categories WHERE id = $categorieId;";
        $resultatCategorieNom = mysqli_query($connexion_bdd, $requeteCategorieNom);
        if ($resultatCategorieNom && $categorieNom = mysqli_fetch_assoc($resultatCategorieNom)) {
            $categorieNom = $categorieNom['nom'];
        } else {
            $error_msg = "Catégorie invalide.";
            echo "<p class='text-red-500 text-sm mt-2'>Erreur : " . $error_msg . "</p>";
            exit();
        }
        return $categorieNom;
    }
?>