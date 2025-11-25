// assets/js/contact.js
class ContactManager {
    constructor() {
        this.form = null;
        this.isSubmitting = false;
        this.init();
    }

    init() {
        this.form = document.getElementById('contactForm');
        if (!this.form) {
            console.warn('Formulaire de contact non trouvé');
            return;
        }

        this.setupEventListeners();
        this.createNotificationContainer();
    }

    setupEventListeners() {
        this.form.addEventListener('submit', (e) => {
            e.preventDefault();
            this.handleSubmit();
        });

        // Validation en temps réel
        const inputs = this.form.querySelectorAll('input, textarea');
        inputs.forEach(input => {
            input.addEventListener('blur', () => {
                this.validateField(input);
            });
            
            input.addEventListener('input', () => {
                this.clearFieldError(input);
            });
        });
    }

    createNotificationContainer() {
        // Créer le conteneur de notifications s'il n'existe pas
        if (!document.getElementById('contactNotifications')) {
            const notificationContainer = document.createElement('div');
            notificationContainer.id = 'contactNotifications';
            notificationContainer.style.cssText = `
                position: fixed;
                top: 20px;
                right: 20px;
                z-index: 10000;
                max-width: 400px;
            `;
            document.body.appendChild(notificationContainer);
        }
    }

    async handleSubmit() {
        if (this.isSubmitting) return;

        // Valider tous les champs avant envoi
        if (!this.validateForm()) {
            this.showNotification('Veuillez corriger les erreurs dans le formulaire', 'error');
            return;
        }

        this.isSubmitting = true;
        this.setFormState(true);

        try {
            const formData = this.getFormData();
            
            const response = await fetch('app/contact-api.php', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                },
                body: JSON.stringify(formData)
            });

            const data = await response.json();

            if (data.success) {
                this.showNotification(data.message, 'success');
                this.form.reset();
                this.clearAllErrors();
            } else {
                this.showNotification(data.message, 'error');
            }

        } catch (error) {
            console.error('Erreur envoi message:', error);
            this.showNotification('Erreur de connexion. Veuillez réessayer.', 'error');
        } finally {
            this.isSubmitting = false;
            this.setFormState(false);
        }
    }

    getFormData() {
        return {
            name: this.form.querySelector('[name="name"]').value.trim(),
            email: this.form.querySelector('[name="email"]').value.trim(),
            message: this.form.querySelector('[name="message"]').value.trim()
        };
    }

    validateForm() {
        let isValid = true;
        const fields = this.form.querySelectorAll('input, textarea');

        fields.forEach(field => {
            if (!this.validateField(field)) {
                isValid = false;
            }
        });

        return isValid;
    }

    validateField(field) {
        const value = field.value.trim();
        let isValid = true;
        let errorMessage = '';

        // Clear previous error
        this.clearFieldError(field);

        // Validation spécifique selon le type de champ
        switch (field.name) {
            case 'name':
                if (value.length < 2) {
                    isValid = false;
                    errorMessage = 'Le nom doit contenir au moins 2 caractères';
                }
                break;

            case 'email':
                if (!this.isValidEmail(value)) {
                    isValid = false;
                    errorMessage = 'Adresse email invalide';
                }
                break;

            case 'message':
                if (value.length < 10) {
                    isValid = false;
                    errorMessage = 'Le message doit contenir au moins 10 caractères';
                }
                break;
        }

        // Validation de base pour les champs requis
        if (field.hasAttribute('required') && !value) {
            isValid = false;
            errorMessage = 'Ce champ est obligatoire';
        }

        if (!isValid) {
            this.showFieldError(field, errorMessage);
        }

        return isValid;
    }

    isValidEmail(email) {
        const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
        return emailRegex.test(email);
    }

    showFieldError(field, message) {
        // Ajouter la classe d'erreur
        field.classList.add('is-invalid');

        // Créer ou mettre à jour le message d'erreur
        let errorElement = field.parentNode.querySelector('.invalid-feedback');
        if (!errorElement) {
            errorElement = document.createElement('div');
            errorElement.className = 'invalid-feedback';
            field.parentNode.appendChild(errorElement);
        }

        errorElement.textContent = message;
        errorElement.style.display = 'block';
    }

    clearFieldError(field) {
        field.classList.remove('is-invalid');
        const errorElement = field.parentNode.querySelector('.invalid-feedback');
        if (errorElement) {
            errorElement.style.display = 'none';
        }
    }

    clearAllErrors() {
        const fields = this.form.querySelectorAll('input, textarea');
        fields.forEach(field => this.clearFieldError(field));
    }

    setFormState(isSubmitting) {
        const submitButton = this.form.querySelector('button[type="submit"]');
        const buttonText = submitButton.querySelector('.button-text') || submitButton;

        if (isSubmitting) {
            submitButton.disabled = true;
            const originalText = buttonText.textContent;
            buttonText.innerHTML = '<i class="fas fa-spinner fa-spin mr-2"></i>Envoi en cours...';
            buttonText.setAttribute('data-original-text', originalText);
        } else {
            submitButton.disabled = false;
            const originalText = buttonText.getAttribute('data-original-text');
            if (originalText) {
                buttonText.innerHTML = originalText;
            }
        }
    }

    showNotification(message, type = 'info') {
        const container = document.getElementById('contactNotifications');
        if (!container) return;

        const notification = document.createElement('div');
        notification.className = `alert alert-${this.getAlertType(type)} alert-dismissible fade show`;
        notification.style.cssText = 'margin-bottom: 10px; animation: slideInRight 0.3s ease;';
        
        notification.innerHTML = `
            ${message}
            <button type="button" class="close" data-dismiss="alert">
                <span>&times;</span>
            </button>
        `;

        container.appendChild(notification);

        // Auto-remove after 5 seconds
        setTimeout(() => {
            if (notification.parentNode) {
                notification.classList.remove('show');
                setTimeout(() => notification.remove(), 300);
            }
        }, 5000);

        // Gérer la fermeture manuelle
        notification.querySelector('.close').addEventListener('click', () => {
            notification.classList.remove('show');
            setTimeout(() => notification.remove(), 300);
        });
    }

    getAlertType(type) {
        const types = {
            'success': 'success',
            'error': 'danger',
            'warning': 'warning',
            'info': 'info'
        };
        return types[type] || 'info';
    }
}

// CSS pour les animations (à ajouter dans votre CSS)
const contactStyles = `
@keyframes slideInRight {
    from {
        transform: translateX(100%);
        opacity: 0;
    }
    to {
        transform: translateX(0);
        opacity: 1;
    }
}

.is-invalid {
    border-color: #dc3545 !important;
}

.invalid-feedback {
    display: none;
    width: 100%;
    margin-top: 0.25rem;
    font-size: 0.875em;
    color: #dc3545;
}
`;

// Injecter les styles
if (!document.getElementById('contact-styles')) {
    const styleSheet = document.createElement('style');
    styleSheet.id = 'contact-styles';
    styleSheet.textContent = contactStyles;
    document.head.appendChild(styleSheet);
}

// Initialiser quand le DOM est chargé
document.addEventListener('DOMContentLoaded', function() {
    window.contactManager = new ContactManager();
});