function changeClassOfCard() {
    const isSmall = window.innerWidth <= 860;

    document.querySelectorAll(".container-nouveautes .card-horizontal, .container-nouveautes .card-vertical-item,.container-nouveautes .card-vertical-item ").forEach(element => {
        const recommended = element.querySelector(".recommended-horizontal, .recommended");

        if (isSmall) {
            // Passage en mode carrousel
            element.classList.remove("card-horizontal");
            element.classList.add("card-vertical-item");

            if (recommended) {
                recommended.classList.remove("recommended-horizontal");
                recommended.classList.add("recommended");
            }
        } else {
            // Retour au mode carte normale
            element.classList.remove("card-vertical-item");
            element.classList.add("card-horizontal");

            if (recommended) {
                recommended.classList.remove("recommended");
                recommended.classList.add("recommended-horizontal");
            }
        }
    });
}

document.addEventListener('DOMContentLoaded', () =>{
    /*new Caroussel(document.querySelector('#carousselAlreadySee'),{
        slidesToScroll:1,
        slidesVisible: 2,
        pagination:true,
        
    })*/
    new Caroussel(document.querySelector('#carousselSelectForYou'),{
        slidesToScroll:2,
        slidesVisible: 2,
        pagination:true,
        infinite:true,
        /*loop:true,*/
    })
    changeClassOfCard()
})

//Lors du resize
window.addEventListener("resize", () => {
    changeClassOfCard()
});
