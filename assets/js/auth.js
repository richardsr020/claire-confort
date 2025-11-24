// assets/js/auth.js
class Auth {
    constructor() {
        this.form = document.getElementById('loginForm');
        this.emailInput = document.getElementById('email');
        this.passwordInput = document.getElementById('password');
        this.submitBtn = document.getElementById('submitBtn');
        this.errorAlert = document.getElementById('errorAlert');
        this.errorMessage = document.getElementById('errorMessage');
        this.togglePasswordBtn = document.getElementById('togglePassword');
        
        this.init();
    }

    init() {
        this.setupEventListeners();
    }

    setupEventListeners() {
        // Soumission du formulaire
        this.form.addEventListener('submit', (e) => {
            e.preventDefault();
            this.handleLogin();
        });

        // Toggle password visibility
        this.togglePasswordBtn.addEventListener('click', () => {
            this.togglePasswordVisibility();
        });

        // Cacher l'erreur quand l'utilisateur tape
        this.emailInput.addEventListener('input', () => {
            this.hideError();
        });

        this.passwordInput.addEventListener('input', () => {
            this.hideError();
        });
    }

    async handleLogin() {
        const email = this.emailInput.value.trim();
        const password = this.passwordInput.value;

        // Validation basique
        if (!this.validateForm(email, password)) {
            return;
        }

        // Désactiver le bouton et montrer le loading
        this.setLoadingState(true);

        try {
            const response = await this.sendLoginRequest(email, password);
            
            if (response.success) {
                this.handleSuccess();
            } else {
                this.handleError(response.message);
            }
        } catch (error) {
            console.error('Erreur de connexion:', error);
            this.handleError('Erreur de connexion au serveur');
        } finally {
            this.setLoadingState(false);
        }
    }

    validateForm(email, password) {
        if (!email) {
            this.showError('Veuillez saisir votre adresse email');
            this.emailInput.focus();
            return false;
        }

        if (!this.isValidEmail(email)) {
            this.showError('Veuillez saisir une adresse email valide');
            this.emailInput.focus();
            return false;
        }

        if (!password) {
            this.showError('Veuillez saisir votre mot de passe');
            this.passwordInput.focus();
            return false;
        }

        return true;
    }

    isValidEmail(email) {
        const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
        return emailRegex.test(email);
    }

    async sendLoginRequest(email, password) {
        const formData = new FormData();
        formData.append('email', email);
        formData.append('password', password);

        const response = await fetch('app/auth.php?action=login', {
            method: 'POST',
            body: formData
        });

        if (!response.ok) {
            throw new Error(`HTTP error! status: ${response.status}`);
        }

        return await response.json();
    }

    handleSuccess() {
        // Redirection vers le dashboard
        window.location.href = 'index.php?page=dashboard';
    }

    handleError(message) {
        this.showError(message);
        this.passwordInput.value = '';
        this.passwordInput.focus();
    }

    showError(message) {
        this.errorMessage.textContent = message;
        this.errorAlert.style.display = 'flex';
        
        // Ajouter une animation
        this.errorAlert.style.animation = 'shake 0.5s ease-in-out';
        setTimeout(() => {
            this.errorAlert.style.animation = '';
        }, 500);
    }

    hideError() {
        this.errorAlert.style.display = 'none';
    }

    setLoadingState(isLoading) {
        if (isLoading) {
            this.submitBtn.disabled = true;
            this.submitBtn.innerHTML = `
                <i class="fas fa-spinner fa-spin"></i>
                Connexion...
            `;
        } else {
            this.submitBtn.disabled = false;
            this.submitBtn.innerHTML = `
                <i class="fas fa-sign-in-alt"></i>
                Se connecter
            `;
        }
    }

    togglePasswordVisibility() {
        const type = this.passwordInput.type === 'password' ? 'text' : 'password';
        this.passwordInput.type = type;
        
        // Changer l'icône
        const icon = this.togglePasswordBtn.querySelector('i');
        icon.className = type === 'password' ? 'fas fa-eye' : 'fas fa-eye-slash';
    }
}

// Initialisation quand la page est chargée
document.addEventListener('DOMContentLoaded', function() {
    new Auth();
});

// Animation shake pour les erreurs
const style = document.createElement('style');
style.textContent = `
    @keyframes shake {
        0%, 100% { transform: translateX(0); }
        25% { transform: translateX(-5px); }
        75% { transform: translateX(5px); }
    }
`;
document.head.appendChild(style);