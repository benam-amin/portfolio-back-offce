document.addEventListener("DOMContentLoaded", function () {
    const dropZone = document.getElementById("dropZone");
    const fileInput = document.getElementById("fileInput");
    const preview = document.getElementById("preview");
    const errorMessage = document.getElementById("errorMessage"); // Affichage d'erreur

    dropZone.addEventListener("dragover", (e) => {
        e.preventDefault();
        dropZone.classList.add("bg-gray-200");
        dropZone.style.cursor = "pointer"; // Change le curseur au survol
    });

    dropZone.addEventListener("dragleave", () => {
        dropZone.classList.remove("bg-gray-200");
        dropZone.style.cursor = "default"; // Restaure le curseur
    });

    dropZone.addEventListener("drop", (e) => {
        e.preventDefault();
        dropZone.classList.remove("bg-gray-200");

        const file = e.dataTransfer.files[0];
        if (file) {
            fileInput.files = e.dataTransfer.files;
            handleFilePreview(file);
        }
    });

    dropZone.addEventListener("click", () => fileInput.click());

    fileInput.addEventListener("change", () => {
        const file = fileInput.files[0];
        if (file) {
            handleFilePreview(file);
        }
    });

    function handleFilePreview(file) {
        // Vérification du type de fichier
        if (!file.type.startsWith("image/")) {
            showError("Seules les images sont autorisées.");
            return;
        }

        const reader = new FileReader();
        reader.onload = () => {
            preview.src = reader.result;
            preview.classList.remove("hidden");
            if (errorMessage) errorMessage.classList.add("hidden"); // Masquer le message d'erreur
        };
        reader.readAsDataURL(file);
    }

    function showError(message) {
        if (errorMessage) {
            errorMessage.textContent = message;
            errorMessage.classList.remove("hidden");
        }
    }
});
