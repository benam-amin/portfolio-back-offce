document.addEventListener("DOMContentLoaded", function () {
    const dropZone = document.getElementById("dropZone");
    const fileInput = document.getElementById("fileInput");
    const previewContainer = document.getElementById("previewContainer");
    const previewImage = document.getElementById("previewImage"); // Pour les images
    const errorMessage = document.getElementById("errorMessage");

    dropZone.addEventListener("dragover", (e) => {
        e.preventDefault();
        dropZone.classList.add("bg-gray-200");
        dropZone.style.cursor = "pointer";
    });

    dropZone.addEventListener("dragleave", () => {
        dropZone.classList.remove("bg-gray-200");
        dropZone.style.cursor = "default";
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
        if (
            !file.type.startsWith("image/") &&
            file.type !== "application/pdf"
        ) {
            showError("Seules les images et les fichiers PDF sont autorisés.");
            return;
        }

        const reader = new FileReader();
        reader.onload = () => {
            clearPreview();
        
            if (file.type.startsWith("image/")) {
                previewImage.src = reader.result;
                previewImage.classList.remove("hidden");
                previewContainer.appendChild(previewImage); // ← inutile et problématique
            } else if (file.type === "application/pdf") {
                const pdfLink = document.createElement("a");
                pdfLink.href = reader.result;
                pdfLink.textContent = "Voir le PDF";
                pdfLink.target = "_blank";
                pdfLink.className = "text-blue-500 underline";
                previewContainer.appendChild(pdfLink);
            }
        
            if (errorMessage) errorMessage.classList.add("hidden");
        };        
        reader.readAsDataURL(file);
    }

    function showError(message) {
        clearPreview();
        if (errorMessage) {
            errorMessage.textContent = message;
            errorMessage.classList.remove("hidden");
        }
    }

    function clearPreview() {
        previewImage.classList.add("hidden");
        previewImage.src = "";
        previewContainer.innerHTML = "";
    }
});
