<?php 
    function deleteFromTable($connexion_bdd, $table, $id) {
        $requete_suppr = "DELETE FROM $table WHERE id = $id";
            mysqli_query($connexion_bdd, $requete_suppr); //suppression de l'élément de la table réseau
            echo "<div class='text-center text-green-600 font-bold text-xl py-4'>L'élément a bien été supprimé ! <a href='./' class='text-red-500'>Retour</a></div>";
    }

    function messageConfirmationSuppression() {
        return "<div class='text-center text-green-600 font-bold text-xl py-4'>
                Le média a bien été supprimé ! <a href='./' class='text-red-500'>Retour</a>
              </div>";
    }

?>