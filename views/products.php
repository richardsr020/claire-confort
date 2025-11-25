<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="description" content="Claire Confort - Tous nos produits de nettoyage professionnels">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    
    <title>Nos Produits - Claire Confort</title>

    <!-- Favicon -->
    <link rel="icon" href="assets/images/core-img/favicon.ico">

    <!-- Core Style CSS -->
    <link rel="stylesheet" href="assets/css/core-style.css">
    <link rel="stylesheet" href="assets/css/style.css">
    <link rel="stylesheet" href="assets/css/font-awesome.min.css">
    <link rel="stylesheet" href="assets/css/bootstrap.min.css">
    <link rel="stylesheet" href="assets/css/classy-nav.min.css">
    <link rel="stylesheet" href="assets/css/products.css">
    
</head>

<body>
    <!-- Search Wrapper Area Start -->
    <div class="search-wrapper section-padding-100">
        <div class="search-close">
            <i class="fa fa-close" aria-hidden="true"></i>
        </div>
        <div class="container">
            <div class="row">
                <div class="col-12">
                    <div class="search-content">
                        <form action="#" method="get">
                            <input type="search" name="search" id="search" placeholder="Rechercher un produit...">
                            <button type="submit"><img src="assets/images/core-img/search.png" alt=""></button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Search Wrapper Area End -->

    <!-- ##### Main Content Wrapper Start ##### -->
    <div class="main-content-wrapper d-flex clearfix">

        <!-- Mobile Nav -->
        <div class="mobile-nav">
            <div class="amado-navbar-brand">
                <a href="index.php?page=home">
                    <i class="fas fa-spray-can" style="color: #f39422;"></i>
                    <span class="logo-text">Claire<span style="color: #f39422;">Confort</span></span>
                </a>
            </div>
            <div class="amado-navbar-toggler">
                <span></span><span></span><span></span>
            </div>
        </div>

        <!-- Header Area Start -->
        <header class="header-area clearfix">
            <div class="nav-close">
                <i class="fa fa-close" aria-hidden="true"></i>
            </div>
            <div class="logo">
                <a href="index.php?page=home">
                    <i class="fas fa-spray-can" style="color: #f39422;"></i>
                    <span class="logo-text">Claire<span style="color: #f39422;">Confort</span></span>
                </a>
            </div>
            <nav class="amado-nav">
                <ul>
                    <li><a href="index.php?page=home">Accueil</a></li>
                    <li class="active"><a href="index.php?page=products">Produits</a></li>
                    <li><a href="index.php?page=dashboard">Dashboard</a></li>
                </ul>
            </nav>
            <div class="amado-btn-group mt-30 mb-100">
                <a href="#products" class="btn amado-btn mb-15" style="background-color: #f39422; border-color: #f39422;">Tous les Produits</a>
                <a href="#contact" class="btn amado-btn active" style="background-color: #000000; border-color: #000000;">Nous Contacter</a>
            </div>
            <div class="cart-fav-search mb-100">
                <a href="index.php?page=admin-login" class="cart-nav"><img src="assets/images/core-img/user.png" alt=""> Connexion</a>
            </div>
            <div class="social-info d-flex justify-content-between">
                <a href="#"><i class="fab fa-pinterest" aria-hidden="true"></i></a>
                <a href="#"><i class="fab fa-instagram" aria-hidden="true"></i></a>
                <a href="#"><i class="fab fa-facebook" aria-hidden="true"></i></a>
                <a href="#"><i class="fab fa-twitter" aria-hidden="true"></i></a>
            </div>
        </header>
        <!-- Header Area End -->

        <!-- Products Grid Section Start -->
        <div class="products-grid-section">
            <div class="container">
                <div class="row justify-content-center">
                    <div class="col-12 col-lg-10">
                        <div class="section-heading text-center mb-5">
                            <h2>Nos <span>Produits</span></h2>
                            <p>Découvrez notre gamme complète de produits de nettoyage professionnels</p>
                        </div>
                    </div>
                </div>

                <!-- Filters Section -->
                <div class="filters-section">
                    <div class="row">
                        <div class="col-12 col-md-6">
                            <div class="search-box">
                                <i class="fas fa-search"></i>
                                <input type="text" id="productSearch" placeholder="Rechercher un produit...">
                            </div>
                        </div>
                        <div class="col-12 col-md-6">
                            <div class="filter-group">
                                <h5>Catégories</h5>
                                <div class="filter-options" id="categoryFilters">
                                    <div class="filter-option active" data-category="all">Tous</div>
                                    <!-- Les catégories seront chargées dynamiquement -->
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-12 col-md-6">
                            <div class="filter-group">
                                <h5>Prix</h5>
                                <div class="filter-options" id="priceFilters">
                                    <div class="filter-option active" data-price="all">Tous</div>
                                    <div class="filter-option" data-price="0-10">0-10 €</div>
                                    <div class="filter-option" data-price="10-20">10-20 €</div>
                                    <div class="filter-option" data-price="20-50">20-50 €</div>
                                    <div class="filter-option" data-price="50+">50+ €</div>
                                </div>
                            </div>
                        </div>
                        <div class="col-12 col-md-6">
                            <div class="filter-group">
                                <h5>Disponibilité</h5>
                                <div class="filter-options" id="stockFilters">
                                    <div class="filter-option active" data-stock="all">Tous</div>
                                    <div class="filter-option" data-stock="available">En stock</div>
                                    <div class="filter-option" data-stock="low">Stock faible</div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Products Grid -->
                <div class="product-grid" id="productsGrid">
                    <div class="loading-state">
                        <i class="fas fa-spinner fa-spin"></i>
                        <p>Chargement des produits...</p>
                    </div>
                </div>

                <!-- No Products Message -->
                <div class="no-products" id="noProducts" style="display: none;">
                    <i class="fas fa-box-open"></i>
                    <h4>Aucun produit trouvé</h4>
                    <p>Aucun produit ne correspond à vos critères de recherche.</p>
                </div>
            </div>
        </div>
        <!-- Products Grid Section End -->
    </div>
    <!-- ##### Main Content Wrapper End ##### -->

    <!-- ##### jQuery (Necessary for All JavaScript Plugins) ##### -->
    <script src="assets/js/jquery/jquery-2.2.4.min.js"></script>
    <script src="assets/js/popper.min.js"></script>
    <script src="assets/js/bootstrap.min.js"></script>
    <script src="assets/js/plugins.js"></script>
    <script src="assets/js/active.js"></script>
    <script src="assets/js/classy-nav.min.js"></script>
    <script src="assets/js/products.js"></script>
</body>
</html>