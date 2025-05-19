
<?php

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="../html/styles/style.css">
</head>
<body class="body_main">
    <header class="front-office-main">
        <video autoplay muted loop id="myVideo" class="video-header">
            <source src="../html/videos/video_accueil.mp4" type="video/mp4">
        </video>
        <div>
            <img src="../html/images/logoBlue.png" alt="logoBlue">
        </div>
        <nav >
            <ul>
                <li><a href="index.php">Accueil</a></li>
                <li><a href="">Offres</a></li>
                <li><a href="">Cartographie</a></li>
            </ul>
        </nav>
        <a href="">
            <svg xmlns="http://www.w3.org/2000/svg" width="32" height="32" fill="currentColor" class="bi bi-person-circle" viewBox="0 0 16 16">
                <path d="M11 6a3 3 0 1 1-6 0 3 3 0 0 1 6 0"/>
                <path fill-rule="evenodd" d="M0 8a8 8 0 1 1 16 0A8 8 0 0 1 0 8m8-7a7 7 0 0 0-5.468 11.37C3.242 11.226 4.805 10 8 10s4.757 1.225 5.468 2.37A7 7 0 0 0 8 1"/>
            </svg>
        </a>
        <div class="sample one">
            <input type="text" name="search" placeholder=" | search">
            <button type="submit" class="btn-search">
                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-search" viewBox="0 0 16 16">
                    <path d="M11.742 10.344a6.5 6.5 0 1 0-1.397 1.398h-.001q.044.06.098.115l3.85 3.85a1 1 0 0 0 1.415-1.414l-3.85-3.85a1 1 0 0 0-.115-.1zM12 6.5a5.5 5.5 0 1 1-11 0 5.5 5.5 0 0 1 11 0"/>
                </svg>
            </button>
        </div>
        <h2 class="welcome-text-fo">Bienvenue sur la PACT</h2>
        <h2 class="discover-text-fo">Découvrez vos vacances</h2>
    </header>    
    <main>
        <h1>Récemment consultés</h1>
        <hr>
        <div class="container-caroussel">
            <div id="caroussel_alreadySee">
                <div>
                    <div class="recommended">
                        <div>
                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-patch-check-fill" viewBox="0 0 16 16">
                                <path d="M10.067.87a2.89 2.89 0 0 0-4.134 0l-.622.638-.89-.011a2.89 2.89 0 0 0-2.924 2.924l.01.89-.636.622a2.89 2.89 0 0 0 0 4.134l.637.622-.011.89a2.89 2.89 0 0 0 2.924 2.924l.89-.01.622.636a2.89 2.89 0 0 0 4.134 0l.622-.637.89.011a2.89 2.89 0 0 0 2.924-2.924l-.01-.89.636-.622a2.89 2.89 0 0 0 0-4.134l-.637-.622.011-.89a2.89 2.89 0 0 0-2.924-2.924l-.89.01zm.287 5.984-3 3a.5.5 0 0 1-.708 0l-1.5-1.5a.5.5 0 1 1 .708-.708L7 8.793l2.646-2.647a.5.5 0 0 1 .708.708"/>
                            </svg>
                            <p >Recommandé</p>
                        </div>
                    </div>
                    
                    <div class="item-image">
                        <img src="../testComposant/Caroussel/Get Away From My Computer ❤ 4K HD Desktop Wallpaper for 4K Ultra HD.jpg" alt="image">
                    </div>
                    <div class="item-body">
                        <div class="item-title">Mon titre 1</div>
                        <div class="item-location">
                            <img src="../html/images/icons/geo-alt-fill.svg" alt="">
                            <p>Lannion</p>
                            <img src="../html/images/icons/telephone.svg" alt="">
                            <p>06 54 69 52 33</p>
                            <p>100-300 €</p>
                        </div>
                        <div class="item-avis">
                            <p>3,7</p>
                            <img src="../html/images/icons/star-fill.svg" alt="">
                            <img src="../html/images/icons/star-fill.svg" alt="">
                            <img src="../html/images/icons/star-fill.svg" alt="">
                            <img src="../html/images/icons/star-fill.svg" alt="">
                            <img src="../html/images/icons/star-fill.svg" alt="">
                            <p>(300 Avis)</p>
                        </div>
                        <div class="item-description"> Ullamco exercitation aute sit dolore consequat elit occaecat ut
                            consequat ex id tempor magna.                     
                        </div>
                    <div class="item-tag">
                        <span>
                            <img src="../html/images/icons/tags-fill.svg" alt="">
                            <p>Aquatique</p>
                        </span>
                        <span>
                            <img src="../html/images/icons/tags-fill.svg" alt="">
                            <p>Aquatique</p>
                        </span>
                    </div>
                </div>
            </div>
            <div >
                <div class="item-image">
                    <img src="../testComposant/Caroussel/Get Away From My Computer ❤ 4K HD Desktop Wallpaper for 4K Ultra HD.jpg" alt="image">
                </div>
                <div class="item-body">
                    <div class="item-title">Mon titre 1</div>
                    <div class="item-location">
                        <img src="../html/images/icons/geo-alt-fill.svg" alt="">
                        <p>Lannion</p>
                        <img src="../html/images/icons/telephone.svg" alt="">
                        <p>06 54 69 52 33</p>
                        <p>100-300 €</p>
                    </div>
                    <div class="item-avis">
                        <p>3,7</p>
                        <img src="../html/images/icons/star-fill.svg" alt="">
                        <img src="../html/images/icons/star-fill.svg" alt="">
                        <img src="../html/images/icons/star-fill.svg" alt="">
                        <img src="../html/images/icons/star-fill.svg" alt="">
                        <img src="../html/images/icons/star-fill.svg" alt="">
                        <p>(300 Avis)</p>
                    </div>
                    <div class="item-description"> Ullamco exercitation aute sit dolore consequat elit occaecat ut
                        consequat ex id tempor magna.                     
                    </div>
                    <div class="item-tag">
                        <span>
                            <img src="../html/images/icons/tags-fill.svg" alt="">
                            <p>Aquatique</p>
                        </span>
                        <span>
                            <img src="../html/images/icons/tags-fill.svg" alt="">
                            <p>Aquatique</p>
                        </span>
                    </div>
                </div>
            </div>
            <div >
                <div class="item-image">
                    <img src="../testComposant/Caroussel/Get Away From My Computer ❤ 4K HD Desktop Wallpaper for 4K Ultra HD.jpg" alt="image">
                </div>
                <div class="item-body">
                    <div class="item-title">Mon titre 1</div>
                    <div class="item-location">
                        <img src="../html/images/icons/geo-alt-fill.svg" alt="">
                        <p>Lannion</p>
                        <img src="../html/images/icons/telephone.svg" alt="">
                        <p>06 54 69 52 33</p>
                        <p>100-300 €</p>
                    </div>
                    <div class="item-avis">
                        <p>3,7</p>
                        <img src="../html/images/icons/star-fill.svg" alt="">
                        <img src="../html/images/icons/star-fill.svg" alt="">
                        <img src="../html/images/icons/star-fill.svg" alt="">
                        <img src="../html/images/icons/star-fill.svg" alt="">
                        <img src="../html/images/icons/star-fill.svg" alt="">
                        <p>(300 Avis)</p>
                    </div>
                    <div class="item-description"> Ullamco exercitation aute sit dolore consequat elit occaecat ut
                        consequat ex id tempor magna.                     
                    </div>
                    <div class="item-tag">
                        <span>
                            <img src="../html/images/icons/tags-fill.svg" alt="">
                            <p>Aquatique</p>
                        </span>
                        <span>
                            <img src="../html/images/icons/tags-fill.svg" alt="">
                            <p>Aquatique</p>
                        </span>
                    </div>
                </div>
            </div>
            <div >
                <div class="item-image">
                    <img src="../testComposant/Caroussel/Get Away From My Computer ❤ 4K HD Desktop Wallpaper for 4K Ultra HD.jpg" alt="image">
                </div>
                <div class="item-body">
                    <div class="item-title">Mon titre 1</div>
                    <div class="item-location">
                        <img src="../html/images/icons/geo-alt-fill.svg" alt="">
                        <p>Lannion</p>
                        <img src="../html/images/icons/telephone.svg" alt="">
                        <p>06 54 69 52 33</p>
                        <p>100-300 €</p>
                    </div>
                    <div class="item-avis">
                        <p>3,7</p>
                        <img src="../html/images/icons/star-fill.svg" alt="">
                        <img src="../html/images/icons/star-fill.svg" alt="">
                        <img src="../html/images/icons/star-fill.svg" alt="">
                        <img src="../html/images/icons/star-fill.svg" alt="">
                        <img src="../html/images/icons/star-fill.svg" alt="">
                        <p>(300 Avis)</p>
                    </div>
                    <div class="item-description"> Ullamco exercitation aute sit dolore consequat elit occaecat ut
                        consequat ex id tempor magna.                     
                    </div>
                    <div class="item-tag">
                        <span>
                            <img src="../html/images/icons/tags-fill.svg" alt="">
                            <p>Aquatique</p>
                        </span>
                        <span>
                            <img src="../html/images/icons/tags-fill.svg" alt="">
                            <p>Aquatique</p>
                        </span>
                    </div>
                </div>
            </div>
            <div >
                <div class="item-image">
                    <img src="../testComposant/Caroussel/Get Away From My Computer ❤ 4K HD Desktop Wallpaper for 4K Ultra HD.jpg" alt="image">
                </div>
                <div class="item-body">
                    <div class="item-title">Mon titre 1</div>
                    <div class="item-location">
                        <img src="../html/images/icons/geo-alt-fill.svg" alt="">
                        <p>Lannion</p>
                        <img src="../html/images/icons/telephone.svg" alt="">
                        <p>06 54 69 52 33</p>
                        <p>100-300 €</p>
                    </div>
                    <div class="item-avis">
                        <p>3,7</p>
                        <img src="../html/images/icons/star-fill.svg" alt="">
                        <img src="../html/images/icons/star-fill.svg" alt="">
                        <img src="../html/images/icons/star-fill.svg" alt="">
                        <img src="../html/images/icons/star-fill.svg" alt="">
                        <img src="../html/images/icons/star-fill.svg" alt="">
                        <p>(300 Avis)</p>
                    </div>
                    <div class="item-description"> Ullamco exercitation aute sit dolore consequat elit occaecat ut
                        consequat ex id tempor magna.                     
                    </div>
                    <div class="item-tag">
                        <span>
                            <img src="../html/images/icons/tags-fill.svg" alt="">
                            <p>Aquatique</p>
                        </span>
                        <span>
                            <img src="../html/images/icons/tags-fill.svg" alt="">
                            <p>Aquatique</p>
                        </span>
                    </div>
                </div>
            </div>
            <div >
                <div class="item-image">
                    <img src="../testComposant/Caroussel/Get Away From My Computer ❤ 4K HD Desktop Wallpaper for 4K Ultra HD.jpg" alt="image">
                </div>
                <div class="item-body">
                    <div class="item-title">Mon titre 1</div>
                    <div class="item-location">
                        <img src="../html/images/icons/geo-alt-fill.svg" alt="">
                        <p>Lannion</p>
                        <img src="../html/images/icons/telephone.svg" alt="">
                        <p>06 54 69 52 33</p>
                        <p>100-300 €</p>
                    </div>
                    <div class="item-avis">
                        <p>3,7</p>
                        <img src="../html/images/icons/star-fill.svg" alt="">
                        <img src="../html/images/icons/star-fill.svg" alt="">
                        <img src="../html/images/icons/star-fill.svg" alt="">
                        <img src="../html/images/icons/star-fill.svg" alt="">
                        <img src="../html/images/icons/star-fill.svg" alt="">
                        <p>(300 Avis)</p>
                    </div>
                    <div class="item-description"> Ullamco exercitation aute sit dolore consequat elit occaecat ut
                        consequat ex id tempor magna.                     
                    </div>
                    <div class="item-tag">
                        <span>
                            <img src="../html/images/icons/tags-fill.svg" alt="">
                            <p>Aquatique</p>
                        </span>
                        <span>
                            <img src="../html/images/icons/tags-fill.svg" alt="">
                            <p>Aquatique</p>
                        </span>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <h1>Sélectionnés pour vous</h1>
    <hr>
    <div class="container">
        <div id="caroussel_selectForYou">
            <div class="card-vertical" >
                <div class="item-image">
                    <img src="../testComposant/Caroussel/Get Away From My Computer ❤ 4K HD Desktop Wallpaper for 4K Ultra HD.jpg" alt="image">
                </div>
                <div class="item-body">
                    <div class="item-title">Mon titre 1</div>
                    <div class="item-location">
                        <img src="../html/images/icons/geo-alt-fill.svg" alt="">
                        <p>Lannion</p>
                        <img src="../html/images/icons/telephone.svg" alt="">
                        <p>06 54 69 52 33</p>
                        <p>100-300 €</p>
                    </div>
                    <div class="item-avis">
                        <p>3,7</p>
                        <img src="../html/images/icons/star-fill.svg" alt="">
                        <img src="../html/images/icons/star-fill.svg" alt="">
                        <img src="../html/images/icons/star-fill.svg" alt="">
                        <img src="../html/images/icons/star-fill.svg" alt="">
                        <img src="../html/images/icons/star-fill.svg" alt="">
                        <p>(300 Avis)</p>
                    </div>
                    <div class="item-description"> Ullamco exercitation aute sit dolore consequat elit occaecat ut
                        consequat ex id tempor magna.                     
                    </div>
                    <div class="item-tag">
                        <span>
                            <img src="../html/images/icons/tags-fill.svg" alt="">
                            <p>Aquatique</p>
                        </span>
                        <span>
                            <img src="../html/images/icons/tags-fill.svg" alt="">
                            <p>Aquatique</p>
                        </span>
                    </div>
                </div>
            </div>
            <div >
                <div class="item-image">
                    <img src="../testComposant/Caroussel/Get Away From My Computer ❤ 4K HD Desktop Wallpaper for 4K Ultra HD.jpg" alt="image">
                </div>
                <div class="item-body">
                    <div class="item-title">Mon titre 1</div>
                    <div class="item-location">
                        <img src="../html/images/icons/geo-alt-fill.svg" alt="">
                        <p>Lannion</p>
                        <img src="../html/images/icons/telephone.svg" alt="">
                        <p>06 54 69 52 33</p>
                        <p>100-300 €</p>
                    </div>
                    <div class="item-avis">
                        <p>3,7</p>
                        <img src="../html/images/icons/star-fill.svg" alt="">
                        <img src="../html/images/icons/star-fill.svg" alt="">
                        <img src="../html/images/icons/star-fill.svg" alt="">
                        <img src="../html/images/icons/star-fill.svg" alt="">
                        <img src="../html/images/icons/star-fill.svg" alt="">
                        <p>(300 Avis)</p>
                    </div>
                    <div class="item-description"> Ullamco exercitation aute sit dolore consequat elit occaecat ut
                        consequat ex id tempor magna.                     
                    </div>
                    <div class="item-tag">
                        <span>
                            <img src="../html/images/icons/tags-fill.svg" alt="">
                            <p>Aquatique</p>
                        </span>
                        <span>
                            <img src="../html/images/icons/tags-fill.svg" alt="">
                            <p>Aquatique</p>
                        </span>
                    </div>
                </div>
            </div>
            <div >
                <div class="item-image">
                    <img src="../testComposant/Caroussel/Get Away From My Computer ❤ 4K HD Desktop Wallpaper for 4K Ultra HD.jpg" alt="image">
                </div>
                <div class="item-body">
                    <div class="item-title">Mon titre 1</div>
                    <div class="item-location">
                        <img src="../html/images/icons/geo-alt-fill.svg" alt="">
                        <p>Lannion</p>
                        <img src="../html/images/icons/telephone.svg" alt="">
                        <p>06 54 69 52 33</p>
                        <p>100-300 €</p>
                    </div>
                    <div class="item-avis">
                        <p>3,7</p>
                        <img src="../html/images/icons/star-fill.svg" alt="">
                        <img src="../html/images/icons/star-fill.svg" alt="">
                        <img src="../html/images/icons/star-fill.svg" alt="">
                        <img src="../html/images/icons/star-fill.svg" alt="">
                        <img src="../html/images/icons/star-fill.svg" alt="">
                        <p>(300 Avis)</p>
                    </div>
                    <div class="item-description"> Ullamco exercitation aute sit dolore consequat elit occaecat ut
                        consequat ex id tempor magna.                     
                    </div>
                    <div class="item-tag">
                        <span>
                            <img src="../html/images/icons/tags-fill.svg" alt="">
                            <p>Aquatique</p>
                        </span>
                        <span>
                            <img src="../html/images/icons/tags-fill.svg" alt="">
                            <p>Aquatique</p>
                        </span>
                    </div>
                </div>
            </div>
            <div >
                <div class="item-image">
                    <img src="../testComposant/Caroussel/Get Away From My Computer ❤ 4K HD Desktop Wallpaper for 4K Ultra HD.jpg" alt="image">
                </div>
                <div class="item-body">
                    <div class="item-title">Mon titre 1</div>
                    <div class="item-location">
                        <img src="../html/images/icons/geo-alt-fill.svg" alt="">
                        <p>Lannion</p>
                        <img src="../html/images/icons/telephone.svg" alt="">
                        <p>06 54 69 52 33</p>
                        <p>100-300 €</p>
                    </div>
                    <div class="item-avis">
                        <p>3,7</p>
                        <img src="../html/images/icons/star-fill.svg" alt="">
                        <img src="../html/images/icons/star-fill.svg" alt="">
                        <img src="../html/images/icons/star-fill.svg" alt="">
                        <img src="../html/images/icons/star-fill.svg" alt="">
                        <img src="../html/images/icons/star-fill.svg" alt="">
                        <p>(300 Avis)</p>
                    </div>
                    <div class="item-description"> Ullamco exercitation aute sit dolore consequat elit occaecat ut
                        consequat ex id tempor magna.                     
                    </div>
                    <div class="item-tag">
                        <span>
                            <img src="../html/images/icons/tags-fill.svg" alt="">
                            <p>Aquatique</p>
                        </span>
                        <span>
                            <img src="../html/images/icons/tags-fill.svg" alt="">
                            <p>Aquatique</p>
                        </span>
                    </div>
                </div>
            </div>
            <div>
                <div class="item-image">
                    <img src="../testComposant/Caroussel/Get Away From My Computer ❤ 4K HD Desktop Wallpaper for 4K Ultra HD.jpg" alt="image">
                </div>
                <div class="item-body">
                    <div class="item-title">Mon titre 1</div>
                    <div class="item-location">
                        <img src="../html/images/icons/geo-alt-fill.svg" alt="">
                        <p>Lannion</p>
                        <img src="../html/images/icons/telephone.svg" alt="">
                        <p>06 54 69 52 33</p>
                        <p>100-300 €</p>
                    </div>
                    <div class="item-avis">
                        <p>3,7</p>
                        <img src="../html/images/icons/star-fill.svg" alt="">
                        <img src="../html/images/icons/star-fill.svg" alt="">
                        <img src="../html/images/icons/star-fill.svg" alt="">
                        <img src="../html/images/icons/star-fill.svg" alt="">
                        <img src="../html/images/icons/star-fill.svg" alt="">
                        <p>(300 Avis)</p>
                    </div>
                    <div class="item-description"> Ullamco exercitation aute sit dolore consequat elit occaecat ut
                        consequat ex id tempor magna.                     
                    </div>
                    <div class="item-tag">
                        <span>
                            <img src="../html/images/icons/tags-fill.svg" alt="">
                            <p>Aquatique</p>
                        </span>
                        <span>
                            <img src="../html/images/icons/tags-fill.svg" alt="">
                            <p>Aquatique</p>
                        </span>
                    </div>
                </div>
            </div>
            <div>
                <div class="item-image">
                    <img src="../testComposant/Caroussel/Get Away From My Computer ❤ 4K HD Desktop Wallpaper for 4K Ultra HD.jpg" alt="image">
                </div>
                <div class="item-body">
                    <div class="item-title">Mon titre 1</div>
                    <div class="item-location">
                        <img src="../html/images/icons/geo-alt-fill.svg" alt="">
                        <p>Lannion</p>
                        <img src="../html/images/icons/telephone.svg" alt="">
                        <p>06 54 69 52 33</p>
                        <p>100-300 €</p>
                    </div>
                    <div class="item-avis">
                        <p>3,7</p>
                        <img src="../html/images/icons/star-fill.svg" alt="">
                        <img src="../html/images/icons/star-fill.svg" alt="">
                        <img src="../html/images/icons/star-fill.svg" alt="">
                        <img src="../html/images/icons/star-fill.svg" alt="">
                        <img src="../html/images/icons/star-fill.svg" alt="">
                        <p>(300 Avis)</p>
                    </div>
                    <div class="item-description"> Ullamco exercitation aute sit dolore consequat elit occaecat ut
                        consequat ex id tempor magna.                     
                    </div>
                    <div class="item-tag">
                        <span>
                            <img src="../html/images/icons/tags-fill.svg" alt="">
                            <p>Aquatique</p>
                        </span>
                        <span>
                            <img src="../html/images/icons/tags-fill.svg" alt="">
                            <p>Aquatique</p>
                        </span>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <h1>Les nouveautés</h1>
    <hr>
    <div class="container-nouveautes">
        <!--<div class="card_horizontal">
            <div class="recommended_horizontal">
                <div>
                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-patch-check-fill" viewBox="0 0 16 16">
                        <path d="M10.067.87a2.89 2.89 0 0 0-4.134 0l-.622.638-.89-.011a2.89 2.89 0 0 0-2.924 2.924l.01.89-.636.622a2.89 2.89 0 0 0 0 4.134l.637.622-.011.89a2.89 2.89 0 0 0 2.924 2.924l.89-.01.622.636a2.89 2.89 0 0 0 4.134 0l.622-.637.89.011a2.89 2.89 0 0 0 2.924-2.924l-.01-.89.636-.622a2.89 2.89 0 0 0 0-4.134l-.637-.622.011-.89a2.89 2.89 0 0 0-2.924-2.924l-.89.01zm.287 5.984-3 3a.5.5 0 0 1-.708 0l-1.5-1.5a.5.5 0 1 1 .708-.708L7 8.793l2.646-2.647a.5.5 0 0 1 .708.708"/>
                    </svg>
                    <p >Recommandé</p>
                </div>
            </div>
            <div class="item__image">
                <img src="../testComposant/Caroussel/Get Away From My Computer ❤ 4K HD Desktop Wallpaper for 4K Ultra HD.jpg" alt="image">
            </div>
            <div class="item__body">
                <div class="item__title">Mon titre 1</div>
                <div class="item__location">
                    <img src="../html/images/icons/geo-alt-fill.svg" alt="">
                    <p>Lannion</p>
                    <img src="../html/images/icons/telephone.svg" alt="">
                    <p>06 54 69 52 33</p>
                    <p>100-300 €</p>
                </div>
                <div class="item__avis">
                    <p>3,7</p>
                    <img src="../html/images/icons/star-fill.svg" alt="">
                    <img src="../html/images/icons/star-fill.svg" alt="">
                    <img src="../html/images/icons/star-fill.svg" alt="">
                    <img src="../html/images/icons/star-fill.svg" alt="">
                    <img src="../html/images/icons/star-fill.svg" alt="">
                    <p>(300 Avis)</p>
                </div>
                <div class="item__description"> Ullamco exercitation aute sit dolore consequat elit occaecat ut
                    consequat ex id tempor magna.                     
                </div>
                <div class="item__tag">
                    <span>
                        <img src="../html/images/icons/tags-fill.svg" alt="">
                        <p>Aquatique</p>
                    </span>
                    <span>
                        <img src="../html/images/icons/tags-fill.svg" alt="">
                        <p>Aquatique</p>
                    </span>
                </div>
            </div>
            
        </div>
        <div class="card_horizontal">
            <div class="item__image">
                <img src="Get Away From My Computer ❤ 4K HD Desktop Wallpaper for 4K Ultra HD.jpg" alt="image">
            </div>
            <div class="item__body">
                <div class="item__title">Mon titre 1</div>
                <div class="item__location">
                    <img src="../html/images/icons/geo-alt-fill.svg" alt="">
                    <p>Lannion</p>
                    <img src="../html/images/icons/telephone.svg" alt="">
                    <p>06 54 69 52 33</p>
                    <p>100-300 €</p>
                </div>
                <div class="item__avis">
                    <p>3,7</p>
                    <img src="../html/images/icons/star-fill.svg" alt="">
                    <img src="../html/images/icons/star-fill.svg" alt="">
                    <img src="../html/images/icons/star-fill.svg" alt="">
                    <img src="../html/images/icons/star-fill.svg" alt="">
                    <img src="../html/images/icons/star-fill.svg" alt="">
                    <p>(300 Avis)</p>
                </div>
                <div class="item__description"> Ullamco exercitation aute sit dolore consequat elit occaecat ut
                    consequat ex id tempor magna.                     
                </div>
                <div class="item__tag">
                    <span>
                        <img src="../html/images/icons/tags-fill.svg" alt="">
                            <p>Aquatique</p>
                        </span>
                        <span>
                            <img src="../html/images/icons/tags-fill.svg" alt="">
                            <p>Aquatique</p>
                        </span>
                    </div>
                </div>
            </div>
            <div class="card_horizontal">
                <div class="item__image">
                    <img src="../testComposant/Caroussel/Get Away From My Computer ❤ 4K HD Desktop Wallpaper for 4K Ultra HD.jpg" alt="image">
                </div>
                <div class="item__body">
                    <div class="item__title">Mon titre 1</div>
                    <div class="item__location">
                        <img src="../html/images/icons/geo-alt-fill.svg" alt="">
                        <p>Lannion</p>
                        <img src="../html/images/icons/telephone.svg" alt="">
                        <p>06 54 69 52 33</p>
                        <p>100-300 €</p>
                    </div>
                    <div class="item__avis">
                        <p>3,7</p>
                        <img src="../html/images/icons/star-fill.svg" alt="">
                        <img src="../html/images/icons/star-fill.svg" alt="">
                        <img src="../html/images/icons/star-fill.svg" alt="">
                        <img src="../html/images/icons/star-fill.svg" alt="">
                        <img src="../html/images/icons/star-fill.svg" alt="">
                        <p>(300 Avis)</p>
                    </div>
                    <div class="item__description"> Ullamco exercitation aute sit dolore consequat elit occaecat ut
                        consequat ex id tempor magna.                     
                    </div>
                    <div class="item__tag">
                        <span>
                            <img src="../html/images/icons/tags-fill.svg" alt="">
                            <p>Aquatique</p>
                        </span>
                        <span>
                            <img src="../html/images/icons/tags-fill.svg" alt="">
                            <p>Aquatique</p>
                        </span>
                    </div>
                </div>
            </div>
            <div class="card_horizontal">
                <div class="item__image">
                    <img src="../testComposant/Caroussel/Get Away From My Computer ❤ 4K HD Desktop Wallpaper for 4K Ultra HD.jpg" alt="image">
                </div>
                <div class="item__body">
                    <div class="item__title">Mon titre 1</div>
                    <div class="item__location">
                        <img src="../html/images/icons/geo-alt-fill.svg" alt="">
                        <p>Lannion</p>
                        <img src="../html/images/icons/telephone.svg" alt="">
                        <p>06 54 69 52 33</p>
                        <p>100-300 €</p>
                    </div>
                    <div class="item__avis">
                        <p>3,7</p>
                        <img src="../html/images/icons/star-fill.svg" alt="">
                        <img src="../html/images/icons/star-fill.svg" alt="">
                        <img src="../html/images/icons/star-fill.svg" alt="">
                        <img src="../html/images/icons/star-fill.svg" alt="">
                        <img src="../html/images/icons/star-fill.svg" alt="">
                        <p>(300 Avis)</p>
                    </div>
                    <div class="item__description"> Ullamco exercitation aute sit dolore consequat elit occaecat ut
                        consequat ex id tempor magna.                     
                    </div>
                    <div class="item__tag">
                        <span>
                            <img src="../html/images/icons/tags-fill.svg" alt="">
                            <p>Aquatique</p>
                        </span>
                        <span>
                            <img src="../html/images/icons/tags-fill.svg" alt="">
                            <p>Aquatique</p>
                        </span>
                    </div>
                </div>
            </div>
            <div class="card_horizontal">
                <div class="item__image">
                    <img src="../testComposant/Caroussel/Get Away From My Computer ❤ 4K HD Desktop Wallpaper for 4K Ultra HD.jpg" alt="image">
                </div>
                <div class="item__body">
                    <div class="item__title">Mon titre 1</div>
                    <div class="item__location">
                        <img src="../html/images/icons/geo-alt-fill.svg" alt="">
                        <p>Lannion</p>
                        <img src="../html/images/icons/telephone.svg" alt="">
                        <p>06 54 69 52 33</p>
                        <p>100-300 €</p>
                    </div>
                    <div class="item__avis">
                        <p>3,7</p>
                        <img src="../html/images/icons/star-fill.svg" alt="">
                        <img src="../html/images/icons/star-fill.svg" alt="">
                        <img src="../html/images/icons/star-fill.svg" alt="">
                        <img src="../html/images/icons/star-fill.svg" alt="">
                        <img src="../html/images/icons/star-fill.svg" alt="">
                        <p>(300 Avis)</p>
                    </div>
                    <div class="item__description"> Ullamco exercitation aute sit dolore consequat elit occaecat ut
                        consequat ex id tempor magna.                     
                    </div>
                    <div class="item__tag">
                        <span>
                            <img src="../html/images/icons/tags-fill.svg" alt="">
                            <p>Aquatique</p>
                        </span>
                        <span>
                            <img src="../html/images/icons/tags-fill.svg" alt="">
                            <p>Aquatique</p>
                        </span>
                    </div>
                </div>
            </div>
            <div class="card_horizontal">
                <div class="item__image">
                    <img src="../testComposant/Caroussel/Get Away From My Computer ❤ 4K HD Desktop Wallpaper for 4K Ultra HD.jpg" alt="image">
                </div>
                <div class="item__body">
                    <div class="item__title">Mon titre 1</div>
                    <div class="item__location">
                        <img src="../html/images/icons/geo-alt-fill.svg" alt="">
                        <p>Lannion</p>
                        <img src="../html/images/icons/telephone.svg" alt="">
                        <p>06 54 69 52 33</p>
                        <p>100-300 €</p>
                    </div>
                    <div class="item__avis">
                        <p>3,7</p>
                        <img src="../html/images/icons/star-fill.svg" alt="">
                        <img src="../html/images/icons/star-fill.svg" alt="">
                        <img src="../html/images/icons/star-fill.svg" alt="">
                        <img src="../html/images/icons/star-fill.svg" alt="">
                        <img src="../html/images/icons/star-fill.svg" alt="">
                        <p>(300 Avis)</p>
                    </div>
                    <div class="item__description"> Ullamco exercitation aute sit dolore consequat elit occaecat ut
                        consequat ex id tempor magna.                     
                    </div>
                    <div class="item__tag">
                        <span>
                            <img src="../html/images/icons/tags-fill.svg" alt="">
                            <p>Aquatique</p>
                        </span>
                        <span>
                            <img src="../html/images/icons/tags-fill.svg" alt="">
                            <p>Aquatique</p>
                        </span>
                    </div>
                </div>
            </div>!-->
             <?php include_once "../phpTemplates/cardRecommendedHorizontal.php" ?>
        </div>
    </main>
        
        
    <script src="../html/scripts/caroussel.js"></script>
        
    </body>
    </html>
    