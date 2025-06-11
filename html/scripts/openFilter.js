document.addEventListener("DOMContentLoaded", function() {
    const filterButton = document.getElementById("filter");
    const filterContainer = document.getElementsByTagName("aside")[0];
    const overlay = document.querySelector('.modal-overlay');

    if (filterButton && filterContainer && overlay) {
        filterButton.addEventListener("click", function() {
            filterContainer.classList.add("open");
            overlay.classList.add("open");
        });
        overlay.addEventListener("click", function() {
            filterContainer.classList.remove("open");
            overlay.classList.remove("open");
        });
    }
});