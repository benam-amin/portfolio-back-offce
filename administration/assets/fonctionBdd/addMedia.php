<?php 
    function addMedia($connexion_bdd, $titre, $label, $idCategories, $mediasPath, $alt) {
        $requete = "INSERT INTO medias (titre, label, idCategories, lien, alt) VALUES (?, ?, ?, ?, ?)";
                // var_dump($_POST, $mediasPath);

                if ($stmt = $connexion_bdd->prepare($requete)) {
                    // Liaison des paramètres avec les valeurs
                    $stmt->bind_param("sssss", $titre, $label, $idCategories, $mediasPath, $alt);

                    // Exécution de la requête
                    if ($stmt->execute()) {
                        echo "<p class='text-green-500 text-lg font-semibold'>Média ajouté avec succès !</p> <a href='./' class='text-red-500'>Retour</a></div>";
                    } else {
                        $error_msg = "Erreur lors de l'ajout du media.";
                        echo "<p class='text-red-500 text-sm mt-2'>Erreur : " . $error_msg . "</p>";
                    }

                    // Fermeture de la requête préparée
                    $stmt->close();
                    return "success";
                } else {
                    $error_msg = "Erreur lors de la préparation de la requête.";
                    echo "<p class='text-red-500 text-sm mt-2'>Erreur : " . $error_msg . "</p>";
                    return "error";
                }
    }
?>