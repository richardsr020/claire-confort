views/home.php
    <header class="main-header">
        <div class="container">
            <div class="logo">
                <i class="fas fa-spray-can"></i>
                <span class="logo-text">Claire<span>Confort</span></span>
            </div>
            
            <button class="mobile-menu" id="mobileMenu">
                <i class="fas fa-bars"></i>
            </button>
            
            <nav class="main-nav" id="mainNav">
                <ul>
                    <li><a href="index.php?page=home" class="nav-link">Accueil</a></li>
                    <li><a href="index.php?page=products" class="nav-link">Produits</a></li>
                    <li><a href="index.php?page=dashboard" class="nav-link">Dashboard</a></li>
                </ul>
            </nav>
            
            <div class="header-actions">
                <a href="index.php?page=admin-login" class="btn-login">
                    <i class="fas fa-sign-in-alt"></i>
                    <span class="login-text">Connexion</span>
                </a>
            </div>
        </div>
    </header>
    
<section class="hero">
    <div class="hero-slides">
        <div class="hero-slide hero-slide-1 active">
            <div class="container">
                <div class="hero-content">
                    <div class="hero-text">
                        <h1 class="hero-title">Solutions de Nettoyage Professionnelles</h1>
                        <p class="hero-description">Des produits écologiques et efficaces pour tous vos besoins de nettoyage - ONG, Entreprises & Particuliers</p>
                        <div class="hero-buttons">
                            <a href="index.php?page=products" class="btn btn-primary">
                                <i class="fas fa-shopping-cart"></i>
                                Découvrir nos produits
                            </a>
                            <a href="#contact" class="btn btn-secondary">
                                <i class="fas fa-phone"></i>
                                Nous contacter
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
        <div class="hero-slide hero-slide-2">
            <div class="container">
                <div class="hero-content">
                    <div class="hero-text">
                        <h1 class="hero-title">Qualité et Respect de l'Environnement</h1>
                        <p class="hero-description">Des formulations professionnelles pour des résultats impeccables et durables dans le respect de la nature</p>
                        <div class="hero-buttons">
                            <a href="index.php?page=products" class="btn btn-primary">
                                <i class="fas fa-leaf"></i>
                                Produits Écologiques
                            </a>
                            <a href="#about" class="btn btn-secondary">
                                <i class="fas fa-info-circle"></i>
                                En savoir plus
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <div class="slide-dots">
        <div class="slide-dot active" data-slide="0"></div>
        <div class="slide-dot" data-slide="1"></div>
    </div>
</section>

<section class="features">
    <div class="container">
        <h2 class="section-title">Pourquoi Choisir Claire Confort ?</h2>
        <div class="features-grid">
            <div class="feature-card">
                <div class="feature-icon">
                    <i class="fas fa-leaf"></i>
                </div>
                <h3>Écologique</h3>
                <p>Nos produits sont respectueux de l'environnement, biodégradables et fabriqués selon des procédés durables.</p>
            </div>
            
            <div class="feature-card">
                <div class="feature-icon">
                    <i class="fas fa-award"></i>
                </div>
                <h3>Haute Qualité</h3>
                <p>Des formulations professionnelles testées et approuvées pour des résultats impeccables et durables.</p>
            </div>
            
            <div class="feature-card">
                <div class="feature-icon">
                    <i class="fas fa-shipping-fast"></i>
                </div>
                <h3>Livraison Rapide</h3>
                <p>Expédition sous 24h pour toutes les commandes avec suivi en temps réel de votre livraison.</p>
            </div>

            <div class="feature-card">
                <div class="feature-icon">
                    <i class="fas fa-hand-holding-usd"></i>
                </div>
                <h3>Prix Compétitifs</h3>
                <p>Des tarifs avantageux pour les professionnels et les particuliers sans compromis sur la qualité.</p>
            </div>

            <div class="feature-card">
                <div class="feature-icon">
                    <i class="fas fa-headset"></i>
                </div>
                <h3>Support 7j/7</h3>
                <p>Une équipe dédiée pour vous accompagner dans le choix et l'utilisation de nos produits.</p>
            </div>

            <div class="feature-card">
                <div class="feature-icon">
                    <i class="fas fa-certificate"></i>
                </div>
                <h3>Certifié</h3>
                <p>Tous nos produits répondent aux normes internationales de qualité et de sécurité.</p>
            </div>
        </div>
    </div>
</section>

