<?php 
    function contactEnvoiMail($connexion_bdd,$nom, $prenom, $email, $objet, $contenu, $copy){
        if (empty($prenom) || empty($nom) || empty($email) || empty($objet) || empty($contenu)){
            return ["error" => "Veuillez remplir tous les champs obligatoires."];
        }
        else if(!filter_var($email, FILTER_VALIDATE_EMAIL)){
            return ["error" => "Veuillez entrer un email valide"];
        }
        else{
            $envoiBddResult = envoicontenuBdd($connexion_bdd, $nom, $prenom, $email, $objet ,$contenu);
            if (isset($envoiBddResult["error"])){  return ["error" => "Erreur lors de l'envoi du message"];} 
            
            $envoi = "benamaouche.amin@gmail.com";
            $sujet = "[$objet] $nom $prenom";
            $headers = "Reply-To: $email" . "\r\n" .
            "FROM: $nom $prenom <$email>" . "\r\n" .
            "cc:$email";

            isset($copy) ? mail($envoi, $sujet, $contenu, $headers) : ''; 
            return ["success" => "contenu envoyé avec succès !"];
        }
    }
    function envoicontenuBdd($connexion_bdd, $nom, $prenom, $email, $objet, $contenu) {
        // Créer une instance de DateTimeImmutable
        $date = new DateTimeImmutable();
    
        // Formater la date au format 'Y-m-d H:i:s' pour l'insertion
        $date_formatte = $date->format('Y-m-d H:i:s');
    
        // Préparer la requête SQL pour éviter les injections SQL
        $requete_preparee = $connexion_bdd->prepare("
            INSERT INTO message (nom, prenom, mail, objet, contenu, dateEnvoi) 
            VALUES (?, ?, ?, ?, ?, ?)
        ");
    
        // Vérifier si la préparation de la requête a réussi
        if ($requete_preparee === false) {
            die("Erreur de préparation de la requête : " . $connexion_bdd->error);
        }
    
        // Lier les paramètres aux valeurs
        $requete_preparee->bind_param("ssssss", $nom, $prenom, $email, $objet, $contenu, $date_formatte);
    
        // Exécuter la requête
        $resultat = $requete_preparee->execute();
    
        // Vérifier si l'exécution a réussi
        if ($resultat) {
            // Retourner un succès
            return ["success" => "Message envoyé avec succès"];
        } else {
            // Retourner l'erreur
            return ["error" => "Erreur lors de l'envoi du message : " . $requete_preparee->error];
        }
    
        // Fermer la requête préparée
        $requete_preparee->close();
    }
    
?>