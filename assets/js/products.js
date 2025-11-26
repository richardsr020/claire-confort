class ProductsManager {
    constructor() {
        this.products = [];
        this.categories = [];
        this.filteredProducts = [];
        
        this.activeFilters = {
            category: 'all',
            price: 'all',
            stock: 'all',
            search: ''
        };

        this.init();
    }

    async init() {
        try {
            await this.loadCategories();
            await this.loadProducts();
            this.setupEventListeners();
        } catch (error) {
            console.error('Initialization error:', error);
            this.showError('Erreur lors de l\'initialisation');
        }
    }

    async loadProducts() {
        try {
            this.showLoading();
            
            const response = await fetch('app/products-api.php?action=getProducts');
            
            if (!response.ok) {
                throw new Error(`HTTP error! status: ${response.status}`);
            }
            
            const data = await response.json();

            if (data.success) {
                this.products = data.products;
                this.filteredProducts = [...this.products];
                this.displayProducts();
            } else {
                throw new Error(data.message || 'Erreur inconnue');
            }
        } catch (error) {
            console.error('Error loading products:', error);
            this.showError('Erreur lors du chargement des produits: ' + error.message);
        }
    }

    async loadCategories() {
        try {
            const response = await fetch('app/products-api.php?action=getCategories');
            
            if (!response.ok) {
                throw new Error(`HTTP error! status: ${response.status}`);
            }
            
            const data = await response.json();

            if (data.success) {
                this.categories = data.categories;
                this.populateCategoryFilters();
            } else {
                console.error('Error loading categories:', data.message);
            }
        } catch (error) {
            console.error('Error loading categories:', error);
        }
    }

    populateCategoryFilters() {
        const categoryFilters = document.getElementById('categoryFilters');
        
        if (!categoryFilters) {
            console.error('Category filters container not found');
            return;
        }

        // Vider les options existantes (sauf "Tous")
        const allOption = categoryFilters.querySelector('[data-category="all"]');
        categoryFilters.innerHTML = '';
        if (allOption) {
            categoryFilters.appendChild(allOption);
        }

        // Ajouter les catégories dynamiquement
        this.categories.forEach(category => {
            const option = document.createElement('div');
            option.className = 'filter-option';
            option.setAttribute('data-category', category.slug);
            option.textContent = category.name;
            categoryFilters.appendChild(option);
        });

        // Réattacher les event listeners
        this.setupCategoryEventListeners();
    }

    setupEventListeners() {
        this.setupCategoryEventListeners();
        this.setupPriceEventListeners();
        this.setupStockEventListeners();
        this.setupSearchEventListener();
    }

    setupCategoryEventListeners() {
        document.querySelectorAll('#categoryFilters .filter-option').forEach(option => {
            option.addEventListener('click', () => {
                const category = option.getAttribute('data-category');
                this.setFilter('category', category);
            });
        });
    }

    setupPriceEventListeners() {
        document.querySelectorAll('#priceFilters .filter-option').forEach(option => {
            option.addEventListener('click', () => {
                const price = option.getAttribute('data-price');
                this.setFilter('price', price);
            });
        });
    }

    setupStockEventListeners() {
        document.querySelectorAll('#stockFilters .filter-option').forEach(option => {
            option.addEventListener('click', () => {
                const stock = option.getAttribute('data-stock');
                this.setFilter('stock', stock);
            });
        });
    }

    setupSearchEventListener() {
        const searchInput = document.getElementById('productSearch');
        if (searchInput) {
            searchInput.addEventListener('input', (e) => {
                this.setFilter('search', e.target.value);
            });
        }
    }

    setFilter(type, value) {
        this.activeFilters[type] = value;
        this.updateActiveFilterButtons(type, value);
        this.applyFilters();
    }

    updateActiveFilterButtons(type, value) {
        const filterGroup = document.getElementById(`${type}Filters`);
        if (filterGroup) {
            filterGroup.querySelectorAll('.filter-option').forEach(option => {
                option.classList.remove('active');
            });

            const activeOption = filterGroup.querySelector(`[data-${type}="${value}"]`);
            if (activeOption) {
                activeOption.classList.add('active');
            }
        }
    }

    applyFilters() {
        this.filteredProducts = this.products.filter(product => {
            // Filtre par catégorie
            if (this.activeFilters.category !== 'all' && product.category_slug !== this.activeFilters.category) {
                return false;
            }

            // Filtre par prix
            if (this.activeFilters.price !== 'all') {
                const price = parseFloat(product.price);
                const [min, max] = this.activeFilters.price.split('-').map(Number);
                
                if (max && (price < min || price > max)) return false;
                if (!max && price < min) return false;
            }

            // Filtre par stock
            if (this.activeFilters.stock !== 'all') {
                const stock = parseInt(product.stock_quantity);
                if (this.activeFilters.stock === 'available' && stock <= 0) return false;
                if (this.activeFilters.stock === 'low' && stock > 5) return false;
            }

            // Filtre par recherche
            if (this.activeFilters.search) {
                const searchTerm = this.activeFilters.search.toLowerCase();
                const nameMatch = product.name.toLowerCase().includes(searchTerm);
                const descMatch = product.description.toLowerCase().includes(searchTerm);
                const categoryMatch = product.category_name.toLowerCase().includes(searchTerm);
                
                if (!nameMatch && !descMatch && !categoryMatch) return false;
            }

            return true;
        });

        this.displayProducts();
    }

    displayProducts() {
        const grid = document.getElementById('productsGrid');
        const noProducts = document.getElementById('noProducts');

        if (!grid || !noProducts) {
            console.error('Required DOM elements not found');
            return;
        }

        if (this.filteredProducts.length === 0) {
            grid.style.display = 'none';
            noProducts.style.display = 'block';
            return;
        }

        grid.style.display = 'grid';
        noProducts.style.display = 'none';
        
        grid.innerHTML = this.filteredProducts.map(product => this.createProductCard(product)).join('');
    }

    createProductCard(product) {
        const stockStatus = this.getStockStatus(product.stock_quantity);
        const badge = this.getProductBadge(product);
        const features = this.extractFeatures(product.description);

        return `
            <div class="product-card" data-category="${product.category_slug}" data-price="${product.price}" data-stock="${stockStatus}">
                <div class="product-image">
                    <img src="${product.image_url}" alt="${product.name}" onerror="this.src='assets/images/notfound.png'">
                    ${badge ? `<div class="product-badge">${badge}</div>` : ''}
                </div>
                <div class="product-content">
                    <div class="product-category">${product.category_name}</div>
                    <h3 class="product-title">${product.name}</h3>
                    <p class="product-description">${product.description.substring(0, 120)}${product.description.length > 120 ? '...' : ''}</p>
                    
                    ${features.length > 0 ? `
                    <div class="product-features">
                        ${features.map(feature => `
                            <span class="feature-tag ${this.getFeatureClass(feature)}">${feature}</span>
                        `).join('')}
                    </div>
                    ` : ''}
                    
                    <div class="product-meta">
                        <div class="product-price">
                            ${parseFloat(product.price).toFixed(2)} $
                        </div>
                        <div class="product-stock ${this.getStockClass(stockStatus)}">
                            ${this.getStockText(product.stock_quantity)}
                        </div>
                    </div>
                    
                    ${product.weight ? `<div class="product-weight" style="font-size: 0.9rem; color: #6c757d; margin-bottom: 1rem;">Poids: ${product.weight} kg</div>` : ''}
                    
                </div>
            </div>
        `;
    }

    getStockStatus(stockQuantity) {
        const stock = parseInt(stockQuantity);
        if (stock > 10) return 'available';
        if (stock > 0) return 'low';
        return 'out';
    }

    getStockClass(stockStatus) {
        const classes = {
            'available': 'stock-available',
            'low': 'stock-low',
            'out': 'stock-out'
        };
        return classes[stockStatus] || 'stock-out';
    }

    getStockText(stockQuantity) {
        const stock = parseInt(stockQuantity);
        if (stock > 10) return 'En stock';
        if (stock > 0) return `${stock} restant(s)`;
        return 'Rupture';
    }

    getProductBadge(product) {
        const stock = parseInt(product.stock_quantity);
        const price = parseFloat(product.price);
        
        if (stock > 0 && price < 10) return 'Promo';
        if (product.category_name.toLowerCase().includes('éco') || product.category_name.toLowerCase().includes('bio')) return 'Éco';
        if (stock <= 5 && stock > 0) return 'Derniers';
        return null;
    }

    extractFeatures(description) {
        const features = [];
        const keywords = ['écologique', 'bio', 'professionnel', 'concentré', 'rapide', 'efficace', 'naturel', 'désinfectant', 'hydratant'];
        
        keywords.forEach(keyword => {
            if (description.toLowerCase().includes(keyword)) {
                features.push(keyword.charAt(0).toUpperCase() + keyword.slice(1));
            }
        });

        return features.slice(0, 3);
    }

    getFeatureClass(feature) {
        const featureLower = feature.toLowerCase();
        if (featureLower.includes('éco') || featureLower.includes('bio') || featureLower.includes('naturel')) return 'eco';
        if (featureLower.includes('pro')) return 'pro';
        return '';
    }

    viewProductDetails(productId) {
        console.log('View product details:', productId);
        // À implémenter: redirection vers page détails
        // window.location.href = `index.php?page=product-details&id=${productId}`;
    }

    toggleFavorite(productId) {
        console.log('Toggle favorite:', productId);
        // À implémenter: logique des favoris
    }

    showLoading() {
        const grid = document.getElementById('productsGrid');
        if (grid) {
            grid.innerHTML = `
                <div class="loading-state">
                    <i class="fas fa-spinner fa-spin"></i>
                    <p>Chargement des produits...</p>
                </div>
            `;
        }
    }

    showError(message) {
        const grid = document.getElementById('productsGrid');
        if (grid) {
            grid.innerHTML = `
                <div class="error-state">
                    <i class="fas fa-exclamation-triangle"></i>
                    <h4>Erreur</h4>
                    <p>${message}</p>
                    <button class="btn-details mt-3" onclick="productsManager.loadProducts()">
                        <i class="fas fa-redo mr-2"></i>Réessayer
                    </button>
                </div>
            `;
        }
    }
}

// Initialiser le gestionnaire de produits quand le DOM est chargé
document.addEventListener('DOMContentLoaded', function() {
    window.productsManager = new ProductsManager();
});