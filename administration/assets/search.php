<?php 
    // Fonction réutilisable pour la recherche dans une table donnée avec gestion des types de données
    function rechercherDansTable($connexion_bdd, $table, $colonnes, $search) {
        $condition_search = '';
        if ($search) {
            $search = mysqli_real_escape_string($connexion_bdd, $search);
            $conditions = [];
            foreach ($colonnes as $colonne) {
                // Vérifier si la colonne est numérique
                $query_column_type = "SELECT DATA_TYPE FROM INFORMATION_SCHEMA.COLUMNS WHERE TABLE_NAME = '$table' AND COLUMN_NAME = '$colonne'";
                $result_column_type = mysqli_query($connexion_bdd, $query_column_type);
                $column_type = mysqli_fetch_assoc($result_column_type)['DATA_TYPE'];

                // Si la colonne est de type numérique (INT, DECIMAL, etc.)
                if (in_array($column_type, ['int', 'decimal', 'float', 'double'])) {
                    $conditions[] = "$colonne = '$search'";  // Recherche exacte pour les colonnes numériques
                } else {
                    // Si la colonne est de type texte, utiliser LIKE
                    $conditions[] = "$colonne LIKE '%$search%'";
                }
            }
            // Ajouter toutes les conditions
            $condition_search = "AND (" . implode(" OR ", $conditions) . ")";
        }

        // Requête de base
        $query = "SELECT * FROM $table WHERE 1=1 $condition_search";
        return mysqli_query($connexion_bdd, $query);
    }
?>