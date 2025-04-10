<?php 
    //ajoute un collaborateurs
    function addCollaborator($connexion_bdd, $nom, $prenom, $contactListe, $liensContact, $avatar) {
        $requete = "INSERT INTO collaborators (nom, prenom, contactListe, liensContact, lienMedia) VALUES (?, ?, ?, ?, ?)";
                // var_dump($_POST, $mediasPath);
                $error_msg = "success";
                if ($stmt = $connexion_bdd->prepare($requete)) {
                    // Liaison des paramètres avec les valeurs
                    $stmt->bind_param("sssss", $nom, $prenom, $contactListe, $liensContact, $avatar);

                    // Exécution de la requête
                    if ($stmt->execute()) {
                        echo "<p class='text-green-500 text-lg font-semibold'>Média ajouté avec succès !</p> <a href='./' class='text-red-500'>Retour</a></div>";
                    } else {
                         "Erreur lors de l'ajout du media.";
                        $error_msg = "<p class='text-red-500 text-sm mt-2'>Erreur : " . $error_msg . "</p>";
                    }

                    // Fermeture de la requête préparée
                    $stmt->close();
                } else {
                    $error_msg = "Erreur lors de la préparation de la requête.";
                    $error_msg =  "<p class='text-red-500 text-sm mt-2'>Erreur : " . $error_msg . "</p>";
                }
                return $error_msg;
    }
?>