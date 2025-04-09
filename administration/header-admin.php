<?php
    require_once('../../assets/php/connexion_bdd.php'); //connexion à la base de données
    require_once('../assets/liensModifEtSuppr.php'); //on récupère les fonctions de génération de lien
    require_once('../assets/functionAffichage.php'); //on récupère les fonctions de génération de lien
    require_once('../assets/requete.php'); //on récupère les requête pour l'affichage lors des modification et de la suppression
    require_once('../assets/gestionUpload.php'); //récupère la gestion des formulaire d'upload
    require_once('../assets/inputUpload.php'); //permet de générer le champ upload du formulaire
    require_once('../assets/verificationConnexion.php'); //verifie si la connexion est effectuée via les sessions
    require_once('../assets/deconnexion.php'); //verifie si la connexion est effectuée via les sessions
    if (isset($_GET['action']) && $_GET['action'] === 'click_button') {
        // Déconnexion
        deconnexion();
    }
    $liste_entrees_menu = [ //initie les liens de navigation avec un tableau multidimensionnel stockant des tableaux associatifs
        ["lien" => ".././contenu", "nom" => "CONTENU", "clef" => "contenu"],
        ["lien" => ".././projects", "nom" => "PROJETS", "clef" => "projects"],
        ["lien" => ".././medias", "nom" => "MÉDIAS", "clef" => "medias"],
        ["lien" => ".././categories/", "nom" => "CATÉGORIES", "clef" => "categories"],
        ["lien" => ".././collaborators/", "nom" => "COLLABORATEURS", "clef" => "collaborators"],
        ["lien" => ".././outils/", "nom" => "OUTILS", "clef" => "outils"],
        ["lien" => ".././socials/", "nom" => "RÉSEAUX SOCIAUX", "clef" => "reseaux"],
        ["lien" => ".././navigation/", "nom" => "NAVIGATION", "clef" => "navigation"],
        ["lien" => "../.././", "nom" => "VOIR LE SITE", "clef" => "site"]
    ];
?>

<header id="header" class="bg-gray-900 shadow-lg">
    <div class="container mx-auto mx-2 py-4 flex justify-around items-center">
        <nav id="nav">
            <div class="flex space-x-4">
                <?php foreach ($liste_entrees_menu as $entree_menu): // Boucle pour afficher le menu de navigation à partir du tableau multidimensionnel
                    $is_active = ($page_courante === $entree_menu["clef"]); // Vérifie si la page actuelle correspond à une des pages du tableau
                    $liste_classes = $is_active 
                        ? "text-blue-400 border-b-2 border-blue-400" 
                        : "text-white hover:text-blue-400 hover:border-b-2 hover:border-blue-400";
                    $aria_current_attr = $is_active ? " aria-current='page'" : "";
                    $target = $entree_menu["clef"] == "site" ? 'target="_blank"' : '';
                ?>
                    <a href="<?= htmlspecialchars($entree_menu["lien"])  ?> " <?php echo $target; ?>
                       class="<?= htmlspecialchars($liste_classes) ?> px-3 py-2 font-medium transition duration-300" 
                       <?= $aria_current_attr ?>>
                        <?= htmlspecialchars($entree_menu["nom"]) ?>
                    </a>
                <?php endforeach; ?>
                <a href="?action=click_button" class="font-bold rounded-md bg-red-600 font-medium text-white px-4 py-2 shadow-sm hover:bg-red-700">
                    Se déconnecter
                </a>
            </div>
        </nav>
    </div>
</header>
