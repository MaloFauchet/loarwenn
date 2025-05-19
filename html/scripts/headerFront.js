/**
 * Ajoute un événement au clic sur le burger pour afficher le nav
*/
document.addEventListener('DOMContentLoaded', () => {
    console.log('DOM fully loaded and parsed');
    const burger = document.querySelector('svg'); 
    const nav = document.querySelector('nav'); 

    burger.addEventListener("click", () => {
        console.log('Burger clicked');
        nav.classList.toggle('active');
    });
});