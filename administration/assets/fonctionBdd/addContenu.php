<?php
function addContenu($link, $section, $titre, $sousTitre, $description, $lienMedia) {
    $requete = "INSERT INTO contenu (section, titre, sousTitre, description, lienMedia)
                VALUES ('$section', '$titre', '$sousTitre', '$description', '$lienMedia');";
    
    $resultat = mysqli_query($link, $requete);

    if ($resultat) {
        echo "<p class='text-green-500 text-lg font-semibold'>Contenu ajouté avec succès !</p> 
              <a href='./' class='text-blue-500 underline'>Retour</a>";
    } else {
        echo "<p class='text-red-500 text-sm mt-2'>Erreur : " . mysqli_error($link) . "</p>";
    }
}
?>