<?php
// app/config.php - Configuration de l'application Claire Confort

// Configuration de la base de données SQLite
define('DB_PATH', dirname(__DIR__) . '/data/sqlite/claire_confort.db');
define('DB_DSN', 'sqlite:' . DB_PATH);

// Informations de l'entreprise
define('SITE_NAME', 'Claire Confort');
define('SITE_DESCRIPTION', 'Solutions de nettoyage professionnelles pour ONG, entreprises et particuliers');
define('SITE_VERSION', '1.0.0');

// Coordonnées de l'entreprise
define('COMPANY_PHONE1', '+243 978242422');
define('COMPANY_PHONE2', '+243 0992280354');
define('COMPANY_EMAIL', 'clairconfort@gmail.com');

// Informations légales
define('COMPANY_ID_NAT', '19-G4701-N69304P');
define('COMPANY_RCCM', '24-A-01223');
define('COMPANY_NIF', 'A2432909Y');

// Configuration des chemins
define('UPLOAD_DIR', dirname(__DIR__) . '/uploads/');
define('PRODUCT_IMAGE_DIR', UPLOAD_DIR . 'products/');
define('ASSETS_URL', 'assets/');

// Configuration des uploads
define('MAX_FILE_SIZE', 5 * 1024 * 1024); // 5MB
define('ALLOWED_IMAGE_TYPES', [
    'image/jpeg' => 'jpg',
    'image/png' => 'png',
    'image/gif' => 'gif',
    'image/webp' => 'webp'
]);

// Configuration de l'administrateur
define('ADMIN_EMAIL', 'clairconfort@gmail.com');
// Mot de passe par défaut : "claire@admin123J" (à changer après la première connexion)
define('ADMIN_PASSWORD_HASH', '$2y$10$Vnw9KABKZ2MKJkjGIlT9VOUZ4V9hiBbrtxuuCYFw3xQnRkkqVJCpe');

// Configuration du site
define('ITEMS_PER_PAGE', 12);
define('SITE_URL', (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? "https" : "http") . "://$_SERVER[HTTP_HOST]");
define('CURRENCY', '$');
//define('CURRENCY_SYMBOL', '$');

// Mode debug (désactiver en production)
define('DEBUG_MODE', true);

// Configuration des sessions
define('SESSION_TIMEOUT', 3600); // 1 heure en secondes

// Gestion des erreurs
if (DEBUG_MODE) {
    error_reporting(E_ALL);
    ini_set('display_errors', 1);
} else {
    error_reporting(0);
    ini_set('display_errors', 0);
}

// Headers de sécurité
header('X-Content-Type-Options: nosniff');
header('X-Frame-Options: DENY');
header('X-XSS-Protection: 1; mode=block');

// Début de session avec configuration
if (session_status() === PHP_SESSION_NONE) {
    session_set_cookie_params([
        'lifetime' => SESSION_TIMEOUT,
        'path' => '/',
        'secure' => isset($_SERVER['HTTPS']),
        'httponly' => true,
        'samesite' => 'Strict'
    ]);
    session_start();
}

// Vérification de timeout de session
if (isset($_SESSION['LAST_ACTIVITY']) && (time() - $_SESSION['LAST_ACTIVITY'] > SESSION_TIMEOUT)) {
    session_unset();
    session_destroy();
}
$_SESSION['LAST_ACTIVITY'] = time();

// Fonction de connexion à la base de données
function getDBConnection() {
    try {
        $pdo = new PDO(DB_DSN);
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $pdo->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
        
        // Activer les clés étrangères pour SQLite
        $pdo->exec('PRAGMA foreign_keys = ON');
        
        return $pdo;
    } catch (PDOException $e) {
        if (DEBUG_MODE) {
            die("Erreur de connexion à la base de données: " . $e->getMessage());
        } else {
            die("Erreur de connexion à la base de données");
        }
    }
}

