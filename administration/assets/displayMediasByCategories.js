// Lorsque l'utilisateur change de catégorie
document.getElementById('categorie').addEventListener('change', function () {
    const categorieId = this.value;
    const categorieName = this.options[this.selectedIndex].text; // Récupère le nom de la catégorie sélectionnée

    const labelElement = document.getElementById('mediaExistantLabel');
    if (labelElement) {
        labelElement.textContent = `Médias existants pour la catégorie : ${categorieName}`;
    }

    fetch(`../assets/fonctionBdd/getMediasByCategory.php?categorie_id=${categorieId}`)
        .then(response => response.json())
        .then(medias => {
            const mediaList = document.getElementById('mediaExistant');
            const toggleBtn = document.getElementById('toggleMediaBtn');
            const mediaSection = document.getElementById('mediaSection');

            mediaList.innerHTML = ''; // On vide la liste

            // Si aucun média n'est trouvé
            if (medias.length === 0) {
                mediaList.innerHTML = '<p class="text-gray-500">Aucun média trouvé.</p>';
                if (toggleBtn) toggleBtn.classList.add('hidden');
                if (mediaSection) mediaSection.classList.add('hidden');
                return;
            }

            // Pour chaque média, on crée une case radio + vignette
            medias.forEach(media => {
                const mediaItem = document.createElement('div');
                mediaItem.classList.add('mb-2');

                mediaItem.innerHTML = `
                    <label class="inline-flex items-center space-x-2">
                        <input type="radio" name="mediaExistant" value="${media.lien}" class="form-radio text-blue-600">
                        <img src="../../${media.lien}" alt="${media.nom}" class="w-24 h-24 object-cover rounded-md border" />
                    </label>
                `;

                mediaList.appendChild(mediaItem);
            });

            // Afficher le bouton pour basculer l'affichage
            if (toggleBtn) toggleBtn.classList.remove('hidden');
        })
        .catch(error => {
            console.error("Erreur lors de la récupération des médias :", error);
        });
});

// Gestion du bouton d'affichage/masquage des médias
document.getElementById('toggleMediaBtn')?.addEventListener('click', function (e) {
    e.preventDefault(); // Empêche le comportement par défaut du bouton si c'est un <button type="submit">
    const section = document.getElementById('mediaSection');
    if (!section) return;

    const isHidden = section.classList.contains('hidden');
    if (isHidden) {
        section.classList.remove('hidden');
        this.textContent = "Masquer les médias existants";
    } else {
        section.classList.add('hidden');
        this.textContent = "Afficher les médias existants";
    }
});

// Lors du chargement de la page
window.addEventListener('DOMContentLoaded', () => {
    const categorieSelect = document.getElementById('categorie');
    const pageCourante = document.body.dataset.pageCourante;

    // Si on est sur la page 'collaborateur', on sélectionne automatiquement la bonne option
    if (pageCourante === 'collaborateur') {
        for (let i = 0; i < categorieSelect.options.length; i++) {
            if (categorieSelect.options[i].text.toLowerCase() === 'collaborateur') {
                categorieSelect.selectedIndex = i;
                break;
            }
        }
    }

    // Déclenche le chargement des médias au démarrage si une catégorie est sélectionnée
    if (categorieSelect.value) {
        categorieSelect.dispatchEvent(new Event('change'));
    }
});
