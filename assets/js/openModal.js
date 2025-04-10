function openModal(projetId) {
    fetch('projects/projet.php?id=' + projetId)
        .then(response => response.text())
        .then(data => {
            const modal = document.getElementById("customModal");
            const modalBody = document.getElementById("modal-body");
            if (!modal || !modalBody) return;
            modalBody.innerHTML = data;

            // Reset scroll position
            modalBody.scrollTop = 0;

            modal.style.display = "flex";
            setTimeout(() => modal.style.opacity = "1", 10);
        })
        .catch(error => console.error('Erreur de chargement:', error));
}


function closeModal() {
    const modal = document.getElementById("customModal");
    if (!modal) return;

    // Stopper les vidéos YouTube
    const iframes = modal.querySelectorAll("iframe");
    iframes.forEach(iframe => {
        const src = iframe.src;
        iframe.src = src;
    });

    modal.style.opacity = "0";
    setTimeout(() => modal.style.display = "none", 300);
}


const modal = document.getElementById("customModal");
if (modal) {
    modal.addEventListener("click", function(event) {
        if (event.target === this) {
            closeModal();
        }
    });
}

// Rendre openModal global
window.openModal = openModal;

