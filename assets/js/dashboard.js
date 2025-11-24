// assets/js/dashboard.js - VERSION CORRIGÉE ET COMPLÈTE
/**
 * CLASSE PRINCIPALE DASHBOARD - VERSION COMPLÈTE
 * Gère l'interface d'administration complète
 * @class Dashboard
 */
class Dashboard {
    constructor() {
        this.currentSection = 'overview';
        this.currentProductId = null;
        this.currentCategoryId = null;
        this.products = [];
        this.categories = [];
        this.contacts = [];
        this.init();
    }

    /**
     * INITIALISATION
     * Lance le dashboard et configure les événements
     */
    init() {
        this.setupEventListeners();
        this.setupNavigation();
        this.loadUserInfo();
        this.loadOverviewData();
        
        // Charger les données initiales
        this.loadCategoriesForFilters();
    }

    // ================================
    // GESTION DES ÉVÉNEMENTS
    // ================================

    /**
     * Configure tous les écouteurs d'événements
     */
    setupEventListeners() {
        this.setupUserMenu();
        this.setupMobileMenu();
        this.setupContactFilters();
    }

    /**
     * Gestion du menu utilisateur (dropdown)
     */
    setupUserMenu() {
        const userMenuBtn = document.getElementById('userMenuBtn');
        const userDropdown = document.getElementById('userDropdown');
        
        if (userMenuBtn && userDropdown) {
            userMenuBtn.addEventListener('click', (e) => {
                e.stopPropagation();
                userDropdown.classList.toggle('show');
            });
            
            document.addEventListener('click', () => {
                userDropdown.classList.remove('show');
            });
        }
    }

    /**
     * Configuration du menu mobile
     */
    setupMobileMenu() {
        const mobileMenuBtn = document.getElementById('mobileMenuBtn');
        const sidebar = document.getElementById('dashboardSidebar');
        const sidebarClose = document.getElementById('sidebarClose');
        const mobileOverlay = document.getElementById('mobileOverlay');

        if (mobileMenuBtn && sidebar) {
            mobileMenuBtn.addEventListener('click', () => {
                sidebar.classList.add('mobile-open');
                if (mobileOverlay) mobileOverlay.classList.add('show');
            });
        }

        if (sidebarClose) {
            sidebarClose.addEventListener('click', () => {
                sidebar.classList.remove('mobile-open');
                if (mobileOverlay) mobileOverlay.classList.remove('show');
            });
        }

        if (mobileOverlay) {
            mobileOverlay.addEventListener('click', () => {
                sidebar.classList.remove('mobile-open');
                mobileOverlay.classList.remove('show');
            });
        }
    }

    /**
     * Configuration des filtres de contacts
     */
    setupContactFilters() {
        // Sera appelé quand la section contacts sera chargée
    }

    /**
     * Configuration de la navigation entre sections
     */
    setupNavigation() {
        const navLinks = document.querySelectorAll('.nav-link');
        
        navLinks.forEach(link => {
            link.addEventListener('click', (e) => {
                e.preventDefault();
                this.handleNavigation(link);
            });
        });

        // Fermer le menu mobile lors du clic sur un lien
        navLinks.forEach(link => {
            link.addEventListener('click', () => {
                const sidebar = document.getElementById('dashboardSidebar');
                const mobileOverlay = document.getElementById('mobileOverlay');
                if (sidebar) sidebar.classList.remove('mobile-open');
                if (mobileOverlay) mobileOverlay.classList.remove('show');
            });
        });
    }

    /**
     * Gère le clic sur un lien de navigation
     * @param {HTMLElement} link - Lien cliqué
     */
    handleNavigation(link) {
        // Mettre à jour la navigation
        document.querySelectorAll('.nav-link').forEach(nav => nav.classList.remove('active'));
        link.classList.add('active');
        
        // Changer de section
        const sectionId = link.getAttribute('data-section');
        this.switchSection(sectionId);
    }

    /**
     * Change de section dans le dashboard
     * @param {string} sectionId - ID de la section à afficher
     */
    switchSection(sectionId) {
        // Masquer toutes les sections
        document.querySelectorAll('.content-section').forEach(section => {
            section.classList.remove('active');
        });
        
        // Afficher la section sélectionnée
        const targetSection = document.getElementById(`${sectionId}-section`);
        if (targetSection) {
            targetSection.classList.add('active');
            this.currentSection = sectionId;
            this.loadSectionData(sectionId);
        }
    }

    // ================================
    // CHARGEMENT DES DONNÉES
    // ================================

    /**
     * Charge les informations de l'utilisateur connecté
     */
    async loadUserInfo() {
        try {
            const response = await this.apiCall('GET', 'app/dashboard-api.php?action=getUserInfo');
            if (response.success) {
                this.updateUserInfo(response.data);
            }
        } catch (error) {
            console.error('Erreur lors du chargement des infos utilisateur:', error);
            // Fallback pour développement
            this.updateUserInfo({ email: 'admin@claireconfort.com' });
        }
    }

    /**
     * Met à jour l'affichage des informations utilisateur
     * @param {Object} userData - Données utilisateur
     */
    updateUserInfo(userData) {
        const userEmail = document.getElementById('userEmail');
        const dropdownEmail = document.getElementById('dropdownEmail');
        
        if (userEmail) userEmail.textContent = userData.email;
        if (dropdownEmail) dropdownEmail.textContent = userData.email;
    }

    /**
     * Charge les données de la vue d'ensemble
     */
    async loadOverviewData() {
        try {
            const response = await this.apiCall('GET', 'app/dashboard-api.php?action=getOverview');
            if (response.success) {
                this.updateOverview(response.data);
            }
        } catch (error) {
            console.error('Erreur lors du chargement des données overview:', error);
            this.showNotification('Erreur lors du chargement des données', 'error');
        }
    }

    /**
     * Met à jour la vue d'ensemble avec les données
     * @param {Object} data - Données de la vue d'ensemble
     */
    updateOverview(data) {
        this.updateOverviewStats(data.stats);
        this.updateRecentMessages(data.recentMessages);
        this.updateBadges(data.stats);
    }

