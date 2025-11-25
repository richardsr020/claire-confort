<?php
require_once 'config.php';

header('Content-Type: application/json');
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: GET, POST');
header('Access-Control-Allow-Headers: Content-Type');

$action = $_GET['action'] ?? '';

// Mode débogage
$debug = isset($_GET['debug']);

try {
    switch ($action) {
        case 'getProducts':
            getProducts();
            break;
        case 'getCategories':
            getCategories();
            break;
        case 'getProduct':
            getProduct($_GET['id'] ?? 0);
            break;
        default:
            echo json_encode(['success' => false, 'message' => 'Action non valide']);
    }
} catch (Exception $e) {
    echo json_encode(['success' => false, 'message' => 'Erreur serveur: ' . $e->getMessage()]);
}

function getProducts() {
    global $debug;
    $db = getDBConnection();
    
    $sql = "SELECT p.*, c.name as category_name, c.slug as category_slug 
            FROM products p 
            LEFT JOIN categories c ON p.category_id = c.id 
            WHERE c.is_active = 1 
            ORDER BY p.created_at DESC";
    
    $stmt = $db->prepare($sql);
    $stmt->execute();
    
    $products = $stmt->fetchAll(PDO::FETCH_ASSOC);
    
    // Formater les données et gérer les images
    foreach ($products as &$product) {
        $product['price'] = floatval($product['price']);
        $product['stock_quantity'] = intval($product['stock_quantity']);
        $product['weight'] = $product['weight'] ? floatval($product['weight']) : null;
        
        // Construire le chemin complet de l'image
        $imageInfo = getProductImageUrl($product['image_path'], $debug);
        $product['image_url'] = $imageInfo['url'];
        
        // Ajouter des informations de débogage si demandé
        if ($debug) {
            $product['debug'] = $imageInfo['debug'];
        }
    }
    
    echo json_encode([
        'success' => true,
        'products' => $products,
        'debug' => $debug ? ['base_url' => SITE_URL, 'upload_dir' => PRODUCT_IMAGE_DIR] : null
    ]);
}

function getCategories() {
    $db = getDBConnection();
    
    $sql = "SELECT id, name, description, slug, is_active 
            FROM categories 
            WHERE is_active = 1 
            ORDER BY name";
    
    $stmt = $db->prepare($sql);
    $stmt->execute();
    
    $categories = $stmt->fetchAll(PDO::FETCH_ASSOC);
    
    echo json_encode([
        'success' => true,
        'categories' => $categories
    ]);
}

function getProduct($id) {
    if (!$id) {
        echo json_encode(['success' => false, 'message' => 'ID produit manquant']);
        return;
    }
    
    $db = getDBConnection();
    
    $sql = "SELECT p.*, c.name as category_name, c.slug as category_slug 
            FROM products p 
            LEFT JOIN categories c ON p.category_id = c.id 
            WHERE p.id = ?";
    
    $stmt = $db->prepare($sql);
    $stmt->execute([$id]);
    
    $product = $stmt->fetch(PDO::FETCH_ASSOC);
    
    if ($product) {
        // Formater les données
        $product['price'] = floatval($product['price']);
        $product['stock_quantity'] = intval($product['stock_quantity']);
        $product['weight'] = $product['weight'] ? floatval($product['weight']) : null;
        
        // Construire le chemin complet de l'image
        $imageInfo = getProductImageUrl($product['image_path']);
        $product['image_url'] = $imageInfo['url'];
        
        echo json_encode([
            'success' => true,
            'product' => $product
        ]);
    } else {
        echo json_encode(['success' => false, 'message' => 'Produit non trouvé']);
    }
}

function getProductImageUrl($imagePath, $debug = false) {
    $result = [
        'url' => 'assets/images/notfound.png',
        'debug' => []
    ];
    
    // Si pas d'image définie
    if (empty($imagePath)) {
        $result['debug'][] = "Aucun image_path dans la base de données";
        return $result;
    }
    
    // Construire le chemin complet vers uploads/products/
    $fullPath = 'uploads/products/' . $imagePath;
    $absolutePath = dirname(__DIR__) . '/' . $fullPath;
    
    $result['debug'][] = "Image path from DB: " . $imagePath;
    $result['debug'][] = "Full relative path: " . $fullPath;
    $result['debug'][] = "Absolute path: " . $absolutePath;
    
    // Vérifier si le fichier existe physiquement
    if (file_exists($absolutePath)) {
        $result['debug'][] = "Fichier trouvé: OUI";
        $result['url'] = $fullPath;
    } else {
        $result['debug'][] = "Fichier trouvé: NON";
        $result['debug'][] = "Erreur: Le fichier n'existe pas à l'emplacement attendu";
        $result['url'] = 'assets/images/notfound.png';
    }
    
    // Nettoyer le debug si non demandé
    if (!$debug) {
        unset($result['debug']);
    }
    
    return $result;
}

function getDefaultImageForCategory($categorySlug) {
    // Mapping des catégories vers les images par défaut
    $defaultImages = [
        'nettoyants-multi-surfaces' => 'assets/images/bg-img/1.jpg',
        'desinfectants' => 'assets/images/bg-img/2.jpg',
        'hygiene-mains' => 'assets/images/bg-img/3.jpg',
        'produits-specialises' => 'assets/images/bg-img/4.jpg',
        'materiel-nettoyage' => 'assets/images/bg-img/5.jpg'
    ];
    
    return $defaultImages[$categorySlug] ?? 'assets/images/notfound.png';
}
?>