<section class="presentation" id="about">
    <div class="container">
        <div class="presentation-content">
            <div class="presentation-text">
                <h2 class="section-title">Notre Engagement Qualité</h2>
                <p class="presentation-description">Forte de son expertise dans le domaine des produits d'entretien, Claire Confort s'engage à fournir des solutions de nettoyage innovantes, efficaces et respectueuses de l'environnement.</p>
                
                <div class="stats-grid">
                    <div class="stat-item">
                        <div class="stat-number">500+</div>
                        <div class="stat-label">Clients Satisfaits</div>
                    </div>
                    <div class="stat-item">
                        <div class="stat-number">50+</div>
                        <div class="stat-label">Produits</div>
                    </div>
                    <div class="stat-item">
                        <div class="stat-number">98%</div>
                        <div class="stat-label">Satisfaction Client</div>
                    </div>
                    <div class="stat-item">
                        <div class="stat-number">24h</div>
                        <div class="stat-label">Livraison</div>
                    </div>
                </div>

                <div class="commitment-list">
                    <div class="commitment-item">
                        <i class="fas fa-check-circle"></i>
                        <span>Produits 100% biodégradables</span>
                    </div>
                    <div class="commitment-item">
                        <i class="fas fa-check-circle"></i>
                        <span>Fabrication responsable</span>
                    </div>
                    <div class="commitment-item">
                        <i class="fas fa-check-circle"></i>
                        <span>Emballages recyclables</span>
                    </div>
                    <div class="commitment-item">
                        <i class="fas fa-check-circle"></i>
                        <span>Support technique inclus</span>
                    </div>
                </div>
            </div>
            
            <div class="presentation-visual">
                <div class="visual-card">
                    <div class="card-icon">
                        <i class="fas fa-recycle"></i>
                    </div>
                    <h4>Éco-responsable</h4>
                    <p>Engagés dans une démarche environnementale durable</p>
                </div>
                <div class="visual-card">
                    <div class="card-icon">
                        <i class="fas fa-flask"></i>
                    </div>
                    <h4>Innovation</h4>
                    <p>Recherche et développement permanents</p>
                </div>
                <div class="visual-card">
                    <div class="card-icon">
                        <i class="fas fa-users"></i>
                    </div>
                    <h4>Proximité</h4>
                    <p>À l'écoute de vos besoins spécifiques</p>
                </div>
            </div>
        </div>
    </div>
</section>

<section class="products-preview">
    <div class="container">
        <h2 class="section-title">Nos Produits Populaires</h2>
        <p class="section-subtitle">Découvrez notre sélection de produits les plus appréciés par nos clients</p>
        
        <div class="products-grid">
            <div class="product-card">
                <div class="product-image">
                    <i class="fas fa-pump-soap"></i>
                    <div class="product-badge">Best Seller</div>
                </div>
                <div class="product-info">
                    <h3>Nettoyant Multi-Surfaces</h3>
                    <p>Élimine efficacement la saleté sur toutes les surfaces sans rayures. Idéal pour le quotidien.</p>
                    <div class="product-features">
                        <span><i class="fas fa-check"></i> Écologique</span>
                        <span><i class="fas fa-check"></i> Sans parfum</span>
                    </div>
                    <div class="product-price">
                        <span class="price">12,99 €</span>
                        <span class="old-price">15,99 €</span>
                    </div>
                    <a href="index.php?page=products" class="btn btn-primary btn-small">Voir détails</a>
                </div>
            </div>
            
            <div class="product-card">
                <div class="product-image">
                    <i class="fas fa-wind"></i>
                    <div class="product-badge">Nouveau</div>
                </div>
                <div class="product-info">
                    <h3>Désinfectant Air & Surfaces</h3>
                    <p>Élimine 99,9% des bactéries et virus. Parfait pour les espaces sensibles.</p>
                    <div class="product-features">
                        <span><i class="fas fa-check"></i> Action rapide</span>
                        <span><i class="fas fa-check"></i> Odeur fraîche</span>
                    </div>
                    <div class="product-price">
                        <span class="price">15,50 €</span>
                    </div>
                    <a href="index.php?page=products" class="btn btn-primary btn-small">Voir détails</a>
                </div>
            </div>
            
            <div class="product-card">
                <div class="product-image">
                    <i class="fas fa-hand-sparkles"></i>
                </div>
                <div class="product-info">
                    <h3>Gel Hydroalcoolique</h3>
                    <p>Protection efficace contre les germes. Format pratique pour une utilisation nomade.</p>
                    <div class="product-features">
                        <span><i class="fas fa-check"></i> 70% alcool</span>
                        <span><i class="fas fa-check"></i> Hydratant</span>
                    </div>
                    <div class="product-price">
                        <span class="price">8,75 €</span>
                        <span class="old-price">10,99 €</span>
                    </div>
                    <a href="index.php?page=products" class="btn btn-primary btn-small">Voir détails</a>
                </div>
            </div>
        </div>
        
        <div class="text-center">
            <a href="index.php?page=products" class="btn btn-secondary">
                <i class="fas fa-store"></i>
                Voir tous les produits
            </a>
        </div>
    </div>
