// assets/js/products.js
document.addEventListener('DOMContentLoaded', function() {
    // Données des produits (simulées)
    const products = [
        {
            id: 1,
            name: "Nettoyant Multi-Surfaces Professionnel",
            category: "nettoyants",
            description: "Nettoyant universel pour toutes les surfaces. Élimine efficacement la saleté, la graisse et les taches sans rayures.",
            price: 12.99,
            oldPrice: 15.99,
            image: "fas fa-pump-soap",
            features: ["Écologique", "Sans parfum", "Action rapide"],
            badge: "sale",
            popular: true
        },
        {
            id: 2,
            name: "Désinfectant Air & Surfaces",
            category: "desinfectants",
            description: "Élimine 99,9% des bactéries et virus. Idéal pour les espaces sensibles et les surfaces fréquemment touchées.",
            price: 15.50,
            oldPrice: null,
            image: "fas fa-wind",
            features: ["Action rapide", "Odeur fraîche", "Sans alcool"],
            badge: "new",
            popular: true
        },
        {
            id: 3,
            name: "Gel Hydroalcoolique Professionnel",
            category: "hygiene-mains",
            description: "Protection efficace contre les germes avec 70% d'alcool. Formule hydratante pour les mains.",
            price: 8.75,
            oldPrice: 10.99,
            image: "fas fa-hand-sparkles",
            features: ["70% alcool", "Hydratant", "Format pratique"],
            badge: null,
            popular: true
        },
        {
            id: 4,
            name: "Nettoyant Sols et Carrelages",
            category: "nettoyants",
            description: "Spécialement formulé pour les sols et carrelages. Laisse une brillance durable et une protection anti-dérapante.",
            price: 14.25,
            oldPrice: null,
            image: "fas fa-broom",
            features: ["Brillance durable", "Anti-dérapant", "Écologique"],
            badge: null,
            popular: false
        },
        {
            id: 5,
            name: "Désodorisant Textile et Air",
            category: "desinfectants",
            description: "Élimine les mauvaises odeurs des textiles et de l'air. Parfum frais et durable.",
            price: 9.99,
            oldPrice: 12.50,
            image: "fas fa-spray-can",
            features: ["Neutralise les odeurs", "Parfum durable", "Sans gaz propulseur"],
            badge: "sale",
            popular: false
        },
        {
            id: 6,
            name: "Savon Liquide Professionnel",
            category: "hygiene-mains",
            description: "Savon liquide doux pour les mains. Formule enrichie en agents hydratants pour un lavage fréquent.",
            price: 6.50,
            oldPrice: null,
            image: "fas fa-soap",
            features: ["Doux pour la peau", "Hydratant", "Parfum frais"],
            badge: null,
            popular: false
        },
        {
            id: 7,
            name: "Détergent Linge Professionnel",
            category: "specialises",
            description: "Détergent haute performance pour le linge professionnel. Élimine les taches tenaces en machine.",
            price: 18.75,
            oldPrice: 22.99,
            image: "fas fa-tshirt",
            features: ["Haute performance", "Économique", "Respectueux des tissus"],
            badge: "sale",
            popular: true
        },
        {
            id: 8,
            name: "Nettoyant Vitres et Surfaces Lisses",
            category: "nettoyants",
            description: "Nettoyant spécial vitres et surfaces lisses. Laisse une finition sans traces ni buée.",
            price: 11.25,
            oldPrice: null,
            image: "fas fa-window-restore",
            features: ["Sans traces", "Action rapide", "Écologique"],
            badge: null,
            popular: false
        }
    ];

    let filteredProducts = [...products];
    let displayedCount = 6;
    let currentCategory = '';
    let currentSearch = '';
    let currentSort = 'name';

    // Éléments DOM
    const productsGrid = document.getElementById('productsGrid');
    const productsCount = document.getElementById('productsCount');
    const filterStatus = document.getElementById('filterStatus');
    const loadingSpinner = document.getElementById('loadingSpinner');
    const noProducts = document.getElementById('noProducts');
    const loadMore = document.getElementById('loadMore');
    const searchInput = document.getElementById('searchInput');
    const categoryFilter = document.getElementById('categoryFilter');
    const sortFilter = document.getElementById('sortFilter');
    const productModal = document.getElementById('productModal');
    const modalClose = document.getElementById('modalClose');
    const modalBody = document.getElementById('modalBody');

    // Initialisation
    function initProducts() {
        displayProducts();
        setupEventListeners();
    }

    // Configuration des événements
    function setupEventListeners() {
        searchInput.addEventListener('input', handleSearch);
        categoryFilter.addEventListener('change', handleCategoryFilter);
        sortFilter.addEventListener('change', handleSortFilter);
        modalClose.addEventListener('click', closeModal);
        
        // Fermer le modal en cliquant à l'extérieur
        productModal.addEventListener('click', function(e) {
            if (e.target === productModal) {
                closeModal();
            }
        });
        
        // Fermer le modal avec ESC
        document.addEventListener('keydown', function(e) {
            if (e.key === 'Escape' && productModal.classList.contains('active')) {
                closeModal();
            }
        });
    }

    // Gestion de la recherche
    function handleSearch(e) {
        currentSearch = e.target.value.toLowerCase();
        applyFilters();
    }

    // Gestion du filtre de catégorie
    function handleCategoryFilter(e) {
        currentCategory = e.target.value;
        applyFilters();
    }

    // Gestion du tri
    function handleSortFilter(e) {
        currentSort = e.target.value;
        applyFilters();
    }

    // Application des filtres
    function applyFilters() {
        filteredProducts = products.filter(product => {
            const matchesSearch = !currentSearch || 
                product.name.toLowerCase().includes(currentSearch) ||
                product.description.toLowerCase().includes(currentSearch);
            
            const matchesCategory = !currentCategory || product.category === currentCategory;
            
            return matchesSearch && matchesCategory;
        });

        // Tri des produits
        sortProducts();

        // Réinitialiser l'affichage
        displayedCount = 6;
        displayProducts();
        updateFilterStatus();
    }

    // Tri des produits
    function sortProducts() {
        switch(currentSort) {
            case 'price-asc':
                filteredProducts.sort((a, b) => a.price - b.price);
                break;
            case 'price-desc':
                filteredProducts.sort((a, b) => b.price - a.price);
                break;
            case 'popular':
                filteredProducts.sort((a, b) => b.popular - a.popular);
                break;
            default:
                filteredProducts.sort((a, b) => a.name.localeCompare(b.name));
        }
    }

    // Affichage des produits
    function displayProducts() {
        const productsToShow = filteredProducts.slice(0, displayedCount);
        
        if (productsToShow.length === 0) {
            productsGrid.innerHTML = '';
            noProducts.style.display = 'block';
            loadMore.style.display = 'none';
        } else {
            productsGrid.innerHTML = productsToShow.map(product => `
                <div class="product-item" onclick="openProductModal(${product.id})">
                    <div class="product-item-image">
                        <i class="${product.image}"></i>
                        ${product.badge ? `<div class="product-badge ${product.badge}">${getBadgeText(product.badge)}</div>` : ''}
                    </div>
                    <div class="product-item-content">
                        <span class="product-category">${getCategoryName(product.category)}</span>
                        <h3>${product.name}</h3>
                        <p class="product-description">${product.description}</p>
                        <div class="product-features-list">
                            ${product.features.map(feature => `
                                <span class="product-feature">
                                    <i class="fas fa-check"></i>
                                    ${feature}
                                </span>
                            `).join('')}
                        </div>
                        <div class="product-item-footer">
                            <div class="product-price">
                                <span class="product-current-price">${product.price.toFixed(2)} €</span>
                                ${product.oldPrice ? `<span class="product-old-price">${product.oldPrice.toFixed(2)} €</span>` : ''}
                            </div>
                            <div class="product-actions">
                                <button class="btn-icon" onclick="event.stopPropagation(); addToFavorites(${product.id})">
                                    <i class="far fa-heart"></i>
                                </button>
                                <button class="btn-icon" onclick="event.stopPropagation(); shareProduct(${product.id})">
                                    <i class="fas fa-share"></i>
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            `).join('');
            
            noProducts.style.display = 'none';
        }

        // Gestion du bouton "Charger plus"
        if (displayedCount >= filteredProducts.length) {
            loadMore.style.display = 'none';
        } else {
            loadMore.style.display = 'block';
        }

        // Mise à jour du compteur
        productsCount.textContent = `${filteredProducts.length} produit${filteredProducts.length > 1 ? 's' : ''}`;
    }

    // Charger plus de produits
    window.loadMoreProducts = function() {
        displayedCount += 6;
        displayProducts();
    }

    // Réinitialiser les filtres
    window.resetFilters = function() {
        searchInput.value = '';
        categoryFilter.value = '';
        sortFilter.value = 'name';
        currentSearch = '';
        currentCategory = '';
        currentSort = 'name';
        applyFilters();
    }

    // Mise à jour du statut des filtres
    function updateFilterStatus() {
        const activeFilters = [];
        
        if (currentSearch) activeFilters.push(`"${currentSearch}"`);
        if (currentCategory) activeFilters.push(getCategoryName(currentCategory));
        
        if (activeFilters.length > 0) {
            filterStatus.textContent = `Filtres: ${activeFilters.join(', ')}`;
            filterStatus.style.display = 'inline-block';
        } else {
            filterStatus.style.display = 'none';
        }
    }

    // Ouvrir le modal produit
    window.openProductModal = function(productId) {
        const product = products.find(p => p.id === productId);
        if (!product) return;

        modalBody.innerHTML = `
            <div class="modal-product">
                <div class="modal-product-image">
                    <i class="${product.image}"></i>
                    ${product.badge ? `<div class="product-badge ${product.badge}">${getBadgeText(product.badge)}</div>` : ''}
                </div>
                <div class="modal-product-content">
                    <span class="product-category">${getCategoryName(product.category)}</span>
                    <h2>${product.name}</h2>
                    <p class="modal-product-description">${product.description}</p>
                    
                    <div class="modal-product-features">
                        <h3>Caractéristiques</h3>
                        <ul>
                            ${product.features.map(feature => `<li><i class="fas fa-check"></i> ${feature}</li>`).join('')}
                        </ul>
                    </div>
                    
                    <div class="modal-product-actions">
                        <div class="modal-product-price">
                            <span class="price">${product.price.toFixed(2)} €</span>
                            ${product.oldPrice ? `<span class="old-price">${product.oldPrice.toFixed(2)} €</span>` : ''}
                        </div>
                        <div class="modal-action-buttons">
                            <button class="btn btn-primary" onclick="contactAboutProduct(${product.id})">
                                <i class="fas fa-info-circle"></i>
                                Demander des informations
                            </button>
                            <button class="btn btn-secondary" onclick="addToFavorites(${product.id})">
                                <i class="far fa-heart"></i>
                                Ajouter aux favoris
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        `;

        productModal.classList.add('active');
        document.body.style.overflow = 'hidden';
    }

    // Fermer le modal
    function closeModal() {
        productModal.classList.remove('active');
        document.body.style.overflow = 'auto';
    }

    // Fonctions utilitaires
    function getCategoryName(category) {
        const categories = {
            'nettoyants': 'Nettoyants Multi-Surfaces',
            'desinfectants': 'Désinfectants',
            'hygiene-mains': 'Hygiène des Mains',
            'specialises': 'Produits Spécialisés',
            'materiel': 'Matériel de Nettoyage'
        };
        return categories[category] || category;
    }

    function getBadgeText(badge) {
        const badges = {
            'new': 'Nouveau',
            'sale': 'Promo'
        };
        return badges[badge] || badge;
    }

    // Fonctions d'interaction
    window.addToFavorites = function(productId) {
        alert('Produit ajouté aux favoris !');
    }

    window.shareProduct = function(productId) {
        alert('Fonction de partage');
    }

    window.contactAboutProduct = function(productId) {
        window.location.href = 'index.php?page=home#contact';
    }

    // Initialisation
    initProducts();
});