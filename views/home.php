
    <style>
        /* Correction minimale pour les problèmes actuels */
    .amado-pro-catagory.clearfix {
        display: grid;
        grid-template-columns: repeat(3, 1fr);
        gap: 0;
    }

    .single-products-catagory.clearfix {
        position: relative;
        overflow: hidden;
    }

    .single-products-catagory.clearfix img {
        width: 100%;
        height: 300px;
        object-fit: cover;
        display: block;
    }

    /* Forcer la couleur grise pour tous les h4 */
    .single-products-catagory .hover-content h4 {
        color: #ffffffff !important;
        font-weight: 600;
    }

    /* S'assurer que le style inline ne surcharge pas */
    .single-products-catagory .hover-content h4[style] {
        color: #6c757d !important;
    }
        /* Features Section */
        .features-area {
            background: #f8f9fa;
        }
        
        .section-heading h2 {
            font-size: 2.5rem;
            font-weight: 700;
            margin-bottom: 1rem;
        }
        
        .section-heading h2 span {
            color: #000000ff;
        }
        
        .section-heading p {
            font-size: 1.1rem;
            color: #6c757d;
        }
        
        .single-feature {
            padding: 2rem 1.5rem;
            background: white;
            border-radius: 10px;
            box-shadow: 0 5px 15px rgba(0,0,0,0.08);
            transition: transform 0.3s ease, box-shadow 0.3s ease;
        }
        
        .single-feature:hover {
            transform: translateY(-5px);
            box-shadow: 0 10px 25px rgba(0,0,0,0.15);
        }
        
        .icon-wrapper {
            width: 80px;
            height: 80px;
            margin: 0 auto;
            background: linear-gradient(135deg, #131413ff, #ffffffff);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
        }
        
        .feature-icon i {
            font-size: 2rem;
            color: white;
        }
        
        .single-feature h4 {
            font-weight: 600;
            color: #2c3e50;
        }
        
        .single-feature p {
            color: #6c757d;
            line-height: 1.6;
        }
        
        /* Stats Section */
        .stats-area {
            position: relative;
            background-size: cover;
            background-position: center;
            background-attachment: fixed;
        }
        
        .stats-area::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: rgba(0,0,0,0.7);
        }
        
        .stats-area .container {
            position: relative;
            z-index: 1;
        }
        
        .single-stat {
            padding: 2rem 1rem;
        }
        
        .stat-icon {
            width: 70px;
            height: 70px;
            margin: 0 auto;
            background: rgba(255,255,255,0.1);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            backdrop-filter: blur(10px);
            border: 1px solid rgba(255,255,255,0.2);
        }
        
        .stat-icon i {
            font-size: 1.8rem;
            color: #f39422;
        }
        
        .stat-number {
            font-size: 2.5rem;
            font-weight: 700;
            color: white;
            margin-bottom: 0.5rem;
        }
        
        .stat-label {
            color: rgba(255,255,255,0.9);
            font-weight: 500;
        }
        
        /* Contact Section */
        .contact-info-item {
            display: flex;
            align-items: flex-start;
            padding: 1.5rem;
            background: white;
            border-radius: 10px;
            box-shadow: 0 3px 10px rgba(0,0,0,0.08);
            margin-bottom: 1.5rem;
        }
        
        .contact-icon {
            width: 50px;
            height: 50px;
            background: #f39422;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            flex-shrink: 0;
        }
        
        .contact-icon i {
            color: white;
            font-size: 1.2rem;
        }
        
        .contact-text h5 {
            font-weight: 600;
            color: #2c3e50;
            margin-bottom: 0.5rem;
        }
        
        .contact-text p {
            color: #6c757d;
            margin-bottom: 0;
        }
        
        .contact-form .form-control {
            border: 2px solid #e9ecef;
            border-radius: 8px;
            padding: 0.75rem 1rem;
            font-size: 1rem;
            transition: all 0.3s ease;
        }
        
        .contact-form .form-control:focus {
            border-color: #40ba37;
            box-shadow: 0 0 0 0.2rem rgba(64, 186, 55, 0.25);
        }
        
        .contact-form textarea.form-control {
            resize: vertical;
            min-height: 120px;
        }
        
        /* Animations */
        .wow {
            visibility: hidden;
        }
        
        @media (max-width: 768px) {
            .section-heading h2 {
                font-size: 2rem;
            }
            
            .single-feature {
                margin-bottom: 2rem;
            }
            
            .contact-info-item {
                padding: 1rem;
            }
        }
    </style>
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

                <!-- Mobile Nav (max width 767px)-->
        <div class="mobile-nav">
            <!-- Navbar Brand -->
            <div class="amado-navbar-brand">
                <a href="index.php?page=home">
                    <img src="assets/images/claire_icon.png" alt="Claire Confort" class="logo-icon">
                    <span class="logo-text">Claire<span style="color: #f39422;">Confort</span></span>
                </a>
            </div>
            <!-- Navbar Toggler -->
            <div class="amado-navbar-toggler">
                <span></span><span></span><span></span>
            </div>
        </div>

        <!-- Header Area Start -->
        <header class="header-area clearfix">
            <!-- Close Icon -->
                <!-- Close Icon -->
            <div class="nav-close">
                <i class="fa fa-close" aria-hidden="true"></i>
            </div>
            <!-- Logo -->
            <div class="logo">
                <a href="index.php?page=home">
                    <img src="assets/images/claire_icon.png" alt="Claire Confort" class="logo-icon">
                    <span class="logo-text">Claire<span style="color: #f39422;">Confort</span></span>
                </a>
            </div>
            <!-- Amado Nav -->
            <nav class="amado-nav">
                <ul>
                    <li class="active"><a href="index.php?page=home">Accueil</a></li>
                    <li><a href="index.php?page=products">Produits</a></li>
                    <li><a href="index.php?page=dashboard">Dashboard</a></li>
                </ul>
            </nav>
            <!-- Button Group -->
            <div class="amado-btn-group mt-30 mb-100">
                <a href="index.php?page=products" class="btn amado-btn mb-15" style="background-color: #f39422; border-color: #f39422;">Nos Produits</a>
                <a href="#contact" class="btn amado-btn active" style="background-color: #000000; border-color: #000000;">Nous Contacter</a>
            </div>
            <!-- Cart Menu -->
            <div class="cart-fav-search mb-100">
                <a href="index.php?page=admin-login" class="cart-nav"><img src="assets/images/core-img/user.png" alt=""> Connexion</a>
            </div>
            <!-- Social Button -->
            <div class="social-info d-flex justify-content-between">
                <a href="#"><i class="fab fa-pinterest" aria-hidden="true"></i></a>
                <a href="#"><i class="fab fa-instagram" aria-hidden="true"></i></a>
                <a href="#"><i class="fab fa-facebook" aria-hidden="true"></i></a>
                <a href="#"><i class="fab fa-twitter" aria-hidden="true"></i></a>
            </div>
        </header>
        <!-- Header Area End -->

        <!-- Product Catagories Area Start -->
        <div class="products-catagories-area clearfix">
            <div class="amado-pro-catagory clearfix">

                <!-- Single Catagory - Nettoyant Multi-Surfaces -->
                <div class="single-products-catagory clearfix">
                    <a href="index.php?page=products">
                        <img src="assets/images/bg-img/1.jpg" alt="Nettoyant Multi-Surfaces">
                        <!-- Hover Content -->
                        <div class="hover-content">
                            <div class="line" style="background-color: #f39422;"></div>
                            <p>Outils manuel</p>
                            <h4>Nettoyant Multi-Surfaces</h4>
                        </div>
                    </a>
                </div>

                <!-- Single Catagory - Désinfectant -->
                <div class="single-products-catagory clearfix">
                    <a href="index.php?page=products">
                        <img src="assets/images/bg-img/2.jpg" alt="Désinfectant">
                        <!-- Hover Content -->
                        <div class="hover-content">
                            <div class="line" style="background-color: #f39422;"></div>
                            <p>Grandes surfaces</p>
                            <h4>Detergants</h4>
                        </div>
                    </a>
                </div>

                <!-- Single Catagory - Gel Hydroalcoolique -->
                <div class="single-products-catagory clearfix">
                    <a href="index.php?page=products">
                        <img src="assets/images/bg-img/3.jpg" alt="Gel Hydroalcoolique">
                        <!-- Hover Content -->
                        <div class="hover-content">
                            <div class="line" style="background-color: #f39422;"></div>
                            <p>Aspirateurs </p>
                            <h4>Grands surface</h4>
                        </div>
                    </a>
                </div>

                <!-- Single Catagory - Produits Écologiques -->
                <div class="single-products-catagory clearfix">
                    <a href="index.php?page=products">
                        <img src="assets/images/bg-img/4.jpg" alt="Produits Écologiques">
                        <!-- Hover Content -->
                        <div class="hover-content">
                            <div class="line" style="background-color: #f39422;"></div>
                            <p>Produits Verts</p>
                            <h4>Écologique & Biodégradable</h4>
                        </div>
                    </a>
                </div>

                <!-- Single Catagory - Professionnels -->
                <div class="single-products-catagory clearfix">
                    <a href="index.php?page=products">
                        <img src="assets/images/bg-img/5.jpg" alt="Professionnels">
                        <!-- Hover Content -->
                        <div class="hover-content">
                            <div class="line" style="background-color: #f39422;"></div>
                            <p>Solutions Pro</p>
                            <h4>Pour Entreprises & ONG</h4>
                        </div>
                    </a>
                </div>

                <!-- Single Catagory - Livraison -->
                <div class="single-products-catagory clearfix">
                    <a href="index.php?page=products">
                        <img src="assets/images/bg-img/6.jpg" alt="Livraison Rapide">
                        <!-- Hover Content -->
                        <div class="hover-content">
                            <div class="line" style="background-color: #f39422;"></div>
                            <p>Service Express</p>
                            <h4>Livraison 24h</h4>
                        </div>
                    </a>
                </div>

                <!-- Single Catagory - Support -->
                <div class="single-products-catagory clearfix">
                    <a href="index.php?page=products">
                        <img src="assets/images/bg-img/7.jpg" alt="Support Client">
                        <!-- Hover Content -->
                        <div class="hover-content">
                            <div class="line" style="background-color: #f39422;"></div>
                            <p>Assistance</p>
                            <h4>Support 7j/7</h4>
                        </div>
                    </a>
                </div>

                <!-- Single Catagory - Qualité -->
                <div class="single-products-catagory clearfix">
                    <a href="index.php?page=products">
                        <img src="assets/images/bg-img/8.jpg" alt="Qualité Certifiée">
                        <!-- Hover Content -->
                        <div class="hover-content">
                            <div class="line" style="background-color: #f39422;"></div>
                            <p>Normes</p>
                            <h4>Qualité Certifiée</h4>
                        </div>
                    </a>
                </div>

                <!-- Single Catagory - Prix -->
                <div class="single-products-catagory clearfix">
                    <a href="index.php?page=products">
                        <img src="assets/images/bg-img/9.jpg" alt="Prix Compétitifs">
                        <!-- Hover Content -->
                        <div class="hover-content">
                            <div class="line" style="background-color: #f39422;"></div>
                            <p>Économique</p>
                            <h4>Prix Compétitifs</h4>
                        </div>
                    </a>
                </div>
            </div>
        </div>
        <!-- Product Catagories Area End -->
    </div>` 
    <!-- ##### Main Content Wrapper End ##### -->
    <!-- ##### Features Area Start ##### -->
    <section class="features-area section-padding-100">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-12 col-lg-8">
                    <div class="section-heading text-center mb-70">
                        <h2>Pourquoi Choisir <span>Claire Confort</span> ?</h2>
                        <p>Découvrez les avantages qui font de nous votre partenaire de confiance</p>
                    </div>
                </div>
            </div>
            <div class="row">
                <!-- Feature 1 -->
                <div class="col-12 col-sm-6 col-lg-4">
                    <div class="single-feature mb-100 text-center wow fadeInUp" data-wow-delay="100ms">
                        <div class="feature-icon mb-4">
                            <div class="icon-wrapper">
                                <i class="fas fa-leaf"></i>
                            </div>
                        </div>
                        <h4 class="mb-3">Écologique</h4>
                        <p class="mb-0">Produits biodégradables et respectueux de l'environnement</p>
                    </div>
                </div>
                <!-- Feature 2 -->
                <div class="col-12 col-sm-6 col-lg-4">
                    <div class="single-feature mb-100 text-center wow fadeInUp" data-wow-delay="200ms">
                        <div class="feature-icon mb-4">
                            <div class="icon-wrapper">
                                <i class="fas fa-award"></i>
                            </div>
                        </div>
                        <h4 class="mb-3">Haute Qualité</h4>
                        <p class="mb-0">Formulations professionnelles testées et approuvées</p>
                    </div>
                </div>
                <!-- Feature 3 -->
                <div class="col-12 col-sm-6 col-lg-4">
                    <div class="single-feature mb-100 text-center wow fadeInUp" data-wow-delay="300ms">
                        <div class="feature-icon mb-4">
                            <div class="icon-wrapper">
                                <i class="fas fa-shipping-fast"></i>
                            </div>
                        </div>
                        <h4 class="mb-3">Livraison Rapide</h4>
                        <p class="mb-0">Expédition sous 24h avec suivi en temps réel</p>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- ##### Features Area End ##### -->

    <!-- ##### Stats Area Start ##### -->
    <section class="stats-area section-padding-100 bg-img" style="background-image: url(assets/images/bg-img/4.jpg);">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-12 col-lg-8">
                    <div class="section-heading text-center mb-70 text-white">
                        <h2>Notre Engagement Qualité</h2>
                        <p>Des chiffres qui parlent d'eux-mêmes</p>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-6 col-md-3">
                    <div class="single-stat text-center mb-50 wow fadeInUp" data-wow-delay="100ms">
                        <div class="stat-icon mb-3">
                            <i class="fas fa-users"></i>
                        </div>
                        <h3 class="stat-number mb-2">500+</h3>
                        <p class="stat-label mb-0">Clients Satisfaits</p>
                    </div>
                </div>
                <div class="col-6 col-md-3">
                    <div class="single-stat text-center mb-50 wow fadeInUp" data-wow-delay="200ms">
                        <div class="stat-icon mb-3">
                            <i class="fas fa-boxes"></i>
                        </div>
                        <h3 class="stat-number mb-2">50+</h3>
                        <p class="stat-label mb-0">Produits</p>
                    </div>
                </div>
                <div class="col-6 col-md-3">
                    <div class="single-stat text-center mb-50 wow fadeInUp" data-wow-delay="300ms">
                        <div class="stat-icon mb-3">
                            <i class="fas fa-chart-line"></i>
                        </div>
                        <h3 class="stat-number mb-2">98%</h3>
                        <p class="stat-label mb-0">Satisfaction Client</p>
                    </div>
                </div>
                <div class="col-6 col-md-3">
                    <div class="single-stat text-center mb-50 wow fadeInUp" data-wow-delay="400ms">
                        <div class="stat-icon mb-3">
                            <i class="fas fa-shipping-fast"></i>
                        </div>
                        <h3 class="stat-number mb-2">24h</h3>
                        <p class="stat-label mb-0">Livraison</p>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- ##### Stats Area End ##### -->

    <!-- ##### Contact Area Start ##### -->
    <section class="contact-area section-padding-100">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-12 col-lg-8">
                    <div class="section-heading text-center mb-70">
                        <h2>Contactez-<span>nous</span></h2>
                        <p>Une question ? Un projet ? Notre équipe vous répond sous 24h</p>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-12 col-lg-4">
                    <div class="contact-info mb-100">
                        <div class="contact-info-item mb-5">
                            <div class="contact-icon mr-3">
                                <i class="fas fa-phone"></i>
                            </div>
                            <div class="contact-text">
                                <h5>Téléphone</h5>
                                <p>+243 81 234 5678</p>
                            </div>
                        </div>
                        <div class="contact-info-item mb-5">
                            <div class="contact-icon mr-3">
                                <i class="fas fa-envelope"></i>
                            </div>
                            <div class="contact-text">
                                <h5>Email</h5>
                                <p>info@claireconfort.cd</p>
                            </div>
                        </div>
                        <div class="contact-info-item mb-5">
                            <div class="contact-icon mr-3">
                                <i class="fas fa-map-marker-alt"></i>
                            </div>
                            <div class="contact-text">
                                <h5>Zone d'Intervention</h5>
                                <p>Partout en République Démocratique du Congo</p>
                            </div>
                        </div>
                        <div class="contact-info-item">
                            <div class="contact-icon mr-3">
                                <i class="fas fa-clock"></i>
                            </div>
                            <div class="contact-text">
                                <h5>Horaires</h5>
                                <p>Lun-Ven: 8h00-18h00<br>Sam: 9h00-13h00</p>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-12 col-lg-8">
                    <div class="contact-form">
                        <form id="contactForm" method="post">
                            <div class="row">
                                <div class="col-12 col-md-6">
                                    <div class="form-group mb-4">
                                        <input type="text" class="form-control" name="name" placeholder="Votre nom" required>
                                    </div>
                                </div>
                                <div class="col-12 col-md-6">
                                    <div class="form-group mb-4">
                                        <input type="email" class="form-control" name="email" placeholder="Votre email" required>
                                    </div>
                                </div>
                                <div class="col-12">
                                    <div class="form-group mb-4">
                                        <textarea class="form-control" name="message" rows="6" placeholder="Votre message..." required></textarea>
                                    </div>
                                </div>
                                <div class="col-12">
                                    <button type="submit" class="btn amado-btn w-100">
                                        <i class="fas fa-paper-plane mr-2"></i>
                                        <span class="button-text">Envoyer le message</span>
                                    </button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- ##### Contact Area End ##### -->