<?php
// index.php - Point d'entrée principal de l'application Claire Confort

// Chargement de la configuration
require_once 'app/config.php';


// Détermination de la page à afficher
$page = isset($_GET['page']) ? $_GET['page'] : 'home';

// Sécurité : validation de la page demandée
$allowed_pages = ['home', 'products', 'dashboard', 'admin-login'];
if (!in_array($page, $allowed_pages)) {
    $page = 'home';
}

// Vérification d'accès pour le dashboard
// if ($page === 'dashboard' && !isset($_SESSION['admin_logged_in'])) {
//     $page = 'admin-login';
// }

// Inclusion du header
include 'header.php';

// Chargement du contenu principal selon la page demandée
switch ($page) {
    case 'home':
        include 'views/home.php';
        // Inclusion du footer
        include 'footer.php';
        break;
        
    case 'products':
        include 'views/products.php';
        break;
        
    case 'dashboard':
        include 'views/dashboard.php';
        break;
        
    case 'admin-login':
        include 'app/admin-login.php';
        break;
        
    default:
        include 'views/home.php';
        // Inclusion du footer
        include 'footer.php';
        break;
}


?>