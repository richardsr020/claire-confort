<!-- app/admin-login.php -->
<section class="login-section">
    <div class="login-container">
        <div class="login-card">
            <div class="login-header">
                    <!-- Navbar Brand -->
                    <div class="amado-navbar-brand">
                        <a href="index.php?page=home">
                            <img src="assets/images/claire_icon.png" alt="Claire Confort" class="logo-icon">
                            <span class="logo-text">Claire<span style="color: #f39422;">Confort</span></span>
                        </a>
                    </div>

                
                <h1>Connexion Administrateur</h1>
                <p>Accédez à votre espace d'administration</p>
                
                <div class="alert alert-error" id="errorAlert" style="display: none;">
                    <i class="fas fa-exclamation-circle"></i>
                    <span id="errorMessage">Email ou mot de passe incorrect</span>
                </div>
            </div>

            <form class="login-form" id="loginForm">
                <div class="form-group">
                    <label for="email">Adresse email</label>
                    <div class="input-group">
                        <i class="fas fa-envelope"></i>
                        <input type="email" id="email" name="email" required 
                               placeholder="Entrez votre adresse email">
                    </div>
                </div>

                <div class="form-group">
                    <label for="password">Mot de passe</label>
                    <div class="input-group">
                        <i class="fas fa-lock"></i>
                        <input type="password" id="password" name="password" required 
                               placeholder="Entrez votre mot de passe">
                        <button type="button" class="toggle-password" id="togglePassword">
                            <i class="fas fa-eye"></i>
                        </button>
                    </div>
                </div>

                <button type="submit" class="btn btn-primary btn-login" id="submitBtn">
                    <i class="fas fa-sign-in-alt"></i>
                    Se connecter
                </button>
            </form>

            <div class="login-back">
                <a href="index.php?page=home" class="back-link">
                    <i class="fas fa-arrow-left"></i>
                    Retour au site
                </a>
            </div>
        </div>

        <div class="login-side">
            <div class="side-content">
                <h2>Espace Administration</h2>
                <p>Gérez vos produits et contacts en toute simplicité</p>
                <div class="features-list">
                    <div class="feature">
                        <i class="fas fa-boxes"></i>
                        <span>Gestion des produits</span>
                    </div>
                    <div class="feature">
                        <i class="fas fa-envelope"></i>
                        <span>Messages clients</span>
                    </div>
                    <div class="feature">
                        <i class="fas fa-chart-bar"></i>
                        <span>Statistiques</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<script src="assets/js/auth.js"></script>