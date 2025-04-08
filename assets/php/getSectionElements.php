<?php
function getSectionElements($connexion_bdd, $section) {
    // Sécurisation de l'entrée pour éviter les injections SQL
    $section = mysqli_real_escape_string($connexion_bdd, $section);

    // Requête SQL sécurisée
    $requete = "SELECT * FROM contenu WHERE section = '$section' LIMIT 1"; // Ajout du LIMIT 1 pour éviter plusieurs résultats
    $resultat = mysqli_query($connexion_bdd, $requete);

    // Vérification de l'exécution de la requête
    if ($resultat) {
        // Retourne le tableau associatif si une ligne est trouvée
        return mysqli_fetch_assoc($resultat);
    } else {
        // Si la requête échoue, retourne false ou un tableau vide
        return false;
    }
}
?>
