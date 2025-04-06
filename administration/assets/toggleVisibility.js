function toggleVisibility(button, table) {
    const id = button.getAttribute('data-id');
    const icon = document.getElementById(`icon-${id}`);
  
    // Vérifier si l'élément est actuellement visible ou masqué
    const isVisible = icon.classList.contains('fa-eye');
  
    // Basculer l'icône
    if (isVisible) {
        icon.classList.replace('fa-eye', 'fa-eye-slash');
    } else {
        icon.classList.replace('fa-eye-slash', 'fa-eye');
    }

    // Effectuer la requête AJAX pour mettre à jour la visibilité dans la base de données
    const xhr = new XMLHttpRequest();
    xhr.open('POST', '../assets/fonctionBdd/mettre_a_jour_visibilite.php', true);
    xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
    xhr.onreadystatechange = function() {
        if (xhr.readyState == 4 && xhr.status == 200) {
            // Optionnel : afficher un message de succès ou d'erreur
            console.log('Visibilité mise à jour');
        }
    };
    xhr.send('id=' + id + '&visibilite=' + (isVisible ? 0 : 1) + '&table=' + table); // Envoie du nom de la table
}
