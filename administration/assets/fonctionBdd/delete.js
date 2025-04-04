function confirmerSuppression(id, table) {
    if (confirm("Êtes-vous sûr de vouloir supprimer cet élément ?")) {
        let xhr = new XMLHttpRequest();
        xhr.open("POST", "../assets/fonctionBdd/delete.php", true);
        xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
        
        xhr.onreadystatechange = function () {
            if (xhr.readyState === 4 && xhr.status === 200) {
                // Affiche la réponse du serveur
                alert(xhr.responseText);  // Affiche le message retourné par PHP
                location.reload();  // Recharge la page pour mettre à jour l'affichage
            }
        };
        
        // Envoie les données
        xhr.send("action=delete&id=" + id + "&table=" + table);
    }
}
