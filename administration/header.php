<?php
    require_once('../../assets/php/connexion_bdd.php'); //connexion à la base de données
    require_once('../liensModifEtSuppr.php'); //on récupère les fonctions de génération de lien
    require_once('../requete.php'); //on récupère les requête pour l'affichage lors des modification et de la suppression
    if (session_status() === PHP_SESSION_NONE) {
        session_start();
    }
    
    // Vérifie si l'utilisateur est connecté, sinon redirige vers la page de connexion
    if (!isset($_SESSION['connected']) || !$_SESSION['connected']) {
        // Enregistre l'URL actuelle dans une variable de session
        $_SESSION['redirect_to'] = $_SERVER['REQUEST_URI'];
        // Redirige vers la page de connexion
        header("Location: ../login.php");
        exit();
    }
    if (isset($_GET['action']) && $_GET['action'] === 'click_button') {
        // Déconnexion
        session_destroy();
        // Redirige vers la page de connexion après la déconnexion
        header("Location: ../login.php");
        
        exit();
    }
    $liste_entrees_menu = [ //initie les liens de navigation avec un tableau multidimensionnel stockant des tableaux associatifs
        ["lien" => ".././projects", "nom" => "PROJETS", "clef" => "projects"],
        ["lien" => ".././categories/", "nom" => "CATÉGORIES", "clef" => "categories"],
        ["lien" => ".././collaborators/", "nom" => "COLLABORATEURS", "clef" => "collaborators"],
        ["lien" => ".././socials/", "nom" => "RÉSEAUX SOCIAUX", "clef" => "socials"],
        ["lien" => "../.././", "nom" => "VISUALISATION", "clef" => "site"]
    ];
?>

<header id="header" class="bg-gray-900 shadow-lg">
    <div class="container mx-auto px-4 py-4 flex justify-between items-center">
        <h1 id="logo" class="text-2xl font-bold text-white">
            <a href="../../index.php" class="hover:text-gray-400 transition duration-300">Benamaouche</a>
        </h1>
        <nav id="nav">
            <div class="flex space-x-4">
                <?php foreach ($liste_entrees_menu as $entree_menu): // Boucle pour afficher le menu de navigation à partir du tableau multidimensionnel
                    $is_active = ($page_courante === $entree_menu["clef"]); // Vérifie si la page actuelle correspond à une des pages du tableau
                    $liste_classes = $is_active 
                        ? "text-blue-400 border-b-2 border-blue-400" 
                        : "text-white hover:text-blue-400 hover:border-b-2 hover:border-blue-400";
                    $aria_current_attr = $is_active ? " aria-current='page'" : "";
                ?>
                    <a href="<?= htmlspecialchars($entree_menu["lien"])  ?>" 
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