    /**
     * Met à jour les statistiques
     * @param {Object} stats - Statistiques à afficher
     */
    updateOverviewStats(stats) {
        const productsCount = document.getElementById('productsCount');
        const categoriesCount = document.getElementById('categoriesCount');
        const unreadMessagesCount = document.getElementById('unreadMessagesCount');
        const totalStock = document.getElementById('totalStock');

        if (productsCount) productsCount.textContent = stats.productsCount;
        if (categoriesCount) categoriesCount.textContent = stats.categoriesCount;
        if (unreadMessagesCount) unreadMessagesCount.textContent = stats.unreadMessagesCount;
        if (totalStock) totalStock.textContent = stats.totalStock;

        // Cacher les loaders
        document.querySelectorAll('.stat-loading').forEach(loader => {
            loader.style.display = 'none';
        });
    }

    /**
     * Met à jour les messages récents
     * @param {Array} messages - Liste des messages
     */
    updateRecentMessages(messages) {
        const container = document.getElementById('recentMessagesContainer');
        if (!container) return;
        
        if (!messages || messages.length === 0) {
            container.innerHTML = this.createEmptyState('envelope-open', 'Aucun message pour le moment');
            return;
        }

        container.innerHTML = messages.map(message => `
            <div class="activity-item ${message.is_read ? '' : 'unread'}" onclick="dashboard.viewContact(${message.id})" style="cursor: pointer;">
                <div class="activity-icon ${message.is_read ? 'info' : 'warning'}">
                    <i class="fas fa-envelope"></i>
                </div>
                <div class="activity-content">
                    <p>
                        <strong>${this.escapeHtml(message.full_name)}</strong>
                        <small>${this.escapeHtml(message.email)}</small>
                    </p>
                    <p class="message-preview">${this.escapeHtml(message.message.substring(0, 100))}...</p>
                    <small>${this.formatDate(message.created_at)}</small>
                </div>
            </div>
        `).join('');
    }

    /**
     * Met à jour les badges de notification
     * @param {Object} stats - Statistiques pour les badges
     */
    updateBadges(stats) {
        const productsBadge = document.getElementById('productsCountBadge');
        const categoriesBadge = document.getElementById('categoriesCountBadge');
        const messagesBadge = document.getElementById('messagesCountBadge');

        if (productsBadge) productsBadge.textContent = stats.productsCount;
        if (categoriesBadge) categoriesBadge.textContent = stats.categoriesCount;
        if (messagesBadge) messagesBadge.textContent = stats.unreadMessagesCount;
    }

    /**
     * Charge les catégories pour les filtres
     */
    async loadCategoriesForFilters() {
        try {
            const response = await this.apiCall('GET', 'app/dashboard-api.php?action=getCategories');
            if (response.success) {
                this.categories = response.data;
                this.updateCategoryFilters();
            }
        } catch (error) {
            console.error('Erreur chargement catégories pour filtres:', error);
        }
    }

    /**
     * Met à jour les filtres de catégories
     */
    updateCategoryFilters() {
        const categoryFilter = document.getElementById('categoryFilter');
        if (!categoryFilter) return;

        categoryFilter.innerHTML = '<option value="">Toutes les catégories</option>' +
            this.categories.map(cat => 
                `<option value="${cat.id}">${this.escapeHtml(cat.name)}</option>`
            ).join('');
    }

    /**
     * Charge les données d'une section spécifique
     * @param {string} sectionId - ID de la section
     */
    async loadSectionData(sectionId) {
        const containers = {
            'products': 'productsContainer',
            'categories': 'categoriesContainer',
            'contacts': 'contactsContainer',
            'settings': 'settingsContainer'
        };

        const containerId = containers[sectionId];
        if (!containerId) return;

        const container = document.getElementById(containerId);
        if (!container) return;

        this.showLoadingState(container);

        try {
            const response = await this.apiCall('GET', `app/dashboard-api.php?action=get${this.capitalizeFirst(sectionId)}`);
            
            if (response.success) {
                this[`render${this.capitalizeFirst(sectionId)}`](response.data, container);
            } else {
                throw new Error(response.message || 'Erreur lors du chargement');
            }
        } catch (error) {
            console.error(`Erreur lors du chargement de ${sectionId}:`, error);
            this.showErrorState(container, sectionId);
        }
    }

    // ================================
    // GESTION DES PRODUITS
    // ================================

    /**
     * Affiche la liste des produits
     * @param {Array} products - Liste des produits
     * @param {HTMLElement} container - Conteneur d'affichage
     */
    renderProducts(products, container) {
        this.products = products;
        
        if (!products || products.length === 0) {
            container.innerHTML = this.createEmptyState(
                'boxes', 
                'Aucun produit pour le moment',
                'Ajouter un produit',
                () => this.showProductModal()
            );
            return;
        }

        container.innerHTML = `
            <div class="table-container">
                <table class="data-table">
                    <thead>
                        <tr>
                            <th>Nom</th>
                            <th>Catégorie</th>
                            <th>Prix</th>
                            <th>Stock</th>
                            <th>Créé le</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        ${products.map(product => this.createProductRow(product)).join('')}
                    </tbody>
                </table>
            </div>
        `;
    }

    /**
     * Crée une ligne de produit pour le tableau
     * @param {Object} product - Données du produit
     * @returns {string} HTML de la ligne
     */
    createProductRow(product) {
        const stockStatus = product.stock_quantity > 10 ? 'in-stock' : 
                           product.stock_quantity > 0 ? 'low-stock' : 'out-of-stock';
        
        return `
            <tr>
                <td>
                    <div class="product-info">
                        <strong>${this.escapeHtml(product.name)}</strong>
                        ${product.short_description ? 
                            `<small>${this.escapeHtml(product.short_description)}</small>` : ''
                        }
                    </div>
                </td>
                <td>${this.escapeHtml(product.category_name || 'Non catégorisé')}</td>
                <td><strong>${parseFloat(product.price).toFixed(2)} €</strong></td>
                <td>
                    <span class="stock-badge ${stockStatus}">
                        ${product.stock_quantity}
                    </span>
                </td>
                <td>${this.formatDate(product.created_at)}</td>
                <td>
                    <div class="action-buttons">
                        <button class="btn-icon" onclick="dashboard.editProduct(${product.id})" title="Modifier">
                            <i class="fas fa-edit"></i>
                        </button>
                        <button class="btn-icon danger" onclick="dashboard.deleteProduct(${product.id})" title="Supprimer">
                            <i class="fas fa-trash"></i>
                        </button>
                    </div>
                </td>
            </tr>
        `;
    }

