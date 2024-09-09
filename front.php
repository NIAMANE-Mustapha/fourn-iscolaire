<?php
session_start();
require('connection.php');
try{
    $req='SELECT * from product ';
    $res=$con->query($req);
}
catch(Exception $e) {
    echo $e->getMessage();
}

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>My Website</title>
    <link rel="stylesheet" href="css/frontstyle.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
</head>
<body>
    <header>
        <div id="login_statut"><? echo $_SESSION['logged_in'] ?></div>
        <div id="clientname"><? echo $_SESSION['Name'] ?></div>
        <div class="container">
            <div class="logo">
                <a href="front.php"><img src="images/logo1.png" alt="School Supplies Library Logo"></a>
            </div>
            <nav>
                <ul>
                    <li><a href="index.html">Home</a></li>
                    <li><a href="shop.html">Shop</a></li>
                    <li><a href="AboutUs.php">About Us</a></li>
                </ul>
            </nav>
            <div class="header-right">
                <div class="search-cart">
                    <div class="search">
                        <input type="text" placeholder="Search for products...">
                        <button><i class="fa fa-search"></i></button>
                    </div>
                    <div class="cart">
                        <a href="cart.php">
                            <i class="fa fa-shopping-cart"></i>
                            <span class="cart-count" id="cart-count">0</span>
                        </a>
                    </div>
                </div>
                
                <div class="auth-links">
                    <a href="identification.php" >Login</a>
                    <a href="identification.php" class="signup-btn">Sign Up</a>
                </div>
                
            </div>
            <button onclick="logout()" id="logoutbtn">Log Out</button>
        </div>
    </header>

    <section class="hero">
        <div class="slider">
                <div class="slide">
                    <img src="images/main_img.webp" alt="Wide range of school supplies">
                </div>
                <div class="slide">
                    <img src="images/main_2.jpg" alt="Affordable school furniture">
                </div>
                <div class="slide">
                    <img src="images/main_3.jpg" alt="High-quality materials for schools">
                </div>
        </div>
    </section>
    <section>
    <div class="hero-text">
        <h1>Envoyer nous votre liste de fournitures scolaires</h1>
        <a href="shop.html" class="btn">Envoyer ma liste</a>
    </div>
    </section>

    <section class="main_containt">
        <aside class="product-categories">
            <h2>CATÉGORIES</h2>
            <div class="category">
                <label for="stationery-toggle">
                    <img src="images/painting.png" alt="Stationery">
                    <span>Dessin et tableau</span>
                </label>
                <ul class="subcategories">
                    <li><a href="sketchbooks.html">Coloriage</a></li>
                    <li><a href="paints.html">Peinture</a></li>
                    <li><a href="brushes.html">Pinceaux</a></li>
                    <li><a href="brushes.html">Tableaux blanc sur pied avec roulettes</a></li>
                    <li><a href="brushes.html">Tableaux a craies</a></li>
                    <li><a href="brushes.html">Chevalet de Peinture</a></li>
                    <li><a href="brushes.html">Pâte à Modeler</a></li>
                    <li><a href="brushes.html">Autres</a></li>
                </ul>
            </div>
            <div class="category">
                <label for="stationery-toggle">
                    <img src="images/Backpack.png" alt="Stationery">
                    <span>Cartable et trousse</span>
                </label>
                <ul class="subcategories">
                    <li><a href="sketchbooks.html">Sac à goûter</a></li>
                    <li><a href="paints.html">Cartables</a></li>
                    <li><a href="brushes.html">Trousses</a></li>
                    <li><a href="brushes.html">Gourdes</a></li>
                    <li><a href="brushes.html">Autres</a></li>
                </ul>
            </div>
            <div class="category">
                <label for="stationery-toggle">
                    <img src="images/paper.png" alt="Stationery">
                    <span>Papeterie</span>
                </label>
                <ul class="subcategories">
                    <li><a href="sketchbooks.html">Cahiers et Registres</a></li>
                    <li><a href="paints.html">Carnets et bloc-Notes</a></li>
                    <li><a href="brushes.html">Papiers Speciaux</a></li>
                    <li><a href="brushes.html">Proteges et Couvertures</a></li>
                    <li><a href="brushes.html">Classeurs et Intercalaires</a></li>
                    <li><a href="brushes.html">Courrier</a></li>
                    <li><a href="brushes.html">Boite Archives</a></li>
                    <li><a href="brushes.html">Rouleaux papier</a></li>
                    <li><a href="brushes.html">Autres</a></li>
                </ul>
            </div>
            <div class="category">
                <label for="stationery-toggle">
                    <img src="images/pen.png" alt="Stationery">
                    <span>Écriture et Correction</span>
                </label>
                <ul class="subcategories">
                    <li><a href="sketchbooks.html">Correcteurs</a></li>
                    <li><a href="paints.html">Flourescent</a></li>
                    <li><a href="brushes.html">Marqueurs</a></li>
                    <li><a href="brushes.html">Stylos</a></li>
                    <li><a href="brushes.html">Crayons</a></li>
                    <li><a href="brushes.html">Recharges Marqueurs</a></li>
                    <li><a href="brushes.html">Autres</a></li>
                </ul>
            </div>
            <div class="category">
                <label for="stationery-toggle">
                    <img src="images/printer.png" alt="Stationery">
                    <span>Cartouches et tonners</span>
                </label>
                <ul class="subcategories">
                    <li><a href="sketchbooks.html">Cartouches jet d’encre</a></li>
                    <li><a href="paints.html">Toner pour imprimante laser</a></li>
                    <li><a href="brushes.html">Toner pour photocopieurs</a></li>
                    <li><a href="brushes.html">Consommable pour imprimantes tickets et badges</a></li>
                    <li><a href="brushes.html">Consommables compatibles</a></li>
                    <li><a href="brushes.html">Autres</a></li>

                </ul>
            </div>
            <div class="category">
                <label for="stationery-toggle">
                    <img src="images/laptop.png" alt="Stationery">
                    <span>Informatique et accessoires</span>
                </label>
                <ul class="subcategories">
                    <li><a href="sketchbooks.html">Ordinateurs</a></li>
                    <li><a href="paints.html">Écrans</a></li>
                    <li><a href="brushes.html">Périphérique</a></li>
                    <li><a href="brushes.html">Autres</a></li>
                </ul>
            </div>
            <div class="category">
                <label for="stationery-toggle">
                    <img src="images/books.png" alt="Stationery">
                    <span>Livres Scolaires</span>
                </label>
                <ul class="subcategories">
                    <li><a href="sketchbooks.html">Première année primaire</a></li>
                    <li><a href="paints.html">Deuxième année primaire</a></li>
                    <li><a href="brushes.html">Troisième année primaire</a></li>
                    <li><a href="brushes.html">Quatrième année primaire</a></li>
                    <li><a href="brushes.html">Cinquième année primaire</a></li>
                    <li><a href="brushes.html">Sixième année primaire</a></li>
                    <li><a href="brushes.html">Première année collège</a></li>
                    <li><a href="brushes.html">Deuxième année collège</a></li>
                    <li><a href="brushes.html">Troisième année collège</a></li>
                    <li><a href="brushes.html">Tronc commun</a></li>
                    <li><a href="brushes.html">Première année bac</a></li>
                    <li><a href="brushes.html">Deuxième année bac</a></li>
                </ul>
            </div>
            <div class="category">
                <label for="stationery-toggle">
                    <img src="images/geometry.png" alt="Stationery">
                    <span>Géométrie</span>
                </label>
                <ul class="subcategories">
                    <li><a href="sketchbooks.html">Règles</a></li>
                    <li><a href="paints.html">Compas</a></li>
                    <li><a href="brushes.html">Ciseaux</a></li>
                    <li><a href="brushes.html">Autres</a></li>
                </ul>
            </div>
            <div class="category">
                <label for="stationery-toggle">
                    <img src="images/computer.png" alt="Stationery">
                    <span>Machine de Bureau</span>
                </label>
                <ul class="subcategories">
                    <li><a href="sketchbooks.html">Calculatrices</a></li>
                    <li><a href="paints.html">Relieuses</a></li>
                    <li><a href="brushes.html">Plastifieuses</a></li>
                    <li><a href="brushes.html">Massicots et Cisailles</a></li>
                    <li><a href="brushes.html">Destructeurs papier</a></li>
                    <li><a href="brushes.html">Titreuses et Étiquettes</a></li>
                    <li><a href="brushes.html">Autres</a></li>
                </ul>
            </div>
            <div class="category">
                <label for="stationery-toggle">
                    <img src="images/pack.png" alt="Stationery">
                    <span>Packs fournitures scolaires</span>
                </label>
            </div>  
        </aside>
        <section class="products_banners">
            <?php    
            foreach($res as $index){
            ?> 
                <article>
                    <p class="description"> <?php echo htmlspecialchars($index['Description']) ?></p>
                    <div class="icon" title="View Description">&#8505;</div> <!-- Info icon -->
                    <img id="pci" src="images/<?php echo htmlspecialchars($index['photo']); ?>" alt="product_pic">
                    <div class="product-info">
                        <h3><?php echo htmlspecialchars($index['Name']) ?></h3>
                        <div class="price">
                            <span class="old_price">
                                <?php echo htmlspecialchars($index['Price'])*1.2; ?> DH
                            </span>
                            <span class="new_price">
                                <?php echo htmlspecialchars($index['Price']); ?> DH
                            </span>
                        </div>
                        <div class="links">
                        <a href="javascript:void(0);" onclick="addToCart(<?php echo $index['ProductId']; ?>)"><img class="carticon" src="images/card.png" id="addtcard" alt="panier"></a>
                        <a href="#"><img class="carticon" src="images/eye.png" alt="panier"></a>
                        </div>
                    </div>
                </article>
            <?php
            }
            ?>
        </section>

    </section>

 

    <footer>
        <div class="container">
            <p>&copy; 2024 Fourni Scolaire. All rights reserved.</p>
            <a href="admin_login.php"><button class="admin-btn">Admin Login</button></a>
            <ul class="social-links">
                <li><a href="#"><img src="images/facebook_logo.png" alt="d"></a></li>
                <li><a href="#"><img src="images/Whatsapp_icon.png" alt="d"></a></li>

            </ul>
        </div>
    </footer>

    <script >
        //login handler:
       
        const loginstatut = document.getElementById("login_statut");
        if (loginstatut && loginstatut.textContent.trim() === "1") {
            const authLinks = document.getElementsByClassName("auth-links")[0];
            if (authLinks) {
                authLinks.textContent =document.getElementById("clientname").textContent.trim();
                document.getElementById("logoutbtn").style.display = "block";
            }
            
        }
        //logout handler:
        function logout() {
        fetch('logout.php', {
            method: 'POST'
        })
        .then(response => response.text())
        .then(data => {
            console.log(data); // Optional: Log the response from logout.php
            // Redirect to login page or another page
            window.location.href = 'identification.php';
        })
        .catch(error => console.error('Error:', error));
        }        





        // Show description
        const descriptions = document.querySelectorAll('.description');
        const icons = document.querySelectorAll('.icon');

        icons.forEach((icon, index) => {
            icon.addEventListener('mouseenter', () => {
                console.log("Mouse entered");
                // Show description with animation
                descriptions[index].classList.add('show');
                // Rotate icon
                icon.classList.add('rotate');
            });

            icon.addEventListener('mouseleave', () => {
                console.log("Mouse left");
                // Hide description with animation
                descriptions[index].classList.remove('show');
                // Remove icon rotation
                icon.classList.remove('rotate');
            });
        });
        //slides
        const slider = document.querySelector('.slider');
        const slides = document.querySelectorAll('.slide');
        let currentIndex = 0;
        const totalSlides = slides.length;

        function slideToNext() {
            currentIndex++;
            if (currentIndex >= totalSlides) {
                currentIndex = 0; // Reset to the first slide
            }
            slider.style.transition = 'transform 1s ease-in-out';
            slider.style.transform = `translateX(-${currentIndex * 100}%)`;
        }

        // Slide every 4 seconds (1s transition + 3s pause)
        setInterval(slideToNext, 4000);

        // Add to cart
        document.querySelectorAll(".carticon").forEach(function(element) {
        element.onclick = function() {
            var cartcount = document.getElementById('cart-count');
            cartcount.textContent = parseInt(cartcount.textContent) + 1;
        };
        });
        function addToCart(productId) {
        fetch(`carthandler.php?id=${productId}`)
            .then(response => response.text())
            .then(data => {
                // Handle the response if needed
                console.log('Product added to cart:', data);
            })
            .catch(error => {
                console.error('Error:', error);
            });
        }
    </script>

</body>
</html>
