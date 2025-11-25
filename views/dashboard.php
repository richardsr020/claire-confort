<?php
// Vérification de la connexion seulement
if (!isset($_SESSION['admin_logged_in']) || $_SESSION['admin_logged_in'] !== true) {
    header('Location: index.php?page=admin-login');
    exit();
}
?>

<!-- Inclusion du CSS du dashboard -->
<link rel="stylesheet" href="assets/css/dashboard.css">

<section class="dashboard">
    <!-- Header Dashboard -->
    <div class="dashboard-header">
        <div class="container">
            <div class="dashboard-nav">
                    <div class="mobile-nav">
                        <!-- Navbar Brand -->
                        <div class="amado-navbar-brand">
                            <a href="index.php?page=home">
                                <img src="assets/images/claire_icon.png" alt="Claire Confort" class="logo-icon">
                                <span class="logo-text">Claire<span style="color: #f39422;">Confort</span></span>
                            </a>
                        </div>

                    </div>
                
                <div class="nav-actions">
                    <!-- Bouton Retour à l'accueil -->
                    <a href="index.php?page=home" class="btn btn-secondary btn-home">
                        <i class="fas fa-home"></i>
                        <span class="btn-text">Retour au site</span>
                    </a>
                    
                    <!-- Menu mobile -->
                    <button class="mobile-menu-btn" id="mobileMenuBtn">
                        <i class="fas fa-bars"></i>
                    </button>
                    
                    <div class="user-menu">
                        <button class="user-btn" id="userMenuBtn">
                            <i class="fas fa-user-circle"></i>
                            <span id="userEmail">Chargement...</span>
                            <i class="fas fa-chevron-down"></i>
                        </button>
                        <div class="user-dropdown" id="userDropdown">
                            <div class="dropdown-item user-info">
                                <i class="fas fa-user"></i>
                                <div>
                                    <strong id="dropdownEmail">Chargement...</strong>
                                    <small>Administrateur</small>
                                </div>
                            </div>
                            <div class="dropdown-divider"></div>
                            <a href="app/auth.php?action=logout" class="dropdown-item logout">
                                <i class="fas fa-sign-out-alt"></i>
                                Déconnexion
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Main Dashboard -->
    <div class="dashboard-main">
        <div class="container">
            <div class="dashboard-layout">
                <!-- Sidebar Mobile Overlay -->
                <div class="mobile-sidebar-overlay" id="mobileOverlay"></div>
                
                <!-- Sidebar -->
                <aside class="dashboard-sidebar" id="dashboardSidebar">
                    <div class="sidebar-header">
                        <h3>Navigation</h3>
                        <button class="sidebar-close" id="sidebarClose">
                            <i class="fas fa-times"></i>
                        </button>
                    </div>
                    <nav class="sidebar-nav">
                        <div class="nav-section">
                            <h3>Tableau de bord</h3>
                            <a href="#overview" class="nav-link active" data-section="overview">
                                <i class="fas fa-chart-pie"></i>
                                <span>Aperçu</span>
                            </a>
                        </div>

                        <div class="nav-section">
                            <h3>Gestion</h3>
                            <a href="#products" class="nav-link" data-section="products">
                                <i class="fas fa-boxes"></i>
                                <span>Produits</span>
                                <span class="badge" id="productsCountBadge">0</span>
                            </a>
                            <a href="#categories" class="nav-link" data-section="categories">
                                <i class="fas fa-tags"></i>
                                <span>Catégories</span>
                                <span class="badge" id="categoriesCountBadge">0</span>
                            </a>
                        </div>

                        <div class="nav-section">
                            <h3>Communication</h3>
                            <a href="#contacts" class="nav-link" data-section="contacts">
                                <i class="fas fa-envelope"></i>
                                <span>Messages</span>
                                <span class="badge badge-primary" id="messagesCountBadge">0</span>
                            </a>
                        </div>

                        <div class="nav-section">
                            <h3>Paramètres</h3>
                            <a href="#settings" class="nav-link" data-section="settings">
                                <i class="fas fa-cog"></i>
                                <span>Configuration</span>
                            </a>
                        </div>
                    </nav>
                </aside>

                <!-- Content -->
                <main class="dashboard-content">
                    <!-- Section Aperçu -->
                    <div class="content-section active" id="overview-section">
                        <div class="section-header">
                            <h1>Tableau de bord</h1>
                            <p>Bienvenue dans votre espace d'administration Claire Confort</p>
                        </div>

                        <!-- Statistiques -->
                        <div class="stats-grid" id="statsGrid">
                            <div class="stat-card">
                                <div class="stat-icon primary">
                                    <i class="fas fa-boxes"></i>
                                </div>
                                <div class="stat-info">
                                    <h3 id="productsCount">0</h3>
                                    <p>Produits actifs</p>
                                </div>
                                <div class="stat-loading">
                                    <i class="fas fa-spinner fa-spin"></i>
                                </div>
                            </div>

                            <div class="stat-card">
                                <div class="stat-icon success">
                                    <i class="fas fa-tags"></i>
                                </div>
                                <div class="stat-info">
                                    <h3 id="categoriesCount">0</h3>
                                    <p>Catégories</p>
                                </div>
                                <div class="stat-loading">
                                    <i class="fas fa-spinner fa-spin"></i>
                                </div>
                            </div>

                            <div class="stat-card">
                                <div class="stat-icon warning">
                                    <i class="fas fa-envelope"></i>
                                </div>
                                <div class="stat-info">
                                    <h3 id="unreadMessagesCount">0</h3>
                                    <p>Messages non lus</p>
                                </div>
                                <div class="stat-loading">
                                    <i class="fas fa-spinner fa-spin"></i>
                                </div>
                            </div>

                            <div class="stat-card">
                                <div class="stat-icon info">
                                    <i class="fas fa-chart-line"></i>
                                </div>
                                <div class="stat-info">
                                    <h3 id="totalStock">0</h3>
                                    <p>Stock total</p>
                                </div>
                                <div class="stat-loading">
                                    <i class="fas fa-spinner fa-spin"></i>
                                </div>
                            </div>
                        </div>

                        <!-- Messages récents et Actions rapides -->
                        <div class="content-grid">
                            <div class="activity-card">
                                <div class="card-header">
                                    <h3>Messages récents</h3>
                                    <a href="#contacts" class="nav-link" data-section="contacts" style="font-size: 0.9rem;">
                                        Voir tous
                                    </a>
                                </div>
                                <div class="card-body">
                                    <div id="recentMessagesContainer">
                                        <div class="loading-state">
                                            <i class="fas fa-spinner fa-spin"></i>
                                            <p>Chargement des messages...</p>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="quick-actions-card">
                                <div class="card-header">
                                    <h3>Actions rapides</h3>
                                </div>
                                <div class="card-body">
                                    <div class="quick-actions">
                                        <button class="quick-action" onclick="dashboard.showProductModal()">
                                            <i class="fas fa-plus"></i>
                                            <span>Ajouter un produit</span>
                                        </button>
                                        <button class="quick-action" onclick="dashboard.showCategoryModal()">
                                            <i class="fas fa-tag"></i>
                                            <span>Gérer les catégories</span>
                                        </button>
                                        <button class="quick-action" onclick="dashboard.switchSection('contacts')">
                                            <i class="fas fa-envelope"></i>
                                            <span>Voir les messages</span>
                                        </button>
                                        <button class="quick-action" onclick="dashboard.switchSection('settings')">
                                            <i class="fas fa-cog"></i>
                                            <span>Paramètres du site</span>
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Section Produits -->
                    <div class="content-section" id="products-section">
                        <div class="section-header">
                            <div class="header-title">
                                <h1>Gestion des produits</h1>
                                <p>Créez et gérez votre catalogue de produits</p>
                            </div>
                            <div class="header-actions">
                                <button class="btn btn-primary" onclick="dashboard.showProductModal()">
                                    <i class="fas fa-plus"></i>
                                    <span class="btn-text">Ajouter un produit</span>
                                </button>
                            </div>
                        </div>
                        
                        <!-- Filtres et recherche -->
                        <div class="filters-bar">
                            <div class="search-box">
                                <i class="fas fa-search"></i>
                                <input type="text" id="productSearch" placeholder="Rechercher un produit..." onkeyup="dashboard.filterProducts()">
                            </div>
                            <div class="filter-actions">
                                <select id="categoryFilter" onchange="dashboard.filterProducts()">
                                    <option value="">Toutes les catégories</option>
                                </select>
                                <select id="stockFilter" onchange="dashboard.filterProducts()">
                                    <option value="">Tous les stocks</option>
                                    <option value="in_stock">En stock</option>
                                    <option value="low_stock">Stock faible</option>
                                    <option value="out_of_stock">Rupture</option>
                                </select>
                            </div>
                        </div>
                        
                        <div id="productsContainer">
                            <div class="loading-state">
                                <i class="fas fa-spinner fa-spin"></i>
                                <p>Chargement des produits...</p>
                            </div>
                        </div>
                    </div>

                    <!-- Section Catégories -->
                    <div class="content-section" id="categories-section">
                        <div class="section-header">
                            <div class="header-title">
                                <h1>Gestion des catégories</h1>
                                <p>Organisez vos produits par catégories</p>
                            </div>
                            <div class="header-actions">
                                <button class="btn btn-primary" onclick="dashboard.showCategoryModal()">
                                    <i class="fas fa-plus"></i>
                                    <span class="btn-text">Ajouter une catégorie</span>
                                </button>
                            </div>
                        </div>
                        <div id="categoriesContainer">
                            <div class="loading-state">
                                <i class="fas fa-spinner fa-spin"></i>
                                <p>Chargement des catégories...</p>
                            </div>
                        </div>
                    </div>

                    <!-- Section Messages -->
                    <div class="content-section" id="contacts-section">
                        <div class="section-header">
                            <div class="header-title">
                                <h1>Messages des clients</h1>
                                <p>Gérez les demandes de contact</p>
                            </div>
                            <div class="header-actions">
                                <div class="filter-buttons">
                                    <button class="btn btn-outline active" data-filter="all">Tous</button>
                                    <button class="btn btn-outline" data-filter="unread">Non lus</button>
                                    <button class="btn btn-outline" data-filter="read">Lus</button>
                                </div>
                            </div>
                        </div>
                        <div id="contactsContainer">
                            <div class="loading-state">
                                <i class="fas fa-spinner fa-spin"></i>
                                <p>Chargement des messages...</p>
                            </div>
                        </div>
                    </div>

                    <!-- Section Paramètres -->
                    <div class="content-section" id="settings-section">
                        <div class="section-header">
                            <h1>Paramètres du site</h1>
                            <p>Configurez les préférences de votre site</p>
                        </div>
                        <div id="settingsContainer">
                            <div class="loading-state">
                                <i class="fas fa-spinner fa-spin"></i>
                                <p>Chargement des paramètres...</p>
                            </div>
                        </div>
                    </div>
                </main>
            </div>
        </div>
    </div>
</section>

<!-- Inclusion du JavaScript du dashboard -->
<script src="assets/js/dashboard.js"></script>