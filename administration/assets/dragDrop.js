document.addEventListener("DOMContentLoaded", function () {
    const dropZone = document.getElementById("dropZone");
    const fileInput = document.getElementById("fileInput");
    const preview = document.getElementById("preview");

    dropZone.addEventListener("dragover", (e) => {
        e.preventDefault();
        dropZone.classList.add("bg-gray-200");
    });

    dropZone.addEventListener("dragleave", () => {
        dropZone.classList.remove("bg-gray-200");
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
        if (file.type.startsWith("image/")) {
            const reader = new FileReader();
            reader.onload = () => {
                preview.src = reader.result;
                preview.classList.remove("hidden");
            };
            reader.readAsDataURL(file);
        }
    }
});
