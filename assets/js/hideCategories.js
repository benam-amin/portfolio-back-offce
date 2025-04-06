document.addEventListener("DOMContentLoaded", () => {
	const toggleBtn = document.getElementById("toggleCategories");
	const menu = document.getElementById("categoriesMenu");

	toggleBtn?.addEventListener("click", () => {
		menu.classList.toggle("active");
	});
});