    /**
     * Filtre les produits selon les critères
     */
    filterProducts() {
        const searchTerm = document.getElementById('productSearch')?.value.toLowerCase() || '';
        const categoryFilter = document.getElementById('categoryFilter')?.value || '';
        const stockFilter = document.getElementById('stockFilter')?.value || '';

        const filteredProducts = this.products.filter(product => {
            // Filtre par recherche
            const matchesSearch = product.name.toLowerCase().includes(searchTerm) ||
                                (product.short_description && product.short_description.toLowerCase().includes(searchTerm));
            
            // Filtre par catégorie
            const matchesCategory = !categoryFilter || product.category_id == categoryFilter;
            
            // Filtre par stock
            let matchesStock = true;
            if (stockFilter === 'in_stock') {
                matchesStock = product.stock_quantity > 10;
            } else if (stockFilter === 'low_stock') {
                matchesStock = product.stock_quantity > 0 && product.stock_quantity <= 10;
            } else if (stockFilter === 'out_of_stock') {
                matchesStock = product.stock_quantity === 0;
            }
            
            return matchesSearch && matchesCategory && matchesStock;
        });

        this.renderFilteredProducts(filteredProducts);
    }

    /**
     * Affiche les produits filtrés
     * @param {Array} filteredProducts - Produits filtrés
     */
    renderFilteredProducts(filteredProducts) {
        const container = document.getElementById('productsContainer');
        if (!container) return;

        if (filteredProducts.length === 0) {
            container.innerHTML = '<div class="empty-state"><p>Aucun produit ne correspond aux critères</p></div>';
            return;
        }

        const tableBody = container.querySelector('tbody');
        if (tableBody) {
            tableBody.innerHTML = filteredProducts.map(product => this.createProductRow(product)).join('');
        }
    }

    /**
     * Affiche le modal d'ajout/édition de produit
     * @param {number|null} productId - ID du produit à éditer (null pour création)
     */
    async showProductModal(productId = null) {
        this.currentProductId = productId;
        
        try {
            const categories = await this.loadCategories();
            
            if (productId) {
                await this.loadProductForEdit(productId, categories);
            } else {
                this.showProductForm(categories, null);
            }
        } catch (error) {
            console.error('Erreur préparation modal produit:', error);
            this.showNotification('Erreur lors du chargement des données', 'error');
        }
    }

    /**
     * Charge un produit pour édition
     * @param {number} productId - ID du produit
     * @param {Array} categories - Liste des catégories
     */
    async loadProductForEdit(productId, categories) {
        try {
            const response = await this.apiCall('GET', `app/dashboard-api.php?action=getProduct&id=${productId}`);
            if (response.success) {
                this.showProductForm(categories, response.data);
            } else {
                this.showNotification('Erreur lors du chargement du produit', 'error');
            }
        } catch (error) {
            console.error('Erreur chargement produit:', error);
            this.showNotification('Erreur lors du chargement du produit', 'error');
        }
    }

    /**
     * Affiche le formulaire produit
     * @param {Array} categories - Liste des catégories
     * @param {Object|null} product - Données du produit (null pour création)
     */
    showProductForm(categories, product) {
        const isEdit = !!product;
        const modalHTML = this.createProductModalHTML(isEdit, categories, product);
        
        // Supprimer l'ancien modal s'il existe
        const existingModal = document.getElementById('productModal');
        if (existingModal) existingModal.remove();
        
        document.body.insertAdjacentHTML('beforeend', modalHTML);
    }

    /**
     * Crée le HTML du modal produit
     * @param {boolean} isEdit - Mode édition
     * @param {Array} categories - Liste des catégories
     * @param {Object|null} product - Données du produit
     * @returns {string} HTML du modal
     */
    createProductModalHTML(isEdit, categories, product) {
        return `
            <div class="modal show" id="productModal">
                <div class="modal-content large">
                    <div class="modal-header">
                        <h3>${isEdit ? 'Modifier le produit' : 'Ajouter un produit'}</h3>
                        <button type="button" class="modal-close" onclick="dashboard.closeModal('productModal')">
                            <i class="fas fa-times"></i>
                        </button>
                    </div>
                    <div class="modal-body">
                        <form id="productForm" onsubmit="dashboard.handleProductSubmit(event)">
                            ${isEdit ? '<input type="hidden" name="id" value="' + product.id + '">' : ''}
                            ${this.createProductFormFields(categories, product)}
                            ${this.createFormActions()}
                        </form>
                    </div>
                </div>
            </div>
        `;
    }

    /**
     * Crée les champs du formulaire produit avec upload d'image
     * @param {Array} categories - Liste des catégories
     * @param {Object|null} product - Données du produit
     * @returns {string} HTML des champs
     */
    createProductFormFields(categories, product) {
        const hasImage = product && product.image_path;
        
        return `
            <div class="form-grid">
                <!-- Section Upload d'Image -->
                <div class="form-group full-width">
                    <label for="productImage">Image du produit</label>
                    <div class="image-upload-container">
                        <div class="image-preview">
                            ${hasImage ? `
                                <img src="uploads/products/${product.image_path}" alt="Preview" class="preview-image" id="imagePreview">
                                <button type="button" class="remove-image" onclick="dashboard.removeProductImage()">
                                    <i class="fas fa-times"></i>
                                </button>
                            ` : `
                                <div class="image-placeholder" id="imagePlaceholder">
                                    <i class="fas fa-image"></i>
                                    <span>Aucune image</span>
                                </div>
                            `}
                        </div>
                        <input type="file" id="productImage" name="image" accept="image/*" 
                            onchange="dashboard.previewImage(this)" style="display: none;">
                        <button type="button" class="btn btn-secondary" onclick="document.getElementById('productImage').click()">
                            <i class="fas fa-upload"></i>
                            Choisir une image
                        </button>
                        ${hasImage ? `
                            <input type="hidden" name="remove_image" id="removeImage" value="false">
                        ` : ''}
                    </div>
                </div>
                
                <div class="form-group">
                    <label for="productName">Nom du produit *</label>
                    <input type="text" id="productName" name="name" required 
                        value="${product ? this.escapeHtml(product.name) : ''}">
                </div>
                
                <div class="form-group">
                    <label for="productCategory">Catégorie *</label>
                    <select id="productCategory" name="category_id" required>
                        <option value="">Sélectionnez une catégorie</option>
                        ${categories.map(cat => `
                            <option value="${cat.id}" ${product && product.category_id == cat.id ? 'selected' : ''}>
                                ${this.escapeHtml(cat.name)}
                            </option>
                        `).join('')}
                    </select>
                </div>
                
                <div class="form-group">
                    <label for="productPrice">Prix de vente ($) *</label>
                    <input type="number" id="productPrice" name="price" step="0.01" min="0" required
                        value="${product ? parseFloat(product.price).toFixed(2) : ''}">
                </div>
                
                <div class="form-group">
                    <label for="productStock">Quantité en stock</label>
                    <input type="number" id="productStock" name="stock_quantity" min="0"
                        value="${product ? product.stock_quantity : 0}">
                </div>
                
                <div class="form-group full-width">
                    <label for="productDescription">Description complète</label>
                    <textarea id="productDescription" name="description" rows="4">${product ? this.escapeHtml(product.description) : ''}</textarea>
                </div>
            </div>
        `;
    }

