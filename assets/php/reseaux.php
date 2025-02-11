<?php

    function displayNetworks($connexion_bdd) {
        // Requête SQL pour récupérer tous les réseaux
        $requete_reseaux = "SELECT * FROM reseaux;";
        
        // Exécution de la requête
        $resultat_reseaux = mysqli_query($connexion_bdd, $requete_reseaux);

        // Vérification si la requête a réussi et si des résultats existent
        if ($resultat_reseaux && mysqli_num_rows($resultat_reseaux) > 0) {  
            echo '<ul class="icons">';
            
            // Parcours des résultats sous forme associative
            while ($reseau = mysqli_fetch_assoc($resultat_reseaux)) { 
                    if ($reseau["visibilite"] == 1) {
                    echo '<li>';
                    
                    // Génération du lien avec protection contre les failles XSS
                    echo '<a href="' . htmlspecialchars($reseau['lien']) . '" target="_blank" class="icon brands alt fa-' . htmlspecialchars($reseau['classIcon']) . '">';
                    
                    // Affichage du nom du réseau avec la première lettre en majuscule
                    echo '<span class="label">' . ucfirst(htmlspecialchars($reseau['nom'])) . '</span>';
                    
                    echo '</a>';
                    echo '</li>';
                }
            }
            
            echo '</ul>';
        } else {
            // Message alternatif si aucun réseau n'est trouvé
            echo '<p>Aucun réseau social disponible pour le moment.</p>';
        }
    }




?>