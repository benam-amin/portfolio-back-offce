<?php $page_courante = "collaborators"; ?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Modification - Collaborateur</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
</head>
<body class="bg-gray-100 text-gray-900">
    <?php 
        require_once('../header-admin.php'); //récupération du header

        require_once('../assets/fonctionBdd/editInit.php'); //récupère les vérifications, les requêtes et l'id de l'élément à modifier

        if ($formulaire_soumis) { 
            if (!empty($_POST["nom"]) && !empty($_POST["prenom"]) && !empty($_POST["contactListe"]) && isset($_POST["visibilite"])) { //vérification de l'entrée des input du formulaire
                $id = $_GET["id"]; //automatique, n'est pas supposé changer
                //on récupère les entrées du formulaire dans des variables
                $nom = htmlentities($_POST["nom"]);
                $prenom = htmlentities($_POST["prenom"]);
                $contactListe = htmlentities($_POST["contactListe"]);
                
                // Si un avatar est uploadé
                $avatar = null;
                if (!empty($_FILES['avatar']['name'])) {
                    $avatar = 'path/to/uploads/' . basename($_FILES['avatar']['name']);
                    move_uploaded_file($_FILES['avatar']['tmp_name'], $avatar);
                }

                // Mettre à jour les liens de contact
                $liens = [];
                if (!empty($_POST['liens_contact'])) {
                    $liens = $_POST['liens_contact']; // Récupérer les liens de contact
                }

                // Requête de mise à jour
                $requete_modif = "UPDATE collaborateurs SET nom = '$nom', prenom = '$prenom', contactListe = '$contactListe', visibilite = $visibilite, avatar = '$avatar' WHERE id = $id;"; //requête de modification
                $resultat_modif = mysqli_query($connexion_bdd, $requete_modif); //résultat
                
                // Ajouter les liens de contact dans la base de données (si nécessaire)
                if (!empty($liens)) {
                    foreach ($liens as $lien) {
                        // Insérer chaque lien dans une table dédiée
                        $requete_lien = "INSERT INTO liens_contact (collaborateur_id, lien) VALUES ($id, '$lien')";
                        mysqli_query($connexion_bdd, $requete_lien);
                    }
                }
                
                //si tout se passe bien, on retourne à la page précédente
                header("Location: ./"); 
                exit();
            } else {
                $error_msg = "Veuillez remplir tous les champs du formulaire."; //on affiche une erreur si certains champs sont vides
            }
        }
    ?>

    <main class="mx-6 md:mx-20">
        <?php if ($entite) { //si il y a bel et bien un collaborateur à modifier ?>
            <div class="mx-auto max-w-lg py-12">
                <h1 class="text-3xl font-bold text-center mb-8">Modification de <?php echo strtoupper($entite['nom']) . ' ' . strtoupper($entite['prenom']); ?></h1>
                
                <div class="w-full bg-white rounded-lg shadow-md p-6 border border-gray-200">
                    <form method="POST" action="" enctype="multipart/form-data">
                        <section class="grid gap-6">
                            <div>
                                <label for="nom" class="block text-lg font-medium text-gray-700">Nom</label>
                                <input type="text" value="<?= htmlspecialchars($entite['nom']); ?>" name="nom" id="nom" 
                                    class="mt-1 block w-full rounded-md py-2 border-gray-300 shadow-sm focus:border-gray-800 focus:ring-gray-800">
                            </div>
                            <div>
                                <label for="prenom" class="block text-lg font-medium text-gray-700">Prénom</label>
                                <input type="text" value="<?= htmlspecialchars($entite['prenom']); ?>" name="prenom" id="prenom" 
                                    class="mt-1 block w-full rounded-md py-2 border-gray-300 shadow-sm focus:border-gray-800 focus:ring-gray-800">
                            </div>
                            <div>
                                <label for="contactListe" class="block text-lg font-medium text-gray-700">Liste des contacts</label>
                                <input type="text" value="<?= htmlspecialchars($entite['contactListe']); ?>" name="contactListe" id="contactListe" 
                                    class="mt-1 block w-full rounded-md py-2 border-gray-300 shadow-sm focus:border-gray-800 focus:ring-gray-800">
                            </div>

                            <div>
                                <label for="avatar" class="block text-lg font-medium text-gray-700">Avatar (optionnel)</label>
                                <input type="file" name="avatar" id="avatar" 
                                    class="mt-1 block w-full rounded-md py-2 border-gray-300 shadow-sm focus:border-gray-800 focus:ring-gray-800">
                            </div>

                            <!-- Ajouter des champs pour les liens de contact -->
                            <div>
                                <label for="liens_contact" class="block text-lg font-medium text-gray-700">Liens de Contact (ex: réseaux sociaux, email, etc.)</label>
                                <div class="space-y-2">
                                    <?php
                                    // Afficher les liens déjà existants dans la base
                                    $requete_liens = "SELECT lien FROM liens_contact WHERE collaborateur_id = " . $entite['id'];
                                    $resultat_liens = mysqli_query($connexion_bdd, $requete_liens);
                                    while ($lien = mysqli_fetch_assoc($resultat_liens)) {
                                        echo '<input type="text" name="liens_contact[]" value="' . htmlspecialchars($lien['lien']) . '" class="mt-1 block w-full rounded-md py-2 border-gray-300 shadow-sm focus:border-gray-800 focus:ring-gray-800">';
                                    }
                                    ?>
                                    <input type="text" name="liens_contact[]" class="mt-1 block w-full rounded-md py-2 border-gray-300 shadow-sm focus:border-gray-800 focus:ring-gray-800" placeholder="Ajouter un nouveau lien...">
                                </div>
                            </div>

                             <div class="flex gap-4">
                                <button type="submit" class="rounded-md py-2 bg-blue-500 py-2 px-4 text-lg font-medium text-white shadow-sm hover:bg-blue-700">Modifier</button>
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
    <?php 
        } 
        require_once('../footer-admin.php'); //récupération du footer
    ?>
</body>
</html>