    /**
     * Gère la soumission du formulaire produit
     * Version robuste avec validation, fallback et gestion d'erreurs complète
     * @param {Event} event - Événement de soumission
     */
    async handleProductSubmit(event) {
        event.preventDefault();
        
        console.group('🎯 handleProductSubmit ULTIME');
        
        try {
            const form = event.target;
            
            // CRÉATION MANUELLE du FormData pour contrôle total
            const formData = new FormData();
            
            // Ajouter tous les champs du formulaire MANUELLEMENT
            const formElements = form.elements;
            for (let element of formElements) {
                if (element.name && element.type !== 'file') {
                    if (element.type === 'checkbox' || element.type === 'radio') {
                        if (element.checked) {
                            formData.append(element.name, element.value);
                        }
                    } else {
                        formData.append(element.name, element.value);
                    }
                    console.log(`📝 ${element.name}:`, element.value);
                }
            }
            
            // Gestion MANUELLE de l'image
            const imageInput = document.getElementById('productImage');
            if (imageInput && imageInput.files[0]) {
                const imageFile = imageInput.files[0];
                formData.append('image', imageFile);
                console.log(`📁 image:`, {
                    name: imageFile.name,
                    type: imageFile.type,
                    size: imageFile.size + ' bytes'
                });
            } else {
                console.log('❌ Aucun fichier image dans l\'input');
            }
            
            // Gestion MANUELLE de remove_image
            const removeImageInput = document.getElementById('removeImage');
            if (removeImageInput && removeImageInput.value === 'true') {
                formData.append('remove_image', 'true');
                console.log('🗑️ remove_image: true');
            }
            
            const isEdit = !!formData.get('id');
            console.log('📋 Mode:', isEdit ? 'Édition' : 'Création');
            
            // VALIDATION FORCÉE en FormData
            console.log('🔄 Envoi FORCÉ en FormData...');
            const response = await this.apiCallWithFormData(
                'POST', 
                `app/dashboard-api.php?action=${isEdit ? 'updateProduct' : 'addProduct'}`,
                formData
            );

            if (response.success) {
                const message = isEdit ? 'Produit modifié avec succès' : 'Produit ajouté avec succès';
                console.log('✅ Succès:', message);
                this.showNotification(message, 'success');
                
                this.closeModal('productModal');
                setTimeout(() => {
                    this.loadSectionData('products');
                    this.loadOverviewData();
                }, 500);
                
            } else {
                console.error('❌ Erreur API:', response.message);
                this.showNotification(response.message || 'Erreur lors de la sauvegarde', 'error');
            }

        } catch (error) {
            console.error('💥 Erreur critique:', error);
            this.showNotification('Erreur: ' + error.message, 'error');
        } finally {
            console.groupEnd();
        }
    }


    /**
     * Effectue un appel API avec FormData - VERSION ULTIME DEBUG
     */
    async apiCallWithFormData(method, url, formData) {
        console.group('🚀 apiCallWithFormData ULTIME');
        
        try {
            // ANALYSE COMPLÈTE du FormData
            console.log('🔍 Analyse FormData:');
            let entryCount = 0;
            let hasImage = false;
            
            for (let [key, value] of formData.entries()) {
                entryCount++;
                if (value instanceof File) {
                    console.log(`   📁 ${key}:`, {
                        name: value.name,
                        type: value.type,
                        size: value.size + ' bytes',
                        isFile: true
                    });
                    hasImage = true;
                } else {
                    console.log(`   📝 ${key}:`, value, `(type: ${typeof value})`);
                }
            }
            
            console.log(`📊 Total entrées: ${entryCount}, Image: ${hasImage}`);
            
            if (entryCount === 0) {
                throw new Error('FormData VIDE - aucune entrée trouvée');
            }
            
            // CONFIGURATION SPÉCIFIQUE pour FormData
            const controller = new AbortController();
            const timeoutId = setTimeout(() => controller.abort(), 30000);

            console.log('📤 Envoi requête...');
            const response = await fetch(url, {
                method: method,
                body: formData,
                signal: controller.signal,
                // IMPORTANT: Pas de headers pour FormData
            });

            clearTimeout(timeoutId);

            // ANALYSE de la réponse
            console.log('📥 Statut réponse:', response.status, response.statusText);
            
            const responseText = await response.text();
            console.log('📄 Réponse brute:', responseText);

            if (!response.ok) {
                throw new Error(`HTTP ${response.status}: ${response.statusText}`);
            }

            const jsonResponse = JSON.parse(responseText);
            console.log('✅ Réponse JSON:', jsonResponse);
            
            console.groupEnd();
            return jsonResponse;

        } catch (error) {
            console.error('💥 Erreur apiCallWithFormData:', error);
            console.groupEnd();
            throw error;
        }
    }
    /**
     * Aperçu de l'image sélectionnée
     * @param {HTMLInputElement} input - Input file
     */
    previewImage(input) {
        if (input.files && input.files[0]) {
            const reader = new FileReader();
            
            reader.onload = function(e) {
                // Cacher le placeholder
                const placeholder = document.getElementById('imagePlaceholder');
                if (placeholder) placeholder.style.display = 'none';
                
                // Afficher l'image
                let preview = document.getElementById('imagePreview');
                if (!preview) {
                    preview = document.createElement('img');
                    preview.id = 'imagePreview';
                    preview.className = 'preview-image';
                    preview.alt = 'Preview';
                    
                    const removeBtn = document.createElement('button');
                    removeBtn.type = 'button';
                    removeBtn.className = 'remove-image';
                    removeBtn.innerHTML = '<i class="fas fa-times"></i>';
                    removeBtn.onclick = () => dashboard.removeProductImage();
                    
                    const previewContainer = document.querySelector('.image-preview');
                    previewContainer.innerHTML = '';
                    previewContainer.appendChild(preview);
                    previewContainer.appendChild(removeBtn);
                }
                
                preview.src = e.target.result;
            };
            
            reader.readAsDataURL(input.files[0]);
            
            // Réinitialiser le flag de suppression
            const removeInput = document.getElementById('removeImage');
            if (removeInput) {
                removeInput.value = 'false';
            }
        }
    }

