<?php 
    function visibiliteAffichage($entite) {
        if ($entite['visibilite'] == 1) { //vérifie la valeur de la colonne visibilité pour l'entite actuelle
            echo "<td class='px-6 py-3'>Visible</td>";
        } else {
            echo "<td class='px-6 py-3'>Masqué</td>";
        }
    }
?>