<!-- views/footer.php -->
    </main>

    <footer class="main-footer">
        <div class="container">
            <div class="footer-content">
                <div class="footer-section">
                    <div class="logo">
                        <i class="fas fa-spray-can"></i>
                        <span class="logo-text"><?php echo SITE_NAME; ?></span>
                    </div>
                    <p><?php echo SITE_DESCRIPTION; ?></p>
                    <div class="social-links">
                        <a href="#" class="social-link"><i class="fab fa-facebook"></i></a>
                        <a href="#" class="social-link"><i class="fab fa-twitter"></i></a>
                        <a href="#" class="social-link"><i class="fab fa-linkedin"></i></a>
                        <a href="#" class="social-link"><i class="fab fa-instagram"></i></a>
                    </div>
                </div>
                
                <div class="footer-section">
                    <h3>Liens Rapides</h3>
                    <ul class="footer-links">
                        <li><a href="index.php?page=home"><i class="fas fa-chevron-right"></i> Accueil</a></li>
                        <li><a href="index.php?page=products"><i class="fas fa-chevron-right"></i> Produits</a></li>
                        <li><a href="index.php?page=admin-login"><i class="fas fa-chevron-right"></i> Connexion</a></li>
                        <li><a href="#contact"><i class="fas fa-chevron-right"></i> Contact</a></li>
                    </ul>
                </div>
                
                <div class="footer-section">
                    <h3>Contact</h3>
                        <p><?php echo COMPANY_PHONE1; ?></p>
                        <p><?php echo COMPANY_PHONE2; ?></p>
                        <p><?php echo COMPANY_EMAIL; ?></p>

                </div>
                
                <div class="footer-section">
                    <h3>Informations Légales</h3>
                    <div class="legal-info">
                        <p><strong>Id. Nat:</strong> <?php echo COMPANY_ID_NAT; ?></p>
                        <p><strong>RCCM:</strong> <?php echo COMPANY_RCCM; ?></p>
                        <p><strong>NIF:</strong> <?php echo COMPANY_NIF; ?></p>
                    </div>
                </div>
            </div>
        </div>
    </footer>

    <script src="assets/js/main.js"></script>
</body>
</html>