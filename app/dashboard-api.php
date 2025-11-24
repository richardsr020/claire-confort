<?php
// app/dashboard-api.php - VERSION CORRIGÉE
/**
 * API DASHBOARD - VERSION CORRIGÉE ET COMPLÈTE
 */

session_start();
require_once 'config.php';

// Désactiver l'affichage des erreurs HTML en production
if (!DEBUG_MODE) {
    ini_set('display_errors', 0);
    error_reporting(0);
}

header('Content-Type: application/json');

// ================================
// VÉRIFICATION D'AUTHENTIFICATION
// ================================

function isAuthenticated() {
    return isset($_SESSION['admin_logged_in']) && $_SESSION['admin_logged_in'] === true;
}

function sendUnauthorized() {
    http_response_code(401);
    echo json_encode(['success' => false, 'message' => 'Non authentifié']);
    exit();
}

if (!isAuthenticated()) {
    sendUnauthorized();
}

// ================================
// GESTION DES ROUTES - CORRIGÉE
// ================================

$action = $_GET['action'] ?? '';

try {
    $db = getDBConnection();
    
    switch ($action) {
        // GET Actions
        case 'getUserInfo': getUserInfo($db); break;
        case 'getOverview': getOverview($db); break;
        case 'getProducts': getProducts($db); break; // CORRIGÉ : avec 's'
        case 'getProduct': getProduct($db); break;
        case 'getCategories': getCategories($db); break; // CORRIGÉ : avec 's'
        case 'getCategory': getCategory($db); break;
        case 'getContacts': getContacts($db); break; // CORRIGÉ : avec 's'
        case 'getContact': getContact($db); break;
        case 'getSettings': getSettings($db); break;
        
        // POST Actions - Produits
        case 'addProduct': addProduct($db); break;
        case 'updateProduct': updateProduct($db); break;
        case 'deleteProduct': deleteProduct($db); break;
        
        // POST Actions - Catégories
        case 'addCategory': addCategory($db); break;
        case 'updateCategory': updateCategory($db); break;
        case 'deleteCategory': deleteCategory($db); break;
        
        // POST Actions - Contacts
        case 'updateContact': updateContact($db); break;
        case 'deleteContact': deleteContact($db); break;
        
        // POST Actions - Paramètres
        case 'updateSettings': updateSettings($db); break;
        
        default:
            http_response_code(400);
            echo json_encode(['success' => false, 'message' => 'Action non valide: ' . $action]);
    }
} catch (Exception $e) {
    error_log("Erreur API Dashboard: " . $e->getMessage());
    http_response_code(500);
    echo json_encode([
        'success' => false, 
        'message' => DEBUG_MODE ? $e->getMessage() : 'Erreur serveur'
    ]);
}

// ================================
// FONCTIONS UTILITAIRES
// ================================

function validateRequired($data, $required) {
    foreach ($required as $field) {
        if (empty($data[$field])) {
            return false;
        }
    }
    return true;
}

function sendValidationError($message) {
    echo json_encode(['success' => false, 'message' => $message]);
    exit();
}

function sendSuccess($message, $data = null) {
    $response = ['success' => true, 'message' => $message];
    if ($data !== null) {
        $response['data'] = $data;
    }
    echo json_encode($response);
    exit();
}

function handleImageUpload($file) {
    // Vérifier s'il y a une erreur d'upload
    if ($file['error'] !== UPLOAD_ERR_OK) {
        return null;
    }

    // Vérifier le type MIME
    $finfo = finfo_open(FILEINFO_MIME_TYPE);
    $mimeType = finfo_file($finfo, $file['tmp_name']);
    finfo_close($finfo);
    
    if (!array_key_exists($mimeType, ALLOWED_IMAGE_TYPES)) {
        return null;
    }
    
    // Vérifier la taille
    if ($file['size'] > MAX_FILE_SIZE) {
        return null;
    }
    
    // Créer le dossier de destination
    if (!file_exists(PRODUCT_IMAGE_DIR)) {
        mkdir(PRODUCT_IMAGE_DIR, 0755, true);
    }
    
    // Générer un nom de fichier unique
    $extension = ALLOWED_IMAGE_TYPES[$mimeType];
    $filename = uniqid() . '_' . time() . '.' . $extension;
    $destination = PRODUCT_IMAGE_DIR . $filename;
    
    // Déplacer le fichier
    if (move_uploaded_file($file['tmp_name'], $destination)) {
        return $filename; // Retourner seulement le nom du fichier
    }
    
    return null;
}

