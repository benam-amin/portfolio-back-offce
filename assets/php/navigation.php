<?php 
    function displayNavMenu($connexion_bdd, $table) {
        // Requête SQL pour récupérer les colonnes "ancre" et "contenu" de la table "navigation"
        $requete_nav = "SELECT ancre, contenu, visibilite FROM $table;";
        
        // Exécution de la requête
        $resultat_nav = mysqli_query($connexion_bdd, $requete_nav);
    
        // Vérification si la requête a retourné des résultats
        if ($resultat_nav && mysqli_num_rows($resultat_nav) > 0) {
            // Parcours des résultats sous forme associative
            while ($nav = mysqli_fetch_assoc($resultat_nav)) {
                // Affichage des éléments du menu
                if ($nav["visibilite"] == 1) {
                    echo '<li><a class="nav-link scrollto" href="' . htmlspecialchars($nav['ancre']) . '">';
                    echo strtoupper(htmlspecialchars($nav['contenu']));
                    echo '</a></li>';
                }
            }
        } else {
            // Message d'erreur ou affichage alternatif si aucun résultat n'est trouvé
            echo '<li><a class="nav-link scrollto" href="#">Menu indisponible</a></li>';
        }
    }
    

?>