    /**
     * Supprime l'image sélectionnée
     */
    removeProductImage() {
        // Réinitialiser l'input file
        const imageInput = document.getElementById('productImage');
        if (imageInput) imageInput.value = '';
        
        // Cacher l'aperçu
        const preview = document.getElementById('imagePreview');
        if (preview) preview.style.display = 'none';
        
        // Afficher le placeholder
        const placeholder = document.getElementById('imagePlaceholder');
        if (placeholder) placeholder.style.display = 'flex';
        
        // Marquer l'image pour suppression
        const removeInput = document.getElementById('removeImage');
        if (removeInput) {
            removeInput.value = 'true';
        } else {
            // Créer l'input hidden si il n'existe pas
            const hiddenInput = document.createElement('input');
            hiddenInput.type = 'hidden';
            hiddenInput.name = 'remove_image';
            hiddenInput.id = 'removeImage';
            hiddenInput.value = 'true';
            document.querySelector('.image-upload-container').appendChild(hiddenInput);
        }
    }

    /**
     * Traite les données du formulaire produit
     * @param {Object} data - Données brutes du formulaire
     * @returns {Object} Données traitées
     */
    processProductData(data) {
        return {
            ...data,
            price: parseFloat(data.price),
            compare_price: data.compare_price ? parseFloat(data.compare_price) : null,
            cost_price: data.cost_price ? parseFloat(data.cost_price) : null,
            stock_quantity: parseInt(data.stock_quantity) || 0,
            category_id: parseInt(data.category_id)
            // short_description est supprimé
        };
    }

    /**
     * Édite un produit
     * @param {number} productId - ID du produit
     */
    editProduct(productId) {
        this.showProductModal(productId);
    }

    /**
     * Supprime un produit
     * @param {number} productId - ID du produit
     */
    async deleteProduct(productId) {
        if (!confirm('Êtes-vous sûr de vouloir supprimer ce produit ? Cette action est irréversible.')) {
            return;
        }

        try {
            const response = await this.apiCall('GET', `app/dashboard-api.php?action=deleteProduct&id=${productId}`);
            
            if (response.success) {
                this.showNotification('Produit supprimé avec succès', 'success');
                this.loadSectionData('products');
                this.loadOverviewData(); // Mettre à jour les stats
            } else {
                this.showNotification(response.message || 'Erreur lors de la suppression', 'error');
            }
        } catch (error) {
            console.error('Erreur suppression produit:', error);
            this.showNotification('Erreur lors de la suppression du produit', 'error');
        }
    }

    // ================================
    // GESTION DES CATÉGORIES - NOUVELLES FONCTIONS
    // ================================

    /**
     * Affiche la liste des catégories
     * @param {Array} categories - Liste des catégories
     * @param {HTMLElement} container - Conteneur d'affichage
     */
    renderCategories(categories, container) {
        this.categories = categories;
        
        if (!categories || categories.length === 0) {
            container.innerHTML = this.createEmptyState(
                'tags',
                'Aucune catégorie pour le moment',
                'Ajouter une catégorie',
                () => this.showCategoryModal()
            );
            return;
        }

        container.innerHTML = `
            <div class="categories-grid">
                ${categories.map(category => this.createCategoryCard(category)).join('')}
            </div>
        `;
    }

    /**
     * Crée une carte de catégorie
     * @param {Object} category - Données de la catégorie
     * @returns {string} HTML de la carte
     */
    createCategoryCard(category) {
        return `
            <div class="category-card">
                <div class="category-header">
                    <h3>${this.escapeHtml(category.name)}</h3>
                    <span class="status-badge ${category.is_active ? 'active' : 'inactive'}">
                        ${category.is_active ? 'Active' : 'Inactive'}
                    </span>
                </div>
                <p class="category-description">${this.escapeHtml(category.description || 'Aucune description')}</p>
                <div class="category-stats">
                    <span>${category.product_count || 0} produits</span>
                </div>
                <div class="category-actions">
                    <button class="btn btn-secondary" onclick="dashboard.editCategory(${category.id})">
                        <i class="fas fa-edit"></i>
                        Modifier
                    </button>
                    <button class="btn btn-danger" onclick="dashboard.deleteCategory(${category.id})">
                        <i class="fas fa-trash"></i>
                        Supprimer
                    </button>
                </div>
            </div>
        `;
    }

    /**
     * Affiche le modal d'ajout/édition de catégorie
     * @param {number|null} categoryId - ID de la catégorie à éditer
     */
    async showCategoryModal(categoryId = null) {
        this.currentCategoryId = categoryId;
        
        if (categoryId) {
            await this.loadCategoryForEdit(categoryId);
        } else {
            this.showCategoryForm(null);
        }
    }

    /**
     * Charge une catégorie pour édition
     * @param {number} categoryId - ID de la catégorie
     */
    async loadCategoryForEdit(categoryId) {
        try {
            const response = await this.apiCall('GET', `app/dashboard-api.php?action=getCategory&id=${categoryId}`);
            if (response.success) {
                this.showCategoryForm(response.data);
            } else {
                this.showNotification('Erreur lors du chargement de la catégorie', 'error');
            }
        } catch (error) {
            console.error('Erreur chargement catégorie:', error);
            this.showNotification('Erreur lors du chargement de la catégorie', 'error');
        }
    }

    /**
     * Affiche le formulaire catégorie
     * @param {Object|null} category - Données de la catégorie
     */
    showCategoryForm(category) {
        const isEdit = !!category;
        const modalHTML = this.createCategoryModalHTML(isEdit, category);
        
        // Supprimer l'ancien modal s'il existe
        const existingModal = document.getElementById('categoryModal');
        if (existingModal) existingModal.remove();
        
        document.body.insertAdjacentHTML('beforeend', modalHTML);
    }

