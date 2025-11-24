<?php
// app/auth.php
session_start();
require_once 'config.php';

header('Content-Type: application/json');

if (isset($_GET['action']) && $_GET['action'] === 'login') {
    $email = $_POST['email'] ?? '';
    $password = $_POST['password'] ?? '';
    
    try {
        $db = getDBConnection();
        $sql = "SELECT * FROM admins WHERE email = ?";
        $stmt = $db->prepare($sql);
        $stmt->execute([$email]);
        $admin = $stmt->fetch();
        
        if ($admin) {
            if (password_verify($password, $admin['password_hash'])) {
                $_SESSION['admin_logged_in'] = true;
                $_SESSION['admin_email'] = $admin['email'];
                $_SESSION['admin_id'] = $admin['id'];
                $_SESSION['login_time'] = time();
                
                // SUPPRIMER cette ligne qui cause l'erreur
                // La colonne last_login n'existe pas dans votre table
                // $updateSql = "UPDATE admins SET last_login = CURRENT_TIMESTAMP WHERE id = ?";
                // $updateStmt = $db->prepare($updateSql);
                // $updateStmt->execute([$admin['id']]);
                
                echo json_encode([
                    'success' => true,
                    'message' => 'Connexion réussie'
                ]);
            } else {
                echo json_encode([
                    'success' => false,
                    'message' => 'Mot de passe incorrect'
                ]);
            }
        } else {
            echo json_encode([
                'success' => false,
                'message' => 'Email non trouvé'
            ]);
        }
    } catch (Exception $e) {
        error_log("Erreur d'authentification: " . $e->getMessage());
        echo json_encode([
            'success' => false,
            'message' => 'Erreur serveur'
        ]);
    }
    exit();
}

if (isset($_GET['action']) && $_GET['action'] === 'logout') {
    session_unset();
    session_destroy();
    header('Location: index.php?page=admin-login');
    exit();
}
?>