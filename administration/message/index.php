<?php $page_courante = "message"; ?>
<!DOCTYPE HTML>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Navigation - Back Office Portfolio</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
</head>
<body class="bg-gray-100 text-gray-900">

    <!-- Header -->
    <?php 
    require_once('../header-admin.php'); // récupération du header
    require_once('../assets/genererColonnesTable.php');
    
    $colonnes = array("id", "nom", "prenom", "mail", "objet", "contenu", "dateEnvoi");
    ?>

    <!-- Section principale -->
    <section class="py-12 px-6">
        <div class="container mx-auto">
            <h1 class="text-3xl font-bold text-center mb-8">Lien de Navigation</h1>
            
            <!-- Bouton vers les pages de création --> 
            <div class="flex justify-end mb-4">
                <a href="creer.php"
                    class="rounded-md py-2 px-4 text-base font-semibold text-white bg-gray-800 shadow-md hover:bg-gray-400 flex items-center gap-2">
                    <i class="fas fa-plus"></i> Ajouter un nouveau lien de navigation !
                </a>
            </div>

            <!-- Tableau des projets -->
            <div class="overflow-x-auto">
                <table class="min-w-full bg-white shadow-md rounded-lg border">
                    <thead>
                        <tr class="bg-gray-200 text-gray-600">
                            <?php
                            // Affichage des en-têtes de colonnes dynamiquement
                            foreach ($colonnes as $colonne) {
                                echo "<th class='px-6 py-3 text-left'>{$colonne}</th>";
                            }
                            ?>
                            <th class="px-6 py-3">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        if(mysqli_num_rows($resultat) > 0) {
                            while($entite = mysqli_fetch_assoc($resultat)) {
                                echo "<tr class='text-center border-b'>";
                                
                                // Affichage des données dynamiquement pour chaque colonne
                                foreach ($colonnes as $colonne) {
                                    echo "<td class='px-6 py-3'>" . htmlspecialchars($entite[$colonne]) . "</td>";
                                }

                                echo "<td class='px-6 py-3'>
                                        <button 
                                            onclick=\"confirmerSuppression({$entite["id"]}, 'message')\" 
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
    <?php require_once('../footer-admin.php'); // récupération du footer ?>

</body>
</html>