</section>

<section class="testimonials">
    <div class="container">
        <h2 class="section-title">Ils Nous Font Confiance</h2>
        <p class="section-subtitle">Découvrez les témoignages de nos clients satisfaits</p>
        
        <div class="testimonials-grid">
            <div class="testimonial-card">
                <div class="testimonial-content">
                    <div class="stars">
                        <i class="fas fa-star"></i>
                        <i class="fas fa-star"></i>
                        <i class="fas fa-star"></i>
                        <i class="fas fa-star"></i>
                        <i class="fas fa-star"></i>
                    </div>
                    <p class="testimonial-text">"Les produits Claire Confort ont révolutionné notre processus de nettoyage. Efficaces, écologiques et économiques !"</p>
                </div>
                <div class="testimonial-author">
                    <div class="author-avatar">MJ</div>
                    <div class="author-info">
                        <h4>Marie Joseph</h4>
                        <p>Responsable Entretien, ONG Santé Plus</p>
                    </div>
                </div>
            </div>
            
            <div class="testimonial-card">
                <div class="testimonial-content">
                    <div class="stars">
                        <i class="fas fa-star"></i>
                        <i class="fas fa-star"></i>
                        <i class="fas fa-star"></i>
                        <i class="fas fa-star"></i>
                        <i class="fas fa-star"></i>
                    </div>
                    <p class="testimonial-text">"Service client exceptionnel et produits de qualité. Je recommande vivement à toutes les entreprises !"</p>
                </div>
                <div class="testimonial-author">
                    <div class="author-avatar">PD</div>
                    <div class="author-info">
                        <h4>Pierre Dubois</h4>
                        <p>Directeur, Hôtel Belle Vue</p>
                    </div>
                </div>
            </div>
            
            <div class="testimonial-card">
                <div class="testimonial-content">
                    <div class="stars">
                        <i class="fas fa-star"></i>
                        <i class="fas fa-star"></i>
                        <i class="fas fa-star"></i>
                        <i class="fas fa-star"></i>
                        <i class="fas fa-star-half-alt"></i>
                    </div>
                    <p class="testimonial-text">"Enfin des produits qui nettoient efficacement sans nuire à l'environnement. Bravo pour cette démarche éco-responsable !"</p>
                </div>
                <div class="testimonial-author">
                    <div class="author-avatar">SC</div>
                    <div class="author-info">
                        <h4>Sophie Camara</h4>
                        <p>Particulier</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<section class="contact" id="contact">
    <div class="container">
        <h2 class="section-title">Contactez-nous</h2>
        <p class="section-subtitle">Une question ? Un projet ? Notre équipe vous répond sous 24h</p>
        
        <div class="contact-grid">
            <div class="contact-info">
                <div class="contact-item">
                    <div class="contact-icon">
                        <i class="fas fa-phone"></i>
                    </div>
                    <div class="contact-details">
                        <h3>Téléphone</h3>
                        <p><?php echo COMPANY_PHONE1; ?></p>
                        <p><?php echo COMPANY_PHONE2; ?></p>
                    </div>
                </div>
                
                <div class="contact-item">
                    <div class="contact-icon">
                        <i class="fas fa-envelope"></i>
                    </div>
                    <div class="contact-details">
                        <h3>Email</h3>
                        <p><?php echo COMPANY_EMAIL; ?></p>
                    </div>
                </div>
                
                <div class="contact-item">
                    <div class="contact-icon">
                        <i class="fas fa-clock"></i>
                    </div>
                    <div class="contact-details">
                        <h3>Horaires</h3>
                        <p>Lun - Ven: 8h00 - 18h00</p>
                        <p>Sam: 9h00 - 13h00</p>
                    </div>
                </div>

                <div class="contact-item">
                    <div class="contact-icon">
                        <i class="fas fa-map-marker-alt"></i>
                    </div>
                    <div class="contact-details">
                        <h3>Zone d'Intervention</h3>
                        <p>Partout en République Démocratique du Congo</p>
                        <p>Livraison internationale disponible</p>
                    </div>
                </div>
            </div>
            
            <div class="contact-form">
                <form id="contactForm">
                    
                    <div class="form-group">
                        <input type="email" name="email" placeholder="Votre adresse email" required>
                    </div>
                    <div class="form-group">
                        <textarea name="message" placeholder="Votre message..." rows="6" required></textarea>
                    </div>
                    <button type="submit" class="btn btn-primary btn-full">
                        <i class="fas fa-paper-plane"></i>
                        Envoyer le message
                    </button>
                </form>
            </div>
        </div>
    </div>
</section>