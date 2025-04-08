<?php
function afficherHeaderSection($contenu, $class='') { ?>
    <header <?php echo (!empty($class)) ? 'class="' . $class . '"' : ''; ?>>
        <h2><?php echo htmlspecialchars($contenu['titre']); ?></h2>
        <p><?php echo htmlspecialchars($contenu['sousTitre']); ?></p>
    </header>
<?php }

$contenuTest = [
    'titre' => 'Titre de test',
    'sousTitre' => 'Sous-titre de test'
];

afficherHeaderSection($contenuTest, 'major');
