<?php $page_courante = "contenu"; ?>
<!DOCTYPE HTML>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Réseaux - Back Office Portfolio</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
</head>
<body class="bg-gray-100 text-gray-900">

    <!-- Header -->
    <?php 
        require_once('../header-admin.php'); //récupération du header
        require_once('../assets/genererColonnesTable.php');
        //les colonnes de la base de données : section, titre sousTitre, description, lienMedia
        $colonnes = array("Section", "Titre", "Sous titre", "Description", "Lien vers le média");
    ?>

    <!-- Section principale -->
    <section class="py-12 px-6">
        <div class="container mx-auto">
            <h1 class="text-3xl font-bold text-center mb-8">Contenu du site</h1>
            
            <!-- Bouton vers les pages de création --> 
            <div class="flex justify-end mb-4">
                <a href="creer.php"
                    class="rounded-md py-2 px-4 text-base font-semibold text-white bg-gray-800 shadow-md hover:bg-gray-400 flex items-center gap-2">
                    <!-- le bouton d'ajout sera présent seulement au préalable, si on ajoute encore du contenu
                     non prévu dans le front office il ne se passera rien -->
                    <i class="fas fa-plus"></i> Ajouter un nouveau contenu 
                </a>
            </div>

            <!-- Tableau du contenu -->
            <div class="overflow-x-auto">
                <table class="min-w-full bg-white shadow-md rounded-lg border">
                    <?php genererColonnesTableau($colonnes); ?>
                    <tbody>
                        <?php
                            if(mysqli_num_rows($resultat) > 0) {
                                while ($entite = mysqli_fetch_assoc($resultat)) {
                                    echo "<tr class='text-center border-b'>";
                                    
                                    // Section
                                    echo "<td class='px-6 py-3'>" . $entite["section"] . "</td>";
                                    
                                    // Titre
                                    echo "<td class='px-6 py-3'>" . $entite["titre"] . "</td>";
                                    
                                    // Sous-titre
                                    echo "<td class='px-6 py-3'>" . $entite["sousTitre"] . "</td>";
                                    
                                    // Description
                                    echo "<td class='px-6 py-3'>" . nl2br($entite["description"]) . "</td>";
                                    
                                    // Lien vers le média
                                    echo "<td class='px-6 py-3'>";
                                    if (!empty($entite["lienMedia"])) {
                                        echo "<a href='../../" . htmlspecialchars($entite["lienMedia"]) . "' target='_blank' class='text-blue-500 underline'>Voir</a>";
                                    } else {
                                        echo "<span class='text-gray-400 italic'>Aucun</span>";
                                    }
                                    echo "</td>";

                                    // Actions
                                    echo "<td class='px-6 py-3'>
                                            <a href='" . genererLienModif($entite["id"]) . "'>
                                                <button class='bg-blue-500 text-white px-3 py-1 rounded hover:bg-blue-700'>
                                                    <i class='fas fa-edit'></i>
                                                </button>
                                            </a>
                                            <button onclick=\"confirmerSuppression({$entite['id']}, 'contenus')\"
                                                class='bg-red-500 text-white px-3 py-1 rounded hover:bg-red-700'>
                                                <i class='fas fa-trash'></i>
                                            </button>
                                        </td>";
                                    echo "</tr>";
                                }
                            }
                        ?>
                    </tbody>
                </table>
            </div>
        </div>
    </section>


    <!-- Footer -->
    <?php require_once('../footer-admin.php'); //récupération du header ?>

</body>
</html>