    /**
     * Crée le HTML du modal catégorie
     * @param {boolean} isEdit - Mode édition
     * @param {Object|null} category - Données de la catégorie
     * @returns {string} HTML du modal
     */
    createCategoryModalHTML(isEdit, category) {
        return `
            <div class="modal show" id="categoryModal">
                <div class="modal-content">
                    <div class="modal-header">
                        <h3>${isEdit ? 'Modifier la catégorie' : 'Ajouter une catégorie'}</h3>
                        <button type="button" class="modal-close" onclick="dashboard.closeModal('categoryModal')">
                            <i class="fas fa-times"></i>
                        </button>
                    </div>
                    <div class="modal-body">
                        <form id="categoryForm" onsubmit="dashboard.handleCategorySubmit(event)">
                            ${isEdit ? '<input type="hidden" name="id" value="' + category.id + '">' : ''}
                            <div class="form-group">
                                <label for="categoryName">Nom de la catégorie *</label>
                                <input type="text" id="categoryName" name="name" required 
                                       value="${category ? this.escapeHtml(category.name) : ''}">
                            </div>
                            <div class="form-group">
                                <label for="categoryDescription">Description</label>
                                <textarea id="categoryDescription" name="description" rows="3">${category ? this.escapeHtml(category.description) : ''}</textarea>
                            </div>
                            <div class="form-group">
                                <label class="checkbox-label">
                                    <input type="checkbox" name="is_active" ${category && category.is_active ? 'checked' : 'checked'}>
                                    <span class="checkmark"></span>
                                    Catégorie active
                                </label>
                            </div>
                            ${this.createFormActions()}
                        </form>
                    </div>
                </div>
            </div>
        `;
    }

    /**
     * Gère la soumission du formulaire catégorie
     * @param {Event} event - Événement de soumission
     */
    async handleCategorySubmit(event) {
        event.preventDefault();
        const formData = new FormData(event.target);
        const data = Object.fromEntries(formData.entries());
        
        const processedData = {
            ...data,
            is_active: data.is_active === 'on'
        };
        
        const isEdit = !!data.id;
        
        try {
            const response = await this.apiCall('POST', 
                `app/dashboard-api.php?action=${isEdit ? 'updateCategory' : 'addCategory'}`,
                processedData
            );
            
            if (response.success) {
                this.showNotification(
                    isEdit ? 'Catégorie modifiée avec succès' : 'Catégorie ajoutée avec succès', 
                    'success'
                );
                this.closeModal('categoryModal');
                this.loadSectionData('categories');
                this.loadCategoriesForFilters(); // Mettre à jour les filtres
                this.loadOverviewData(); // Mettre à jour les stats
            } else {
                this.showNotification(response.message || 'Erreur lors de la sauvegarde', 'error');
            }
        } catch (error) {
            console.error('Erreur sauvegarde catégorie:', error);
            this.showNotification('Erreur lors de la sauvegarde de la catégorie', 'error');
        }
    }

    /**
     * Édite une catégorie
     * @param {number} categoryId - ID de la catégorie
     */
    editCategory(categoryId) {
        this.showCategoryModal(categoryId);
    }

    /**
     * Supprime une catégorie
     * @param {number} categoryId - ID de la catégorie
     */
    async deleteCategory(categoryId) {
        if (!confirm('Êtes-vous sûr de vouloir supprimer cette catégorie ? Les produits associés deviendront non catégorisés.')) {
            return;
        }

        try {
            const response = await this.apiCall('GET', `app/dashboard-api.php?action=deleteCategory&id=${categoryId}`);
            
            if (response.success) {
                this.showNotification('Catégorie supprimée avec succès', 'success');
                this.loadSectionData('categories');
                this.loadCategoriesForFilters(); // Mettre à jour les filtres
                this.loadOverviewData(); // Mettre à jour les stats
            } else {
                this.showNotification(response.message || 'Erreur lors de la suppression', 'error');
            }
        } catch (error) {
            console.error('Erreur suppression catégorie:', error);
            this.showNotification('Erreur lors de la suppression de la catégorie', 'error');
        }
    }

    // ================================
    // GESTION DES CONTACTS - NOUVELLES FONCTIONS
    // ================================

    /**
     * Affiche la liste des contacts
     * @param {Array} contacts - Liste des contacts
     * @param {HTMLElement} container - Conteneur d'affichage
     */
    renderContacts(contacts, container) {
        this.contacts = contacts;
        
        if (!contacts || contacts.length === 0) {
            container.innerHTML = this.createEmptyState('envelope-open', 'Aucun message pour le moment');
            return;
        }

        container.innerHTML = `
            <div class="table-container">
                <table class="data-table">
                    <thead>
                        <tr>
                            <th>Nom</th>
                            <th>Email</th>
                            <th>Message</th>
                            <th>Date</th>
                            <th>Statut</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        ${contacts.map(contact => this.createContactRow(contact)).join('')}
                    </tbody>
                </table>
            </div>
        `;
    }

    /**
     * Crée une ligne de contact pour le tableau
     * @param {Object} contact - Données du contact
     * @returns {string} HTML de la ligne
     */
    createContactRow(contact) {
        return `
            <tr class="${contact.is_read ? '' : 'unread'}">
                <td>${this.escapeHtml(contact.full_name)}</td>
                <td>${this.escapeHtml(contact.email)}</td>
                <td class="message-preview">${this.escapeHtml(contact.message.substring(0, 100))}...</td>
                <td>${this.formatDate(contact.created_at)}</td>
                <td>
                    <span class="status-badge ${contact.is_read ? 'active' : 'inactive'}">
                        ${contact.is_read ? 'Lu' : 'Non lu'}
                    </span>
                </td>
                <td>
                    <div class="action-buttons">
                        <button class="btn-icon" onclick="dashboard.viewContact(${contact.id})" title="Voir">
                            <i class="fas fa-eye"></i>
                        </button>
                        <button class="btn-icon danger" onclick="dashboard.deleteContact(${contact.id})" title="Supprimer">
                            <i class="fas fa-trash"></i>
                        </button>
                    </div>
                </td>
            </tr>
        `;
    }

    /**
     * Affiche un message de contact
     * @param {number} contactId - ID du contact
     */
    async viewContact(contactId) {
        try {
            const response = await this.apiCall('GET', `app/dashboard-api.php?action=getContact&id=${contactId}`);
            
            if (response.success) {
                this.showContactModal(response.data);
                
                // Marquer comme lu si ce n'est pas déjà fait
                if (!response.data.is_read) {
                    await this.markContactAsRead(contactId);
                }
            } else {
                this.showNotification('Erreur lors du chargement du message', 'error');
            }
        } catch (error) {
            console.error('Erreur chargement contact:', error);
            this.showNotification('Erreur lors du chargement du message', 'error');
        }
    }

