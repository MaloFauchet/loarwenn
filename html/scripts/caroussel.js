
/**
 * Rajoute la navigation tactile pour le caroussel
 */
class CarousselTouchPlugin {
    constructor(caroussel) {
        caroussel.container.addEventListener('dragstart',(e)=>{e.preventDefault()})
        caroussel.container.addEventListener('mousedown', this.startDrag.bind(this))    
        caroussel.container.addEventListener('touchstart', this.startDrag.bind(this)) 
        window.addEventListener('mousemove',this.drag.bind(this)) 
        window.addEventListener('touchmove',this.drag.bind(this))   
        window.addEventListener('mouseup',this.endDrag.bind(this))
        window.addEventListener('touchend',this.endDrag.bind(this))
        window.addEventListener('touchcancel',this.endDrag.bind(this))

        this.caroussel = caroussel 

    }
    /**
     * 
     * @param {MouseEvent|TouchEvent} e 
     */
    startDrag(e){
        if (e.touches) {
            if ( e.touches.length >1) {
                return   
            }else{

                e = e.touches[0]
            }
        }
        this.origin = {x: e.screenX, y: e.screenY}
        this.width = this.caroussel.containerWidth
        this.caroussel.disableTransition();
    }
    drag(e){
        if (this.origin) {
            let point = e.touches ? e.touches[0] : e
            let translate = {x: point.screenX - this.origin.x, y: point.screenY -this.origin.y }
            if (e.touches && Math.abs(translate.x) > Math.abs(translate.y)) {
                e.preventDefault()
                e.stopPropagation()
                
            }
            let baseTranslate = this.caroussel.currentItem * -100 / this.caroussel.items.length
            this.lastTranslate = translate
            this.caroussel.translate(baseTranslate + 100 * translate.x / this.width)
        }
    }
    /**
     * Fin du déplacement
     */
    endDrag(e){
        if (this.origin && this.lastTranslate) {
            this.caroussel.enableTransition
            if (Math.abs(this.lastTranslate.x / this.caroussel.carousselWidth) > 0.2) {
                //slide gauche
                if (this.lastTranslate.x < 0) {
                    this.caroussel.next()
                }else{
                    this.caroussel.prev()
                }
            }else{
                this.caroussel.goto(this.caroussel.currentItem)
            }
        }
        this.origin = null
    }


}


class Caroussel {


    /**
     * 
     * @param {HTMLElement} element 
     * @param {Object} options 
     * @param {Object} options.slidesToScroll nombres d'élément à faire défiller
     * @param {Object} options.slidesVisible number of elements visbles in the caroussel
     */
    constructor(element,options = {}) {
        this.element = element
        this.options = Object.assign({},{
            slidesToScroll:1,
            slidesVisible: 1,
            loop: false,
            pagination: false,
            navigation:true,
            infinite: false
        },options)
        if (this.options.infinite && this.options.loop) {
            throw new Error("Pas de boucle et d'infini en même temps")
        }
        this.children = [].slice.call(element.children)
        this.isMobile = false
        this.currentItem = 0

        this.root = this.createDivWithClass('caroussel')
        this.container = this.createDivWithClass('caroussel-container')
        this.root.setAttribute('tabindex','0')
        this.root.appendChild(this.container)
        this.moveCallbacks = []
        this.offset = 0
        this.element.appendChild(this.root)
        this.items = this.children.map(child => {
            let item = this.createDivWithClass('caroussel-item')
            item.appendChild(child)
            return item
        });
        if (this.options.infinite) {
            this.offset = this.options.slidesVisible + this.options.slidesToScroll
            if (this.offset > this.children.length) {
                console.error("Vous n'avez pas assez d'élément",element)
            }
            this.items = [
                ...this.items.slice(this.items.length - this.offset).map(item => item.cloneNode(true)),
                ...this.items,
                ...this.items.slice(0, this.offset).map(item => item.cloneNode(true))
            ]
            this.goto( this.offset,false)
        }
        this.items.forEach(item =>this.container.appendChild(item)
    )

        this.setStyle()
        if (this.options.navigation) {
            
            this.createNavigation()
        }
        if (this.options.pagination) {
            
            this.createPagination()
        }


        //évènemnents
        this.moveCallbacks.forEach(cb=>cb(this.currentItem))
        this.onWindowResize()
        window.addEventListener('resize',this.onWindowResize.bind(this))
        this.root.addEventListener('keyup',(e)=>{
            if (e.key === 'ArrowRight' || e.key === 'Rigth') {
                this.next()
            }else if (e.key === 'ArrowLeft' || e.key === 'Left'){
                this.prev()
            }
        })
        if (this.options.infinite) {
            
            this.container.addEventListener('transitionend',this.resetInfinite.bind(this))
        }
         new CarousselTouchPlugin(this);

    }

    createDivWithClass(className){
        let div = document.createElement('div')
        div.setAttribute('class',className)
        return div

    }

    disableTransition(){
        this.container.style.transition ='none'
    }
    enableTransition(){
        this.container.style.transition =''
    }

    setStyle(){
        let ratio = this.items.length / this.slidesVisible
        this.container.style.width = (ratio * 100)+"%"
        this.items.forEach(item => {
            item.style.width = ((100 / this.slidesVisible / ratio)) + "%"

        });
    }

