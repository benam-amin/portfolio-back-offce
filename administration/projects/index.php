<?php 
$page_courante = "projects";
require_once('../header-admin.php'); 
require_once('../assets/genererColonnesTable.php');
require_once('../assets/fonctionBdd/filtre.php'); // Importation de la fonction

$colonnes = array("Image", "Titre", "Chapo", "Collaborateurs", "Date", "Catégories", "Description", "Outils", "Lien Vidéo");

// Colonnes à récupérer depuis la base de données
$colonnesBDD = [
    'projects.id', 
    'projects.titre', 
    'projects.chapo', 
    'projects.date', 
    'projects.lienMedia',
    'projects.video',
    'projects.description',
    'projects.outils',
    'categories.nom AS categorie',
    'GROUP_CONCAT(COALESCE(collaborators.nom, "Aucun collaborateur") SEPARATOR ", ") AS collaborateurs' // Agrégation des collaborateurs
];

// Récupérer les paramètres de filtrage
$categorie_filtre = isset($_GET['categorie']) ? mysqli_real_escape_string($connexion_bdd, $_GET['categorie']) : '';

// Requête SQL pour récupérer les catégories disponibles
$resultat_categories = fetchFilteredData($connexion_bdd, 'categories', ["id", "nom"]);

// Récupération des projets avec leurs collaborateurs et catégories
$resultat = fetchFilteredData($connexion_bdd, 'projects', $colonnesBDD, 'categories.id', $categorie_filtre);
?>

<!DOCTYPE HTML>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Projets - Tailwind</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
</head>
<body class="bg-gray-100 text-gray-900">

    <!-- Section principale -->
    <section class="py-12 px-6">
        <div class="container mx-auto">
            <h1 class="text-3xl font-bold text-center mb-8">Nos Projets</h1>
            <div class="flex justify-between mb-4">
                <?php require_once("../assets/formFiltre.php"); ?>

                <!-- Bouton vers la page d'upload -->
                <a href="creer.php"
                    class="rounded-md py-2 px-4 text-base font-semibold text-white bg-gray-800 shadow-md hover:bg-gray-700 flex items-center gap-2">
                    <i class="fas fa-plus"></i> Upload d'un nouveau média
                </a>
            </div>

            <!-- Tableau des projets -->
            <div class="overflow-x-auto">
                <table class="min-w-full bg-white shadow-md rounded-lg border">
                    <?php genererColonnesTableau($colonnes); ?>
                    <tbody>
                        <?php 
                            if(mysqli_num_rows($resultat) > 0) {
                                while ($entite = mysqli_fetch_assoc($resultat)) { ?>
                                    <tr class="border-b">
                                        <td class="px-4 py-2">
                                            <?php if (!empty($entite['lienMedia'])): ?>
                                                <img src="../<?php echo htmlspecialchars($entite['lienMedia']) ?>" alt="Image projet" class="w-16 h-16 rounded-lg">
                                            <?php else: ?>
                                                <!-- Ne rien afficher si l'image n'existe pas ou si l'URL est vide -->
                                            <?php endif; ?>
                                        </td>
                                        <td class="px-4 py-2 font-semibold"><?php echo htmlspecialchars($entite['titre'] ?? ''); ?></td>
                                        <td class="px-4 py-2"><?php echo htmlspecialchars($entite['chapo'] ?? ''); ?></td>
                                        <td class="px-4 py-2"><?php echo htmlspecialchars($entite['collaborateurs'] ?? ''); ?></td>
                                        <td class="px-4 py-2"><?php echo htmlspecialchars($entite['date'] ?? ''); ?></td>
                                        <td class="px-4 py-2"><?php echo htmlspecialchars($entite['categorie'] ?? ''); ?></td>
                                        <td class="px-4 py-2 truncate"><?php echo htmlspecialchars($entite['description'] ?? ''); ?></td>
                                        <td class="px-4 py-2"><?php echo htmlspecialchars($entite['outils'] ?? ''); ?></td>
                                        <td class="px-4 py-2"><?php echo htmlspecialchars($entite['video'] ?? ''); ?></td>
                                        <td class="px-6 py-3 flex justify-center gap-2">
                                            <a href="modifier.php?id=<?php echo $entite["id"]; ?>" class="bg-blue-500 text-white px-3 py-1 rounded hover:bg-blue-700">
                                                <i class="fas fa-edit"></i>
                                            </a>
                                            <button onclick="confirmerSuppression(<?php echo $entite['id']; ?>)"
                                                class="bg-red-500 text-white px-3 py-1 rounded hover:bg-red-700">
                                                <i class="fas fa-trash"></i>
                                            </button>
                                        </td>
                                    </tr>
                                    <?php 
                                }
                            } else { ?>
                                <tr>
                                    <td colspan="7" class="text-center py-4 text-gray-500">Aucun média trouvé.</td>
                                </tr>
                            <?php } ?>
                    </tbody>
                </table>
            </div>
        </div>
    </section>

    <div id="editor"></div>

    <!-- Footer -->
    <?php require_once('../footer-admin.php'); ?>

</body>
</html>