// ================================
// FONCTIONS DE LECTURE (GET)
// ================================

function getUserInfo($db) {
    $adminId = $_SESSION['admin_id'] ?? 1; // Fallback pour développement
    $stmt = $db->prepare("SELECT id, email, created_at FROM admins WHERE id = ?");
    $stmt->execute([$adminId]);
    $admin = $stmt->fetch();
    
    if ($admin) {
        sendSuccess('Informations utilisateur récupérées', [
            'id' => $admin['id'],
            'email' => $admin['email'],
            'created_at' => $admin['created_at']
        ]);
    } else {
        // Fallback pour développement
        sendSuccess('Informations utilisateur récupérées', [
            'id' => 1,
            'email' => ADMIN_EMAIL,
            'created_at' => date('Y-m-d H:i:s')
        ]);
    }
}

function getOverview($db) {
    // Statistiques produits
    $productsCount = $db->query("SELECT COUNT(*) as count FROM products WHERE stock_quantity > 0")->fetch()['count'];
    $categoriesCount = $db->query("SELECT COUNT(*) as count FROM categories WHERE is_active = 1")->fetch()['count'];
    $unreadMessagesCount = $db->query("SELECT COUNT(*) as count FROM contacts WHERE is_read = 0")->fetch()['count'];
    $totalStock = $db->query("SELECT SUM(stock_quantity) as total FROM products")->fetch()['total'] ?? 0;
    
    // Messages récents
    $recentMessages = $db->query("
        SELECT id, full_name, email, message, is_read, created_at 
        FROM contacts 
        ORDER BY created_at DESC 
        LIMIT 5
    ")->fetchAll();
    
    sendSuccess('Données overview récupérées', [
        'stats' => [
            'productsCount' => (int)$productsCount,
            'categoriesCount' => (int)$categoriesCount,
            'unreadMessagesCount' => (int)$unreadMessagesCount,
            'totalStock' => (int)$totalStock
        ],
        'recentMessages' => $recentMessages
    ]);
}

function getProducts($db) {
    $products = $db->query("
        SELECT 
            p.id, p.name, p.description, p.price, 
            p.category_id,
            p.stock_quantity, p.weight, p.dimensions, p.image_path,
            p.created_at, p.updated_at,
            c.name as category_name
        FROM products p 
        LEFT JOIN categories c ON p.category_id = c.id 
        ORDER BY p.created_at DESC
    ")->fetchAll();
    
    sendSuccess('Produits récupérés', $products);
}

function getProduct($db) {
    $id = filter_input(INPUT_GET, 'id', FILTER_VALIDATE_INT);
    
    if (!$id || $id < 1) {
        sendValidationError('ID produit invalide');
    }
    
    $stmt = $db->prepare("
        SELECT 
            p.*, 
            c.name as category_name
        FROM products p 
        LEFT JOIN categories c ON p.category_id = c.id 
        WHERE p.id = ?
    ");
    $stmt->execute([$id]);
    $product = $stmt->fetch();
    
    if ($product) {
        sendSuccess('Produit récupéré', $product);
    } else {
        sendValidationError('Produit non trouvé');
    }
}

function getCategories($db) {
    $categories = $db->query("
        SELECT 
            c.*, 
            (SELECT COUNT(*) FROM products p WHERE p.category_id = c.id) as product_count
        FROM categories c 
        ORDER BY c.name
    ")->fetchAll();
    
    sendSuccess('Catégories récupérées', $categories);
}

function getCategory($db) {
    $id = filter_input(INPUT_GET, 'id', FILTER_VALIDATE_INT);
    
    if (!$id || $id < 1) {
        sendValidationError('ID catégorie invalide');
    }
    
    $stmt = $db->prepare("
        SELECT 
            c.*,
            (SELECT COUNT(*) FROM products p WHERE p.category_id = c.id) as product_count
        FROM categories c 
        WHERE c.id = ?
    ");
    $stmt->execute([$id]);
    $category = $stmt->fetch();
    
    if ($category) {
        sendSuccess('Catégorie récupérée', $category);
    } else {
        sendValidationError('Catégorie non trouvée');
    }
}

function getContacts($db) {
    $contacts = $db->query("
        SELECT id, full_name, email, message, is_read, created_at
        FROM contacts 
        ORDER BY created_at DESC
    ")->fetchAll();
    
    sendSuccess('Messages récupérés', $contacts);
}

function getContact($db) {
    $id = filter_input(INPUT_GET, 'id', FILTER_VALIDATE_INT);
    
    if (!$id || $id < 1) {
        sendValidationError('ID contact invalide');
    }
    
    $stmt = $db->prepare("SELECT * FROM contacts WHERE id = ?");
    $stmt->execute([$id]);
    $contact = $stmt->fetch();
    
    if ($contact) {
        sendSuccess('Message récupéré', $contact);
    } else {
        sendValidationError('Message non trouvé');
    }
}

function getSettings($db) {
    $settings = $db->query("SELECT * FROM settings")->fetchAll();
    
    $settingsMap = [];
    foreach ($settings as $setting) {
        $settingsMap[$setting['setting_key']] = [
            'value' => $setting['setting_value'],
            'type' => $setting['setting_type']
        ];
    }
    
    sendSuccess('Paramètres récupérés', $settingsMap);
}

// ================================
// GESTION DES PRODUITS (CRUD) - CORRIGÉ
// ================================

function addProduct($db) {
    if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
        http_response_code(405);
        sendValidationError('Méthode non autorisée');
    }
    
    // APPROCHE HYBRIDE
    $input = [];
    $imageFile = null;
    
    // Toujours essayer JSON d'abord
    $rawInput = file_get_contents('php://input');
    $jsonData = json_decode($rawInput, true);
    
    if ($jsonData) {
        // Données JSON
        $input = $jsonData;
        error_log("Données JSON détectées");
    } else {
        // Données FormData
        $input = $_POST;
        $imageFile = $_FILES['image'] ?? null;
        error_log("Données FormData détectées - POST: " . print_r($_POST, true));
    }
    
    if (!$input) {
        sendValidationError('Données invalides. Raw: ' . substr($rawInput, 0, 200));
    }
    
    // Validation des données requises
    $required = ['name', 'price', 'category_id'];
    if (!validateRequired($input, $required)) {
        sendValidationError('Les champs nom, prix et catégorie sont requis');
    }
    
    try {
        // Gérer l'upload de l'image (uniquement en FormData)
        $imagePath = null;
        if ($imageFile && $imageFile['error'] === UPLOAD_ERR_OK) {
            error_log("Upload image en cours...");
            $imagePath = handleImageUpload($imageFile);
            if (!$imagePath) {
                sendValidationError('Erreur lors de l\'upload de l\'image');
            }
            error_log("Image sauvegardée: " . $imagePath);
        }
        
        $stmt = $db->prepare("
            INSERT INTO products 
            (name, description, price, category_id, stock_quantity, weight, dimensions, image_path) 
            VALUES (?, ?, ?, ?, ?, ?, ?, ?)
        ");
        
        $stmt->execute([
            trim($input['name']),
            trim($input['description'] ?? ''),
            floatval($input['price']),
            intval($input['category_id']),
            intval($input['stock_quantity'] ?? 0),
            !empty($input['weight']) ? floatval($input['weight']) : null,
            trim($input['dimensions'] ?? ''),
            $imagePath
        ]);
        
        $productId = $db->lastInsertId();
        
        sendSuccess('Produit ajouté avec succès', ['id' => $productId]);
        
    } catch (Exception $e) {
        error_log("Erreur ajout produit: " . $e->getMessage());
        sendValidationError('Erreur lors de l\'ajout du produit: ' . (DEBUG_MODE ? $e->getMessage() : ''));
    }
}

function updateProduct($db) {
    if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
        http_response_code(405);
        sendValidationError('Méthode non autorisée');
    }
    
    // Récupérer les données selon le type de contenu
    $input = [];
    $imageFile = null;
    
    if (isset($_SERVER['CONTENT_TYPE']) && strpos($_SERVER['CONTENT_TYPE'], 'multipart/form-data') !== false) {
        // Données FormData (avec fichier)
        $input = $_POST;
        $imageFile = $_FILES['image'] ?? null;
    } else {
        // Données JSON (sans fichier - compatibilité ascendante)
        $input = json_decode(file_get_contents('php://input'), true);
        $imageFile = null;
    }
    
    if (!$input) {
        sendValidationError('Données invalides');
    }
    
    $id = $input['id'] ?? 0;
    
    if (!$id || $id < 1) {
        sendValidationError('ID produit manquant ou invalide');
    }
    
    // Vérifier que le produit existe et récupérer l'image actuelle
    $checkStmt = $db->prepare("SELECT id, image_path FROM products WHERE id = ?");
    $checkStmt->execute([$id]);
    $existingProduct = $checkStmt->fetch();
    
    if (!$existingProduct) {
        sendValidationError('Produit non trouvé');
    }
    
    // Validation des données requises
    $required = ['name', 'price', 'category_id'];
    if (!validateRequired($input, $required)) {
        sendValidationError('Les champs nom, prix et catégorie sont requis');
    }
    
    try {
        // Gérer l'upload de la nouvelle image
        $imagePath = $existingProduct['image_path'];
        
        if ($imageFile && $imageFile['error'] === UPLOAD_ERR_OK) {
            // Supprimer l'ancienne image si elle existe
            if ($imagePath && file_exists(PRODUCT_IMAGE_DIR . $imagePath)) {
                unlink(PRODUCT_IMAGE_DIR . $imagePath);
            }
            
            $imagePath = handleImageUpload($imageFile);
            if (!$imagePath) {
                sendValidationError('Erreur lors de l\'upload de l\'image');
            }
        }
        // Si on demande explicitement de supprimer l'image
        elseif (isset($input['remove_image']) && $input['remove_image'] === 'true') {
            if ($imagePath && file_exists(PRODUCT_IMAGE_DIR . $imagePath)) {
                unlink(PRODUCT_IMAGE_DIR . $imagePath);
            }
            $imagePath = null;
        }
        
        $stmt = $db->prepare("
            UPDATE products SET 
            name = ?, description = ?, price = ?, category_id = ?, 
            stock_quantity = ?, weight = ?, dimensions = ?, image_path = ?,
            updated_at = CURRENT_TIMESTAMP
            WHERE id = ?
        ");
        
        $stmt->execute([
            trim($input['name']),
            trim($input['description'] ?? ''),
            floatval($input['price']),
            intval($input['category_id']),
            intval($input['stock_quantity'] ?? 0),
            !empty($input['weight']) ? floatval($input['weight']) : null,
            trim($input['dimensions'] ?? ''),
            $imagePath,
            $id
        ]);
        
        sendSuccess('Produit modifié avec succès' . ($imagePath ? ' avec nouvelle image' : ''));
        
    } catch (Exception $e) {
        error_log("Erreur modification produit: " . $e->getMessage());
        sendValidationError('Erreur lors de la modification du produit: ' . (DEBUG_MODE ? $e->getMessage() : ''));
    }
}

function deleteProduct($db) {
    $id = filter_input(INPUT_GET, 'id', FILTER_VALIDATE_INT);
    
    if (!$id || $id < 1) {
        sendValidationError('ID produit manquant ou invalide');
    }
    
    // Vérifier que le produit existe
    $stmt = $db->prepare("SELECT id FROM products WHERE id = ?");
    $stmt->execute([$id]);
    $product = $stmt->fetch();
    
    if (!$product) {
        sendValidationError('Produit non trouvé');
    }
    
    try {
        // Supprimer le produit
        $deleteStmt = $db->prepare("DELETE FROM products WHERE id = ?");
        $deleteStmt->execute([$id]);
        
        sendSuccess('Produit supprimé avec succès');
        
    } catch (Exception $e) {
        error_log("Erreur suppression produit: " . $e->getMessage());
        sendValidationError('Erreur lors de la suppression du produit: ' . (DEBUG_MODE ? $e->getMessage() : ''));
    }
}

// ================================
// GESTION DES CATÉGORIES (CRUD) - CORRIGÉ
// ================================

function addCategory($db) {
    if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
        http_response_code(405);
        sendValidationError('Méthode non autorisée');
    }
    
    $input = json_decode(file_get_contents('php://input'), true);
    
    if (!$input) {
        sendValidationError('Données JSON invalides');
    }
    
    if (empty($input['name'])) {
        sendValidationError('Le nom de la catégorie est requis');
    }
    
    try {
        // Générer un slug unique
        $slug = strtolower(trim(preg_replace('/[^A-Za-z0-9-]+/', '-', $input['name'])));
        $originalSlug = $slug;
        $counter = 1;
        
        // Vérifier l'unicité du slug
        while (true) {
            $checkStmt = $db->prepare("SELECT id FROM categories WHERE slug = ?");
            $checkStmt->execute([$slug]);
            if (!$checkStmt->fetch()) {
                break;
            }
            $slug = $originalSlug . '-' . $counter;
            $counter++;
        }
        
        $stmt = $db->prepare("
            INSERT INTO categories (name, description, slug, is_active) 
            VALUES (?, ?, ?, ?)
        ");
        
        $stmt->execute([
            trim($input['name']),
            trim($input['description'] ?? ''),
            $slug,
            boolval($input['is_active'] ?? true)
        ]);
        
        $categoryId = $db->lastInsertId();
        
        sendSuccess('Catégorie ajoutée avec succès', ['id' => $categoryId]);
        
    } catch (Exception $e) {
        error_log("Erreur ajout catégorie: " . $e->getMessage());
        sendValidationError('Erreur lors de l\'ajout de la catégorie: ' . (DEBUG_MODE ? $e->getMessage() : ''));
    }
}

function updateCategory($db) {
    if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
        http_response_code(405);
        sendValidationError('Méthode non autorisée');
    }
    
    $input = json_decode(file_get_contents('php://input'), true);
    
    if (!$input) {
        sendValidationError('Données JSON invalides');
    }
    
    $id = $input['id'] ?? 0;
    
    if (!$id || $id < 1) {
        sendValidationError('ID catégorie manquant ou invalide');
    }
    
    // Vérifier que la catégorie existe
    $checkStmt = $db->prepare("SELECT id FROM categories WHERE id = ?");
    $checkStmt->execute([$id]);
    if (!$checkStmt->fetch()) {
        sendValidationError('Catégorie non trouvée');
    }
    
    if (empty($input['name'])) {
        sendValidationError('Le nom de la catégorie est requis');
    }
    
    try {
        $stmt = $db->prepare("
            UPDATE categories SET 
            name = ?, description = ?, is_active = ?, updated_at = CURRENT_TIMESTAMP
            WHERE id = ?
        ");
        
        $stmt->execute([
            trim($input['name']),
            trim($input['description'] ?? ''),
            boolval($input['is_active'] ?? true),
            $id
        ]);
        
        sendSuccess('Catégorie modifiée avec succès');
        
    } catch (Exception $e) {
        error_log("Erreur modification catégorie: " . $e->getMessage());
        sendValidationError('Erreur lors de la modification de la catégorie: ' . (DEBUG_MODE ? $e->getMessage() : ''));
    }
}

function deleteCategory($db) {
    $id = filter_input(INPUT_GET, 'id', FILTER_VALIDATE_INT);
    
    if (!$id || $id < 1) {
        sendValidationError('ID catégorie manquant ou invalide');
    }
    
    // Vérifier que la catégorie existe
    $checkStmt = $db->prepare("SELECT id FROM categories WHERE id = ?");
    $checkStmt->execute([$id]);
    if (!$checkStmt->fetch()) {
        sendValidationError('Catégorie non trouvée');
    }
    
    // Vérifier qu'aucun produit n'utilise cette catégorie
    $productsStmt = $db->prepare("SELECT COUNT(*) as count FROM products WHERE category_id = ?");
    $productsStmt->execute([$id]);
    $productCount = $productsStmt->fetch()['count'];
    
    if ($productCount > 0) {
        sendValidationError("Impossible de supprimer cette catégorie : $productCount produit(s) l'utilise(nt)");
    }
    
    try {
        $stmt = $db->prepare("DELETE FROM categories WHERE id = ?");
        $stmt->execute([$id]);
        
        sendSuccess('Catégorie supprimée avec succès');
        
    } catch (Exception $e) {
        error_log("Erreur suppression catégorie: " . $e->getMessage());
        sendValidationError('Erreur lors de la suppression de la catégorie: ' . (DEBUG_MODE ? $e->getMessage() : ''));
    }
}

// ================================
// GESTION DES CONTACTS (CRUD)
// ================================

function updateContact($db) {
    if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
        http_response_code(405);
        sendValidationError('Méthode non autorisée');
    }
    
    $input = json_decode(file_get_contents('php://input'), true);
    
    if (!$input) {
        sendValidationError('Données JSON invalides');
    }
    
    $id = $input['id'] ?? 0;
    
    if (!$id || $id < 1) {
        sendValidationError('ID contact manquant ou invalide');
    }
    
    // Vérifier que le contact existe
    $checkStmt = $db->prepare("SELECT id FROM contacts WHERE id = ?");
    $checkStmt->execute([$id]);
    if (!$checkStmt->fetch()) {
        sendValidationError('Message non trouvé');
    }
    
    try {
        $stmt = $db->prepare("UPDATE contacts SET is_read = ? WHERE id = ?");
        $stmt->execute([
            boolval($input['is_read'] ?? false),
            $id
        ]);
        
        sendSuccess('Message mis à jour avec succès');
        
    } catch (Exception $e) {
        error_log("Erreur modification contact: " . $e->getMessage());
        sendValidationError('Erreur lors de la mise à jour du message: ' . (DEBUG_MODE ? $e->getMessage() : ''));
    }
}

function deleteContact($db) {
    $id = filter_input(INPUT_GET, 'id', FILTER_VALIDATE_INT);
    
    if (!$id || $id < 1) {
        sendValidationError('ID contact manquant ou invalide');
    }
    
    // Vérifier que le contact existe
    $checkStmt = $db->prepare("SELECT id FROM contacts WHERE id = ?");
    $checkStmt->execute([$id]);
    if (!$checkStmt->fetch()) {
        sendValidationError('Message non trouvé');
    }
    
    try {
        $stmt = $db->prepare("DELETE FROM contacts WHERE id = ?");
        $stmt->execute([$id]);
        
        sendSuccess('Message supprimé avec succès');
        
    } catch (Exception $e) {
        error_log("Erreur suppression contact: " . $e->getMessage());
        sendValidationError('Erreur lors de la suppression du message: ' . (DEBUG_MODE ? $e->getMessage() : ''));
    }
}

// ================================
// GESTION DES PARAMÈTRES
// ================================

function updateSettings($db) {
    if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
        http_response_code(405);
        sendValidationError('Méthode non autorisée');
    }
    
    $input = json_decode(file_get_contents('php://input'), true);
    
    if (empty($input) || !is_array($input)) {
        sendValidationError('Aucune donnée à mettre à jour');
    }
    
    try {
        $db->beginTransaction();
        
        foreach ($input as $key => $value) {
            $stmt = $db->prepare("
                INSERT OR REPLACE INTO settings (setting_key, setting_value, setting_type, updated_at)
                VALUES (?, ?, ?, CURRENT_TIMESTAMP)
            ");
            
            // Déterminer le type automatiquement
            $type = 'string';
            if (is_bool($value)) {
                $type = 'boolean';
                $value = $value ? '1' : '0';
            } elseif (is_numeric($value)) {
                $type = 'number';
            }
            
            $stmt->execute([$key, (string)$value, $type]);
        }
        
        $db->commit();
        sendSuccess('Paramètres mis à jour avec succès');
        
    } catch (Exception $e) {
        $db->rollBack();
        error_log("Erreur mise à jour paramètres: " . $e->getMessage());
        sendValidationError('Erreur lors de la mise à jour des paramètres: ' . (DEBUG_MODE ? $e->getMessage() : ''));
    }
}
?>