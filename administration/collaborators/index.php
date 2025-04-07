<?php $page_courante = "collaborators"; ?>
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

        $colonnes = array("Avatar", "Nom", "Prénom", "Contacts");
    ?>

    <!-- Section principale -->
    <section class="py-12 px-6">
        <div class="container mx-auto">
            <h1 class="text-3xl font-bold text-center mb-8">Collaborateurs</h1>
            
            <!-- Bouton vers les pages de création --> 
            <div class="flex justify-end mb-4">
                <a href="creer.php"
                    class="rounded-md py-2 px-4 text-base font-semibold text-white bg-gray-800 shadow-md hover:bg-gray-400 flex items-center gap-2">
                    <i class="fas fa-plus"></i> Ajouter un nouveau collaborateur !
                </a>
            </div>

            <!-- Tableau des projets -->
            <div class="overflow-x-auto">
                <table class="min-w-full bg-white shadow-md rounded-lg border">
                    <?php genererColonnesTableau($colonnes); ?>
                    <tbody>
                        <?php
                            if(mysqli_num_rows($resultat) > 0) {
                                // Fonction d'affichage des icônes des liens
                                require_once('../../assets/php/iconesContactsCollaborateur.php');

                                while ($entite = mysqli_fetch_assoc($resultat)) { // Stockage du tableau associatif
                                    
                                    echo "<tr class='text-center border-b'>";
                                    
                                    // Avatar
                                    echo "<td class='px-6 py-3 text-xl flex items-center justify-center'>";
                                    if (!empty($entite["lienMedia"])) {
                                        echo "<img src='../../" . htmlspecialchars($entite["lienMedia"]) . "' class='h-12 w-12 object-center' alt='Avatar'>";
                                    } else {
                                        echo "<i class='fa-solid fa-user-ninja'></i>";
                                    }
                                    echo "</td>";

                                    // Nom et Prénom
                                    echo "<td class='px-6 py-3'>{$entite["nom"]}</td>";
                                    echo "<td class='px-6 py-3'>{$entite["prenom"]}</td>";
                                    
                                    // Icônes des liens
                                    echo "<td class='px-6 py-3'>";
                                    afficherIconesLiens($entite["contactListe"], $entite["liensContact"]);
                                    echo "</td>";
                                    
                                    // Boutons Modifier et Supprimer avec confirmation
                                    echo "<td class='px-6 py-3'>
                                            <a href='" . genererLienModif($entite["id"]) . "'>
                                                <button class='bg-blue-500 text-white px-3 py-1 rounded hover:bg-blue-700'>
                                                    <i class='fas fa-edit'></i>
                                                </button>
                                            </a>
                                            <button onclick=\"confirmerSuppression({$entite['id']}, 'collaborators')\"
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