    /**
     * Marque un message comme lu
     * @param {number} contactId - ID du contact
     */
    async markContactAsRead(contactId) {
        try {
            await this.apiCall('POST', 'app/dashboard-api.php?action=updateContact', {
                id: contactId,
                is_read: true
            });
            
            // Mettre à jour l'affichage
            this.loadSectionData('contacts');
            this.loadOverviewData();
        } catch (error) {
            console.error('Erreur marquage message comme lu:', error);
        }
    }

    /**
     * Affiche le modal de visualisation d'un contact
     * @param {Object} contact - Données du contact
     */
    showContactModal(contact) {
        const modalHTML = `
            <div class="modal show" id="contactModal">
                <div class="modal-content">
                    <div class="modal-header">
                        <h3>Message de ${this.escapeHtml(contact.full_name)}</h3>
                        <button type="button" class="modal-close" onclick="dashboard.closeModal('contactModal')">
                            <i class="fas fa-times"></i>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div class="contact-info">
                            <div class="info-item">
                                <strong>Nom:</strong>
                                <span>${this.escapeHtml(contact.full_name)}</span>
                            </div>
                            <div class="info-item">
                                <strong>Email:</strong>
                                <span>${this.escapeHtml(contact.email)}</span>
                            </div>
                            <div class="info-item">
                                <strong>Date:</strong>
                                <span>${this.formatDate(contact.created_at)}</span>
                            </div>
                            <div class="info-item">
                                <strong>Statut:</strong>
                                <span class="status-badge ${contact.is_read ? 'active' : 'inactive'}">
                                    ${contact.is_read ? 'Lu' : 'Non lu'}
                                </span>
                            </div>
                        </div>
                        <div class="message-content">
                            <strong>Message:</strong>
                            <div class="message-text">${this.escapeHtml(contact.message).replace(/\n/g, '<br>')}</div>
                        </div>
                        <div class="modal-actions">
                            <button type="button" class="btn btn-secondary" onclick="dashboard.closeModal('contactModal')">
                                Fermer
                            </button>
                            <button type="button" class="btn btn-danger" onclick="dashboard.deleteContact(${contact.id})">
                                <i class="fas fa-trash"></i>
                                Supprimer
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        `;
        
        // Supprimer l'ancien modal s'il existe
        const existingModal = document.getElementById('contactModal');
        if (existingModal) existingModal.remove();
        
        document.body.insertAdjacentHTML('beforeend', modalHTML);
    }

    /**
     * Supprime un contact
     * @param {number} contactId - ID du contact
     */
    async deleteContact(contactId) {
        if (!confirm('Êtes-vous sûr de vouloir supprimer ce message ? Cette action est irréversible.')) {
            return;
        }

        try {
            const response = await this.apiCall('GET', `app/dashboard-api.php?action=deleteContact&id=${contactId}`);
            
            if (response.success) {
                this.showNotification('Message supprimé avec succès', 'success');
                this.closeModal('contactModal');
                this.loadSectionData('contacts');
                this.loadOverviewData(); // Mettre à jour les stats
            } else {
                this.showNotification(response.message || 'Erreur lors de la suppression', 'error');
            }
        } catch (error) {
            console.error('Erreur suppression contact:', error);
            this.showNotification('Erreur lors de la suppression du message', 'error');
        }
    }

    // ================================
    // GESTION DES PARAMÈTRES - NOUVELLES FONCTIONS
    // ================================

    /**
     * Affiche les paramètres
     * @param {Object} settings - Liste des paramètres
     * @param {HTMLElement} container - Conteneur d'affichage
     */
    renderSettings(settings, container) {
        container.innerHTML = `
            <div class="settings-grid">
                <div class="setting-card">
                    <h3>Paramètres généraux</h3>
                    <p>Configuration de base du site</p>
                    <button class="btn btn-primary" onclick="dashboard.editGeneralSettings()">
                        <i class="fas fa-cog"></i>
                        Modifier
                    </button>
                </div>
                
                <div class="setting-card">
                    <h3>Email de contact</h3>
                    <p>Adresse email pour recevoir les messages</p>
                    <button class="btn btn-primary" onclick="dashboard.editEmailSettings()">
                        <i class="fas fa-envelope"></i>
                        Modifier
                    </button>
                </div>
                
                <div class="setting-card">
                    <h3>Paramètres d'affichage</h3>
                    <p>Nombre d'éléments par page, etc.</p>
                    <button class="btn btn-primary" onclick="dashboard.editDisplaySettings()">
                        <i class="fas fa-desktop"></i>
                        Modifier
                    </button>
                </div>
            </div>
        `;
    }

    /**
     * Édite les paramètres généraux
     */
    editGeneralSettings() {
        this.showNotification('Fonctionnalité en cours de développement', 'info');
    }

    /**
     * Édite les paramètres email
     */
    editEmailSettings() {
        this.showNotification('Fonctionnalité en cours de développement', 'info');
    }

    /**
     * Édite les paramètres d'affichage
     */
    editDisplaySettings() {
        this.showNotification('Fonctionnalité en cours de développement', 'info');
    }

    // ================================
    // MÉTHODES UTILITAIRES
    // ================================

    /**
     * Effectue un appel API
     * @param {string} method - Méthode HTTP
     * @param {string} url - URL de l'API
     * @param {Object|null} data - Données à envoyer
     * @returns {Promise} Réponse de l'API
     */
    async apiCall(method, url, data = null) {
        const options = {
            method: method,
            headers: {
                'Content-Type': 'application/json',
            },
        };

        if (data && method !== 'GET') {
            options.body = JSON.stringify(data);
        }

        const response = await fetch(url, options);
        
        if (!response.ok) {
            throw new Error(`Erreur HTTP: ${response.status}`);
        }
        
        return await response.json();
    }

    /**
     * Charge les catégories depuis l'API
     * @returns {Promise<Array>} Liste des catégories
     */
    async loadCategories() {
        try {
            const response = await this.apiCall('GET', 'app/dashboard-api.php?action=getCategories');
            return response.success ? response.data : [];
        } catch (error) {
            console.error('Erreur chargement catégories:', error);
            return [];
        }
    }

