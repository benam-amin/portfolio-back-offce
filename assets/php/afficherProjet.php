<?php 
    function afficherProjets($connexion_bdd, $requete) {
        $resultat = mysqli_query($connexion_bdd, $requete);
        while ($entite = mysqli_fetch_assoc($resultat)) {
            ?> 
            <div class="col-4 col-6-xsmall">
                <span class="image fit">
                    <img src="<?php echo $entite["lienMedia"];?>" alt="<?php echo $entite["alt"];?>" />
                </span>
            </div>
        <?php }
    }

?>