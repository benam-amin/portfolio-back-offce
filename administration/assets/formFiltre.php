<form action="" method="get" class="flex items-center gap-4">
    <label for="categorie" class="text-sm font-medium">Filtrer par catégorie :</label>
    <select name="categorie" id="categorie" class="py-2 px-4 border rounded">
        <option value="">Toutes les catégories</option>
        <!-- Affichage du formulaire de filtre -->
        <?php while ($categorie = mysqli_fetch_assoc($resultat_categories)) {
            if($page_courante == "projects") {
                // si la page est une page projet, on enlève les catégorie qui ne correspondent pas aux projets
                $categoriesHorsProjets = ["collaborateur", "contenu", "CV"];
                if(in_array($categorie["nom"], $categoriesHorsProjets)) { 

                }  
                else {
                    //si la catégorie est celle du projet, elle est sélectionnée ?>
                    <option value="<?php echo $categorie['id']; ?>" <?php echo $categorie_filtre == $categorie['id'] ? 'selected' : ''; ?>>
                        <?php echo htmlspecialchars($categorie['nom']); ?>
                    </option>
               <?php }
            } else { 
                //si la catégorie est celle du projet, elle est sélectionnée ?>
            <option value="<?php echo $categorie['id']; ?>" <?php echo $categorie_filtre == $categorie['id'] ? 'selected' : ''; ?>>
                <?php echo htmlspecialchars($categorie['nom']); ?>
            </option>
        <?php } } ?>
    </select>
    <button type="submit" class="py-2 px-4 text-white bg-blue-600 rounded hover:bg-blue-700">Filtrer</button>
</form>