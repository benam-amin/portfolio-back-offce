<?php
$page_courante = "medias";
require_once('../header-admin.php'); // Récupération du header et de la connexion à la BDD
require_once('../assets/fonctionBdd/delete.php');
require_once('../assets/fonctionBdd/filtre.php'); // Filtre et vérification de sécurité
require_once('../assets/genererColonnesTable.php');
        $colonnes = array("Image", "Titre", "Label", "Catégorie", "Lien", "Alt");

// Récupérer les paramètres de filtrage
$categorie_filtre = isset($_GET['categorie']) ? mysqli_real_escape_string($connexion_bdd, $_GET['categorie']) : '';
$colonnes = ["medias.id", "medias.titre", "medias.label", "medias.lien", "medias.alt", "categories.nom"];

// Requête SQL pour récupérer les catégories disponibles
$resultat_categories = fetchFilteredData($connexion_bdd, 'categories', ["id", "nom"]);

// Requête SQL pour récupérer les médias avec leur catégorie associée, en filtrant par catégorie si sélectionnée
$resultat = fetchFilteredData($connexion_bdd, 'medias', $colonnes, 'categories.id', $categorie_filtre);
?>


<!DOCTYPE HTML>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Médias - Back Office Portfolio</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
</head>
<body class="bg-gray-100 text-gray-900">

    <!-- Section principale -->
    <section class="py-12 px-6">
        <div class="container mx-auto">
            <h1 class="text-3xl font-bold text-center mb-8">Médias</h1>

            <!-- Formulaire de filtre par catégorie -->
            <div class="flex justify-between mb-4">
                <form action="" method="get" class="flex items-center gap-4">
                    <label for="categorie" class="text-sm font-medium">Filtrer par catégorie :</label>
                    <select name="categorie" id="categorie" class="py-2 px-4 border rounded">
                        <option value="">Toutes les catégories</option>
                        <?php while ($categorie = mysqli_fetch_assoc($resultat_categories)) { ?>
                            <option value="<?php echo $categorie['id']; ?>" <?php echo $categorie_filtre == $categorie['id'] ? 'selected' : ''; ?>>
                                <?php echo htmlspecialchars($categorie['nom']); ?>
                            </option>
                        <?php } ?>
                    </select>
                    <button type="submit" class="py-2 px-4 text-white bg-blue-600 rounded hover:bg-blue-700">Filtrer</button>
                </form>

                <!-- Bouton vers la page d'upload -->
                <a href="creer.php"
                    class="rounded-md py-2 px-4 text-base font-semibold text-white bg-gray-800 shadow-md hover:bg-gray-700 flex items-center gap-2">
                    <i class="fas fa-plus"></i> Upload d'un nouveau média
                </a>
            </div>

            <!-- Tableau des médias -->
            <div class="overflow-x-auto">
                <table class="min-w-full bg-white shadow-md rounded-lg border">
                    <?php genererColonnesTableau($colonnes); ?>
                    <tbody>
                        <?php if (mysqli_num_rows($resultat) > 0) {
                            while ($entite = mysqli_fetch_assoc($resultat)) { ?>
                                <tr class="text-center border-b">
                                    <td class="px-6 py-3">
                                        <?php if (!empty($entite["lien"])) { ?>
                                            <img src="../<?php echo htmlspecialchars($entite["lien"]); ?>" class="h-12 w-12 object-cover mx-auto" alt="<?php echo htmlspecialchars($entite["alt"]); ?>">
                                        <?php } else { ?>
                                            <i class="fa-solid fa-image text-gray-400 text-2xl"></i>
                                        <?php } ?>
                                    </td>
                                    <td class="px-6 py-3"><?php echo htmlspecialchars($entite["titre"]); ?></td>
                                    <td class="px-6 py-3"><?php echo htmlspecialchars($entite["label"]); ?></td>
                                    <td class="px-6 py-3"><?php echo htmlspecialchars($entite["nom"]); ?></td>
                                    <td class="px-6 py-3"><?php echo htmlspecialchars($entite["lien"]); ?></td>
                                    <td class="px-6 py-3"><?php echo htmlspecialchars($entite["alt"]); ?></td>
                                    <td class="px-6 py-3 flex justify-center gap-2">
                                        <a href="modifier.php?id=<?php echo $entite["id"]; ?>" class="bg-blue-500 text-white px-3 py-1 rounded hover:bg-blue-700">
                                            <i class="fas fa-edit"></i>
                                        </a>
                                        <a href="supprimer.php?id=<?php echo $entite["id"]; ?>"
                                            class="bg-red-500 text-white px-3 py-1 rounded hover:bg-red-700">
                                            <i class="fas fa-trash"></i>
                                        </a>
                                    </td>
                                </tr>
                            <?php }
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

    <!-- Footer -->
    <?php require_once('../footer-admin.php'); ?>

</body>
</html>
