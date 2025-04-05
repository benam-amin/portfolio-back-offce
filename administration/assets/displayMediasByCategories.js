document.getElementById('categorie').addEventListener('change', function () {
    const categorieId = this.value;
    const categorieName = this.options[this.selectedIndex].text; // Récupère le nom de la catégorie choisie

    // Trouver le label avec un identifiant spécifique (par exemple 'mediaExistantLabel')
    const labelElement = document.getElementById('mediaExistantLabel');
    if (labelElement) {
        labelElement.textContent = `Médias existants pour la catégorie : ${categorieName}`;
    }

    fetch(`../assets/fonctionBdd/getMediasByCategory.php?categorie_id=${categorieId}`)
        .then(response => response.json())
        .then(medias => {
            const mediaList = document.getElementById('mediaExistant');
            mediaList.innerHTML = '';

            if (medias.length === 0) {
                mediaList.innerHTML = '<p class="text-gray-500">Aucun média trouvé.</p>';
                return;
            }

            medias.forEach(media => {
                const mediaItem = document.createElement('div');
                mediaItem.classList.add('mb-2');

                mediaItem.innerHTML = `
                    <label class="inline-flex items-center space-x-2">
                        <input type="radio" name="media_existant" value="${media.lien}" class="form-radio text-blue-600">
                        <img src="../${media.lien}" alt="${media.nom}" class="w-24 h-24 object-cover rounded-md border" />
                    </label>
                `;

                mediaList.appendChild(mediaItem);
            });
        })
        .catch(error => {
            console.error("Erreur lors de la récupération des médias :", error);
        });
});

// Déclencher manuellement l'événement de changement de catégorie lors du chargement de la page
window.addEventListener('DOMContentLoaded', (event) => {
    const categorieSelect = document.getElementById('categorie');
    if (categorieSelect.value) {
        categorieSelect.dispatchEvent(new Event('change'));
    }
});
