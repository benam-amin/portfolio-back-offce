<?php $page_courante = "navigation"; ?>
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
    <?php require_once('../header-admin.php'); //récupération du header
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
                        <tr class="bg-gray-800 text-white">
                            <th class="px-6 py-3 border">Ancre</th>
                            <th class="px-6 py-3 border">Contenu</th>
                            <th class="px-6 py-3 border">Visibilité</th>
                            <th class="px-6 py-3 border">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                            if(mysqli_num_rows($resultat)> 0) { //la variable résultat se trouve dans le fichier requete.php
                                while($entite = mysqli_fetch_assoc($resultat)) {//on utilise la variable $entite afin de stocker le tableau associatif retourné par mysqli_fetch_assoc
                                    //affichage du contenu de la table
                                    echo "<tr class='text-center border-b'>"; 
                                    echo "<td class='px-6 py-3'>{$entite["ancre"]}</td>";
                                    echo "<td class='px-6 py-3'>{$entite["contenu"]}</td>";
                                    visibiliteAffichage($entite);
                                    echo "<td class='px-6 py-3'>
                                            <a href='".genererLienModif($entite["id"])."'><button class='bg-blue-500 text-white px-3 py-1 rounded hover:bg-blue-700'><i class='fas fa-edit'></i></button></a>
                                            <a href='".genererLienSupprimer($entite["id"])."'><button class='bg-red-500 text-white px-3 py-1 rounded hover:bg-red-700'><i class='fas fa-trash'></i></button></a>
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
