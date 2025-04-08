<?php 
function afficherHeaderSection($contenu) { ?>
        <h2><?php echo htmlspecialchars($contenu['titre']); ?></h2>
        <p><?php echo htmlspecialchars($contenu['sousTitre']); ?></p>
<?php } ?>