    createNavigation(){
        let nextButton = this.createDivWithClass('caroussel-next')
        let prevButton = this.createDivWithClass('caroussel-prev')
        this.root.appendChild(nextButton)        
        this.root.appendChild(prevButton)
        nextButton.addEventListener('click',this.next.bind(this))
        prevButton.addEventListener('click',this.prev.bind(this))
        if (this.options.loop === true) {
            return
        }
        this.onMove(index => {

            if (index === 0) {
                prevButton.classList.add('caroussel-prev--hidden')
            }else{
                prevButton.classList.remove('caroussel-prev--hidden')

            }
            if (this.items[this.currentItem + this.slidesVisible] === undefined) {
                nextButton.classList.add('caroussel-next--hidden')

            }else{
                nextButton.classList.remove('caroussel-next--hidden')

            }
        })

    }
    /**
     * Créer la pagination du caroussel
     */
    createPagination(){
        let pagination = this.createDivWithClass('caroussel-pagination')
        let buttons = []
        this.root.appendChild(pagination)
        for (let index = 0; index < (this.items.length -2 * this.offset); index= index+this.options.slidesToScroll) {
            let button = this.createDivWithClass('caroussel-pagination-button');
            button.addEventListener('click',()=>this.goto(index + this.offset))
            pagination.appendChild( button)
            buttons.push(button)
        }
        this.onMove(index => {
            let count = this.items.length -2* this.offset
            let activeButton = buttons[Math.floor((index-this.offset)%count / this.options.slidesToScroll)]
            
            if (activeButton) {
                buttons.forEach(
                    button => button.classList.remove('caroussel-pagination-button--active')
                )
                activeButton.classList.add('caroussel-pagination-button--active')
            }
        }

        )
    }


    translate(percent){
        this.container.style.transform = 'translate3d(' + percent + '%,0,0)'

    }

    next(){
        this.goto(this.currentItem + this.slidesToScroll)
    }
    prev(){
        this.goto(this.currentItem - this.slidesToScroll)
    }

    goto(index, animation = true){
        if (index < 0) {
            if (this.options.loop ) {
                index = this.items.length - this.slidesVisible
            }
            else{
                return
            }
        }else if (index >= this.items.length || (this.items[this.currentItem + this.options.slidesVisible] === undefined && index >this.currentItem)) {
            if (this.options.loop ) {
                index =0
            }
            else{
                return
            }
        }
        let translateX = index * (-100 / this.items.length)
        if (animation === false) {
            this.disableTransition()
        }
        this.translate(translateX)
        this.container.offsetHeight // pour éviter que js zap la ligne transition none
        if (animation === false) {
            this.enableTransition()
        }
        this.currentItem = index;
        this.moveCallbacks.forEach(cb =>cb(index))
    }

    resetInfinite(){
        if (this.currentItem <= this.options.slidesToScroll ) {
            this.goto(this.currentItem + (this.items.length - 2 *this.offset),false)
        } else if(this.currentItem >= this.items.length - this.offset ){
            this.goto(this.currentItem - (this.items.length - 2 *this.offset),false)

        }
}

    onMove(cb){
        this.moveCallbacks.push(cb)
    }

    onWindowResize(){
        let mobile = window.innerWidth < 800
        if (mobile !== this.isMobile) {
            this.isMobile = mobile
            this.setStyle()
            this.goto(this.currentItem)
        }
        this.moveCallbacks.forEach(cb=>cb(this.currentItem))

    }

    get slidesToScroll(){
        return this.isMobile ? 1: this.options.slidesToScroll
    }
    get slidesVisible(){
        return this.isMobile ? 1: this.options.slidesVisible
    }

    get containerWidth(){
        return this.container.offsetWidth
    }
    get carousselWidth(){
        return this.root.offsetWidth
    }
}

function changeClassOfCard() {
    const isSmall = window.innerWidth <= 860;

    document.querySelectorAll(".container-nouveautes .card-horizontal, .container-nouveautes .caroussel-item").forEach(element => {
        const recommended = element.querySelector(".recommended-horizontal, .recommended");

        if (isSmall) {
            // Passage en mode carrousel
            element.classList.remove("card-horizontal");
            element.classList.add("caroussel-item");

            if (recommended) {
                recommended.classList.remove("recommended-horizontal");
                recommended.classList.add("recommended");
            }
        } else {
            // Retour au mode carte normale
            element.classList.remove("caroussel-item");
            element.classList.add("card-horizontal");

            if (recommended) {
                recommended.classList.remove("recommended");
                recommended.classList.add("recommended-horizontal");
            }
        }
    });
}

document.addEventListener('DOMContentLoaded',function () {
    new Caroussel(document.querySelector('#caroussel_alreadySee'),{
        slidesToScroll:2,
        slidesVisible: 2,
        pagination:true,
        infinite:true,
    })
    new Caroussel(document.querySelector('#caroussel_selectForYou'),{
        slidesToScroll:2,
        slidesVisible: 2,
        pagination:true,
        infinite:true,
    })
})

//Lors du resize
window.addEventListener("resize", () => {
    changeClassOfCard()
});

window.addEventListener("DOMContentLoaded", () => {
    changeClassOfCard()
});