// Fonction pour initialiser la base de données
function initializeDatabase() {
    $db = getDBConnection();
    
    // Création des tables
    $sql = "
    -- Table des administrateurs
    CREATE TABLE IF NOT EXISTS admins (
        id INTEGER PRIMARY KEY AUTOINCREMENT,
        email VARCHAR(100) UNIQUE NOT NULL,
        password_hash VARCHAR(255) NOT NULL,
        created_at DATETIME DEFAULT CURRENT_TIMESTAMP
    );

    -- Table des catégories de produits
    CREATE TABLE IF NOT EXISTS categories (
        id INTEGER PRIMARY KEY AUTOINCREMENT,
        name VARCHAR(100) NOT NULL,
        description TEXT,
        slug VARCHAR(100) UNIQUE NOT NULL,
        is_active BOOLEAN DEFAULT 1,
        created_at DATETIME DEFAULT CURRENT_TIMESTAMP
    );

    -- Table des produits
    CREATE TABLE IF NOT EXISTS products (
        id INTEGER PRIMARY KEY AUTOINCREMENT,
        name VARCHAR(200) NOT NULL,
        description TEXT,
        price DECIMAL(10,2) NOT NULL,
        category_id INTEGER,
        stock_quantity INTEGER DEFAULT 0,
        weight DECIMAL(8,2),
        dimensions VARCHAR(50),
        image_path VARCHAR(255),
        created_at DATETIME DEFAULT CURRENT_TIMESTAMP,
        updated_at DATETIME DEFAULT CURRENT_TIMESTAMP,
        FOREIGN KEY (category_id) REFERENCES categories(id)
    );

    -- Table des messages de contact
    CREATE TABLE IF NOT EXISTS contacts (
        id INTEGER PRIMARY KEY AUTOINCREMENT,
        full_name VARCHAR(100) NOT NULL,
        email VARCHAR(100) NOT NULL,
        message TEXT NOT NULL,
        is_read BOOLEAN DEFAULT 0,
        created_at DATETIME DEFAULT CURRENT_TIMESTAMP
    );

    -- Table des paramètres du site
    CREATE TABLE IF NOT EXISTS settings (
        id INTEGER PRIMARY KEY AUTOINCREMENT,
        setting_key VARCHAR(100) UNIQUE NOT NULL,
        setting_value TEXT,
        setting_type VARCHAR(20) DEFAULT 'string',
        updated_at DATETIME DEFAULT CURRENT_TIMESTAMP
    );
    ";
    
    try {
        $db->exec($sql);
        
        // Insertion de l'administrateur par défaut (CORRIGÉ)
        $adminSql = "INSERT OR IGNORE INTO admins (email, password_hash) VALUES (?, ?)";
        $stmt = $db->prepare($adminSql);
        $stmt->execute([ADMIN_EMAIL, ADMIN_PASSWORD_HASH]);
        
        // Insertion des catégories par défaut
        $categories = [
            ['Nettoyants Multi-Surfaces', 'Produits pour le nettoyage de toutes les surfaces', 'nettoyants-multi-surfaces'],
            ['Désinfectants', 'Produits désinfectants pour surfaces et air', 'desinfectants'],
            ['Hygiène des Mains', 'Gels et savons pour l\'hygiène des mains', 'hygiene-mains'],
            ['Produits Spécialisés', 'Produits pour besoins spécifiques de nettoyage', 'produits-specialises'],
            ['Matériel de Nettoyage', 'Accessoires et matériel pour le nettoyage', 'materiel-nettoyage']
        ];
        
        $categorySql = "INSERT OR IGNORE INTO categories (name, description, slug) VALUES (?, ?, ?)";
        $stmt = $db->prepare($categorySql);
        foreach ($categories as $category) {
            $stmt->execute($category);
        }
        
        // Insertion des paramètres par défaut
        $settings = [
            ['site_maintenance', '0', 'boolean'],
            ['contact_email', COMPANY_EMAIL, 'string'],
            ['items_per_page', '12', 'number'],
            ['currency', 'USD', 'string']
        ];
        
        $settingSql = "INSERT OR IGNORE INTO settings (setting_key, setting_value, setting_type) VALUES (?, ?, ?)";
        $stmt = $db->prepare($settingSql);
        foreach ($settings as $setting) {
            $stmt->execute($setting);
        }
        
    } catch (PDOException $e) {
        if (DEBUG_MODE) {
            die("Erreur d'initialisation de la base: " . $e->getMessage());
        }
    }
}

// Fonction utilitaire pour obtenir un paramètre
function getSetting($key, $default = null) {

    $db = getDBConnection();
    $sql = "SELECT setting_value, setting_type FROM settings WHERE setting_key = ?";
    $stmt = $db->prepare($sql);
    $stmt->execute([$key]);
    $result = $stmt->fetch();
    
    if ($result) {
        switch ($result['setting_type']) {
            case 'boolean':
                return (bool)$result['setting_value'];
            case 'number':
                return (int)$result['setting_value'];
            default:
                return $result['setting_value'];
        }
    }
    
    return $default;
}

// Initialisation automatique de la base au premier accès
if (!file_exists(DB_PATH)) {
    initializeDatabase();
}
?>