<!-- views/products.php -->
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

<section class="products-hero">
    <div class="container">
        <div class="products-hero-content">
            <h1 class="products-title">Nos Produits de Nettoyage</h1>
            <p class="products-subtitle">Découvrez notre gamme complète de produits professionnels pour tous vos besoins d'entretien</p>
        </div>
    </div>
</section>

<section class="products-filters">
    <div class="container">
        <div class="filters-container">
            <div class="search-box">
                <i class="fas fa-search"></i>
                <input type="text" id="searchInput" placeholder="Rechercher un produit...">
            </div>
            
            <div class="filter-group">
                <select id="categoryFilter" class="filter-select">
                    <option value="">Toutes les catégories</option>
                    <option value="nettoyants">Nettoyants Multi-Surfaces</option>
                    <option value="desinfectants">Désinfectants</option>
                    <option value="hygiene-mains">Hygiène des Mains</option>
                    <option value="specialises">Produits Spécialisés</option>
                    <option value="materiel">Matériel de Nettoyage</option>
                </select>
                
                <select id="sortFilter" class="filter-select">
                    <option value="name">Trier par nom</option>
                    <option value="price-asc">Prix croissant</option>
                    <option value="price-desc">Prix décroissant</option>
                    <option value="popular">Plus populaires</option>
                </select>
            </div>
        </div>
    </div>
</section>

<section class="products-listing">
    <div class="container">
        <div class="products-stats">
            <span id="productsCount">12 produits</span>
            <span id="filterStatus" class="filter-status"></span>
        </div>
        
        <div class="products-grid" id="productsGrid">
            <!-- Produits chargés dynamiquement -->
        </div>
        
        <div class="loading-spinner" id="loadingSpinner">
            <i class="fas fa-spinner fa-spin"></i>
            <span>Chargement des produits...</span>
        </div>
        
        <div class="no-products" id="noProducts" style="display: none;">
            <i class="fas fa-search"></i>
            <h3>Aucun produit trouvé</h3>
            <p>Aucun produit ne correspond à vos critères de recherche.</p>
            <button class="btn btn-primary" onclick="resetFilters()">
                <i class="fas fa-redo"></i>
                Réinitialiser les filtres
            </button>
        </div>
        
        <div class="load-more" id="loadMore">
            <button class="btn btn-secondary" onclick="loadMoreProducts()">
                <i class="fas fa-plus"></i>
                Charger plus de produits
            </button>
        </div>
    </div>
</section>

<section class="products-cta">
    <div class="container">
        <div class="cta-content">
            <h2>Vous ne trouvez pas ce que vous cherchez ?</h2>
            <p>Notre équipe est à votre disposition pour vous conseiller sur les produits adaptés à vos besoins spécifiques.</p>
            <div class="cta-buttons">
                <a href="#contact" class="btn btn-primary">
                    <i class="fas fa-phone"></i>
                    Nous contacter
                </a>
                <a href="index.php?page=home" class="btn btn-secondary">
                    <i class="fas fa-home"></i>
                    Retour à l'accueil
                </a>
            </div>
        </div>
    </div>
</section>

<!-- Modal de détail produit -->
<div class="product-modal" id="productModal">
    <div class="modal-content">
        <button class="modal-close" id="modalClose">
            <i class="fas fa-times"></i>
        </button>
        
        <div class="modal-body" id="modalBody">
            <!-- Contenu du modal chargé dynamiquement -->
        </div>
    </div>
</div>
<script src="assets/js/products.js"></script>