    /**
     * Échappe le HTML pour la sécurité
     * @param {string} text - Texte à échapper
     * @returns {string} Texte échappé
     */
    escapeHtml(text) {
        if (!text) return '';
        const div = document.createElement('div');
        div.textContent = text;
        return div.innerHTML;
    }

    /**
     * Formate une date
     * @param {string} dateString - Date à formater
     * @returns {string} Date formatée
     */
    formatDate(dateString) {
        try {
            const date = new Date(dateString);
            return date.toLocaleDateString('fr-FR', {
                day: '2-digit',
                month: '2-digit',
                year: 'numeric',
                hour: '2-digit',
                minute: '2-digit'
            });
        } catch (error) {
            return dateString;
        }
    }

    /**
     * Capitalise la première lettre
     * @param {string} string - Chaîne à capitaliser
     * @returns {string} Chaîne capitalisée
     */
    capitalizeFirst(string) {
        return string.charAt(0).toUpperCase() + string.slice(1);
    }

    /**
     * Affiche un état de chargement
     * @param {HTMLElement} container - Conteneur où afficher le loader
     */
    showLoadingState(container) {
        container.innerHTML = `
            <div class="loading-state">
                <i class="fas fa-spinner fa-spin"></i>
                <p>Chargement...</p>
            </div>
        `;
    }

    /**
     * Affiche un état d'erreur
     * @param {HTMLElement} container - Conteneur où afficher l'erreur
     * @param {string} sectionId - ID de la section
     */
    showErrorState(container, sectionId) {
        container.innerHTML = `
            <div class="error-state">
                <i class="fas fa-exclamation-triangle"></i>
                <p>Erreur lors du chargement des données</p>
                <button class="btn btn-secondary" onclick="dashboard.loadSectionData('${sectionId}')">
                    <i class="fas fa-redo"></i>
                    Réessayer
                </button>
            </div>
        `;
    }

    /**
     * Crée un état vide
     * @param {string} icon - Icône FontAwesome
     * @param {string} message - Message à afficher
     * @param {string} buttonText - Texte du bouton (optionnel)
     * @param {Function} buttonAction - Action du bouton (optionnel)
     * @returns {string} HTML de l'état vide
     */
    createEmptyState(icon, message, buttonText = null, buttonAction = null) {
        return `
            <div class="empty-state">
                <i class="fas fa-${icon}"></i>
                <p>${message}</p>
                ${buttonText && buttonAction ? `
                    <button class="btn btn-primary" onclick="${buttonAction}">
                        <i class="fas fa-plus"></i>
                        ${buttonText}
                    </button>
                ` : ''}
            </div>
        `;
    }

    /**
     * Crée les actions de formulaire
     * @returns {string} HTML des actions
     */
    createFormActions() {
        return `
            <div class="form-actions">
                <button type="button" class="btn btn-secondary" onclick="dashboard.closeModal('productModal')">
                    Annuler
                </button>
                <button type="submit" class="btn btn-primary">
                    <i class="fas fa-save"></i>
                    Sauvegarder
                </button>
            </div>
        `;
    }

    /**
     * Ferme un modal
     * @param {string} modalId - ID du modal à fermer
     */
    closeModal(modalId) {
        const modal = document.getElementById(modalId);
        if (modal) {
            modal.remove();
        }
        this.currentProductId = null;
        this.currentCategoryId = null;
    }

    /**
     * Affiche une notification
     * @param {string} message - Message à afficher
     * @param {string} type - Type de notification (success, error, warning)
     */
    showNotification(message, type = 'info') {
        // Créer une notification toast
        const notification = document.createElement('div');
        notification.className = `notification notification-${type}`;
        notification.innerHTML = `
            <div class="notification-content">
                <i class="fas fa-${this.getNotificationIcon(type)}"></i>
                <span>${message}</span>
            </div>
        `;

        document.body.appendChild(notification);

        // Animation d'entrée
        setTimeout(() => notification.classList.add('show'), 100);

        // Supprimer après 5 secondes
        setTimeout(() => {
            notification.classList.remove('show');
            setTimeout(() => notification.remove(), 300);
        }, 5000);
    }

    /**
     * Retourne l'icône correspondant au type de notification
     * @param {string} type - Type de notification
     * @returns {string} Nom de l'icône
     */
    getNotificationIcon(type) {
        const icons = {
            'success': 'check-circle',
            'error': 'exclamation-circle',
            'warning': 'exclamation-triangle',
            'info': 'info-circle'
        };
        return icons[type] || 'info-circle';
    }
}

// ================================
// INITIALISATION GLOBALE
// ================================

/**
 * Instance globale du dashboard
 * @type {Dashboard}
 */
let dashboard;

/**
 * Initialisation au chargement du DOM
 */
document.addEventListener('DOMContentLoaded', function() {
    dashboard = new Dashboard();
});

// ================================
// FONCTIONS GLOBALES (pour compatibilité)
// ================================

/**
 * Affiche le modal d'ajout de produit
 * @deprecated Utiliser dashboard.showProductModal() à la place
 */
function showAddProductModal() {
    dashboard.showProductModal();
}

/**
 * Affiche le modal d'ajout de catégorie
 * @deprecated Utiliser dashboard.showCategoryModal() à la place
 */
function showAddCategoryModal() {
    dashboard.showCategoryModal();
}

/**
 * Édite un produit
 * @deprecated Utiliser dashboard.editProduct() à la place
 * @param {number} id - ID du produit
 */
function editProduct(id) {
    dashboard.editProduct(id);
}

/**
 * Supprime un produit
 * @deprecated Utiliser dashboard.deleteProduct() à la place
 * @param {number} id - ID du produit
 */
function deleteProduct(id) {
    dashboard.deleteProduct(id);
}

/**
 * Édite une catégorie
 * @deprecated Utiliser dashboard.editCategory() à la place
 * @param {number} id - ID de la catégorie
 */
function editCategory(id) {
    dashboard.editCategory(id);
}

/**
 * Supprime une catégorie
 * @deprecated Utiliser dashboard.deleteCategory() à la place
 * @param {number} id - ID de la catégorie
 */
function deleteCategory(id) {
    dashboard.deleteCategory(id);
}

/**
 * Filtre les produits
 * @deprecated Utiliser dashboard.filterProducts() à la place
 */
function filterProducts() {
    dashboard.filterProducts();
}