<?php 
require_once('../../../assets/php/connexion_bdd.php');
// Vérifier si les données ont été envoyées via AJAX
if (isset($_POST['action']) && $_POST['action'] == 'delete' && isset($_POST['id']) && isset($_POST['table'])) {
    $id = $_POST['id'];
    $table = $_POST['table'];
    
    // Appeler la fonction deleteFromTable pour supprimer l'élément
    echo deleteFromTable($connexion_bdd, $table, $id);
}

// Fonction pour supprimer un élément de la base de données
function deleteFromTable($connexion_bdd, $table, $id) {
    // Vérifier si la table est 'medias'
    if ($table === 'medias') {
        // Récupérer le lien du fichier à partir de la base de données
        $requete_lien = "SELECT lien FROM $table WHERE id = $id";
        $resultat_lien = mysqli_query($connexion_bdd, $requete_lien);

        if ($resultat_lien) {
            $ligne = mysqli_fetch_assoc($resultat_lien);
            $lien = $ligne['lien'];
            $lien = "../../../" . $lien;

            // Vérifier si le fichier existe sur le serveur et le supprimer
            if (file_exists($lien)) {
                unlink($lien);  // Suppression du fichier
            } else {
                $err = "Fichier non trouvé sur le serveur.";
            }
        } else {
            $err =  "Erreur lors de la récupération du lien du fichier.";
        }
    }

    // Supprimer l'élément de la base de données
    $requete_suppr = "DELETE FROM $table WHERE id = $id";
    if (mysqli_query($connexion_bdd, $requete_suppr)) {
        $err =  "L'élément a bien été supprimé !";
    } else {
        $err = "Erreur de suppression de l'élément.";
    }
    return $err;
}


?>