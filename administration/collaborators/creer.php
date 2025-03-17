<?php 
$page_courante = "collaborators"; 
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Création - Collaborateur</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
</head>
<body class="bg-gray-100 text-gray-900">
    <?php
        require_once('../header-admin.php'); // Récupération du header et de la connexion à la BDD

        $error_msg_collaborators = "";
        $collaboratorsPath = null; // Initialisation de l'avatar
        $error_msg = "";

        // Vérification de la soumission du formulaire
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            
            // Vérification de la connexion à la base de données
            if (!isset($connexion_bdd)) {
                die("Erreur : Connexion à la base de données non établie.");
            }

            // Vérification que les champs obligatoires sont remplis
            if (!empty($_POST["nom"]) && !empty($_POST["prenom"])) {
                
                // Récupération et nettoyage des données du formulaire
                $nom = htmlentities($_POST["nom"]);
                $prenom = htmlentities($_POST["prenom"]);
                
                // Gestion des listes (nettoyage et transformation en chaîne)
                $contactListe = isset($_POST["contactListe"]) ? implode(',', array_map('trim', explode(',', $_POST["contactListe"]))) : '';
                $liens = isset($_POST["liens"]) ? implode(',', array_map('trim', explode(',', $_POST["liens"]))) : '';

                // Gestion de l'upload de l'avatar
                if (!empty($_FILES["collaborators"]["name"])) { // Vérifie si un fichier est bien envoyé
                    $uploadResult = uploadImage("collaborators", "collaborators");
                    
                    if (isset($uploadResult["error"])) {
                        $error_msg_collaborators = $uploadResult["error"];
                    } elseif (isset($uploadResult["success"])) {
                        $collaboratorsPath = $uploadResult["success"]; // Stockage du chemin dans la BDD
                    }
                }

                // Préparation de la requête d'insertion sécurisée
                $requete = "INSERT INTO collaborators (nom, prenom, contactListe, liensContact, avatar) VALUES (?, ?, ?, ?, ?)";
                
                if ($stmt = $connexion_bdd->prepare($requete)) {
                    // Liaison des paramètres avec les valeurs
                    $stmt->bind_param("sssss", $nom, $prenom, $contactListe, $liens, $collaboratorsPath);
                    
                    // Exécution de la requête
                    if ($stmt->execute()) {
                        // Redirection en cas de succès
                        header("Location: ./");
                        exit();
                    } else {
                        $error_msg = "Erreur lors de l'ajout du collaborateur.";
                    }

                    // Fermeture de la requête préparée
                    $stmt->close();
                } else {
                    $error_msg = "Erreur lors de la préparation de la requête.";
                }

            } else {
                // Message d'erreur si un champ est vide
                $error_msg = "Veuillez remplir tous les champs du formulaire.";
            }
        }
    ?>

    <main class="mx-6 md:mx-20">
        <div class="mx-auto max-w-lg py-12">
            <h1 class="text-3xl font-bold text-center mb-8">Ajout d'un nouveau collaborateur</h1>
            
            <div class="w-full bg-white rounded-lg shadow-md p-6 border border-gray-200">
                <form method="POST" action="" enctype="multipart/form-data">
                    <section class="grid gap-6">
                        <div>
                            <label for="nom" class="block text-lg font-medium text-gray-700">Nom</label>
                            <input type="text" placeholder="Nom" name="nom" id="nom" required
                                class="mt-1 block w-full rounded-md py-2 border-gray-300 shadow-sm focus:border-gray-800 focus:ring-gray-800">
                        </div>
                        <div>
                            <label for="prenom" class="block text-lg font-medium text-gray-700">Prénom</label>
                            <input type="text" placeholder="Prénom" name="prenom" id="prenom" required
                                class="mt-1 block w-full rounded-md py-2 border-gray-300 shadow-sm focus:border-gray-800 focus:ring-gray-800">
                        </div>
                        <div>
                            <label for="contactListe" class="block text-lg font-medium text-gray-700">Liste des réseaux du collaborateur</label>
                            <input type="text" placeholder="twitter,github... (séparés d'une virgule sans espace)" name="contactListe" id="contactListe"
                                class="mt-1 block w-full rounded-md py-2 border-gray-300 shadow-sm focus:border-gray-800 focus:ring-gray-800">
                        </div>
                        <div>
                            <label for="liens" class="block text-lg font-medium text-gray-700">Liens des réseaux</label>
                            <input type="text" placeholder="liens des réseaux (séparés d'une virgule sans espace)" name="liens" id="liens"
                                class="mt-1 block w-full rounded-md py-2 border-gray-300 shadow-sm focus:border-gray-800 focus:ring-gray-800">
                        </div>
                        
                        <!-- Upload de l'image -->
                        <div>
                            <?php inputUpload("Photo du Collaborateur", "collaborators", $collaboratorsPath, $error_msg_collaborators); ?>
                            <?php if (!empty($error_msg_collaborators)) { ?>
                                <p class='text-red-500 text-sm mt-2'><?php echo $error_msg_collaborators; ?></p>
                            <?php } ?>
                        </div>
                        
                        <div class="flex gap-4">
                            <button type="submit" class="rounded-md bg-blue-500 py-2 px-4 text-lg font-medium text-white shadow-sm hover:bg-blue-700">Créer</button>
                            <a href="./" class="rounded-md bg-gray-600 py-2 px-4 text-lg font-medium text-white shadow-sm hover:bg-gray-700">Retour</a>
                        </div>
                    </section>
                </form>
            </div>
            
            <?php if (!empty($error_msg)) { ?>
                <section class="mt-4 text-red-500 text-lg font-semibold" role="alert">
                    <p><?php echo $error_msg; ?></p>
                </section>
            <?php } ?>
        </div>
    </main>

    <?php require_once('../footer-admin.php'); ?>
    <script src="../assets/dragDrop.js"></script>
</body>
</html>
