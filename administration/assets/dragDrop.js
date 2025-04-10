document.addEventListener("DOMContentLoaded", function () {
    // Sélection des éléments du DOM
    const dropZone = document.getElementById("dropZone"); // Zone de dépôt des fichiers
    const fileInput = document.getElementById("fileInput"); // Champ de saisie pour les fichiers
    const previewContainer = document.getElementById("previewContainer"); // Conteneur pour la prévisualisation
    const previewImage = document.getElementById("previewImage"); // Élément pour afficher l'image
    const errorMessage = document.getElementById("errorMessage"); // Message d'erreur

    // Gestion de l'événement "dragover" pour la zone de dépôt
    dropZone.addEventListener("dragover", (e) => {
        e.preventDefault(); // Empêche l'action par défaut (par exemple, ouvrir le fichier dans le navigateur)
        dropZone.classList.add("bg-gray-200"); // Ajoute un fond gris lors du survol
        dropZone.style.cursor = "pointer"; // Change le curseur pour indiquer une zone cliquable
    });

    // Gestion de l'événement "dragleave" pour la zone de dépôt
    dropZone.addEventListener("dragleave", () => {
        dropZone.classList.remove("bg-gray-200"); // Retire le fond gris lorsque l'élément n'est plus survolé
        dropZone.style.cursor = "default"; // Restaure le curseur par défaut
    });

    // Gestion de l'événement "drop" pour la zone de dépôt
    dropZone.addEventListener("drop", (e) => {
        e.preventDefault(); // Empêche l'action par défaut du navigateur (ouvrir le fichier)
        dropZone.classList.remove("bg-gray-200"); // Retire le fond gris

        const file = e.dataTransfer.files[0]; // Récupère le premier fichier déposé
        if (file) {
            fileInput.files = e.dataTransfer.files; // Remplace les fichiers du champ de saisie par les fichiers déposés
            handleFilePreview(file); // Appelle la fonction pour afficher l'aperçu du fichier
        }
    });

    // Gestion du clic sur la zone de dépôt pour déclencher la sélection de fichier
    dropZone.addEventListener("click", () => fileInput.click());

    // Gestion de l'événement "change" pour le champ de saisie de fichier
    fileInput.addEventListener("change", () => {
        const file = fileInput.files[0]; // Récupère le fichier sélectionné
        if (file) {
            handleFilePreview(file); // Appelle la fonction pour afficher l'aperçu du fichier
        }
    });

    // Fonction pour gérer l'aperçu du fichier
    function handleFilePreview(file) {
        // Vérifie si le fichier est une image ou un PDF
        if (
            !file.type.startsWith("image/") && // Si ce n'est pas une image
            file.type !== "application/pdf" // et ce n'est pas un PDF
        ) {
            showError("Seules les images et les fichiers PDF sont autorisés."); // Affiche un message d'erreur
            return;
        }

        const reader = new FileReader(); // Crée un objet FileReader pour lire le fichier
        reader.onload = () => {
            clearPreview(); // Efface l'aperçu précédent
        
            if (file.type.startsWith("image/")) { // Si c'est une image
                previewImage.src = reader.result; // Définit la source de l'image
                previewImage.classList.remove("hidden"); // Affiche l'image
                previewContainer.appendChild(previewImage); // ← Problématique ici, l'image est déjà dans le DOM
            } else if (file.type === "application/pdf") { // Si c'est un fichier PDF
                const pdfLink = document.createElement("a"); // Crée un lien pour ouvrir le PDF
                pdfLink.href = reader.result; // Définit le lien du PDF
                pdfLink.textContent = "Voir le PDF"; // Texte du lien
                pdfLink.target = "_blank"; // Ouvre le PDF dans un nouvel onglet
                pdfLink.className = "text-blue-500 underline"; // Style du lien
                previewContainer.appendChild(pdfLink); // Ajoute le lien dans le conteneur
            }
        
            if (errorMessage) errorMessage.classList.add("hidden"); // Cache le message d'erreur
        };        
        reader.readAsDataURL(file); // Lit le fichier comme une URL de données (base64)
    }

    // Fonction pour afficher un message d'erreur
    function showError(message) {
        clearPreview(); // Efface l'aperçu précédent
        if (errorMessage) {
            errorMessage.textContent = message; // Définit le texte de l'erreur
            errorMessage.classList.remove("hidden"); // Affiche le message d'erreur
        }
    }

    // Fonction pour effacer la prévisualisation
    function clearPreview() {
        previewImage.classList.add("hidden"); // Cache l'image
        previewImage.src = ""; // Réinitialise la source de l'image
        previewContainer.innerHTML = ""; // Vide le conteneur de prévisualisation
    }
});
