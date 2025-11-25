<?php
// app/contact-api.php
require_once 'config.php';

header('Content-Type: application/json');
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: POST, OPTIONS');
header('Access-Control-Allow-Headers: Content-Type');

// Gérer les requêtes OPTIONS pour CORS
if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
    exit(0);
}

// Vérifier que c'est une requête POST
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    echo json_encode(['success' => false, 'message' => 'Méthode non autorisée']);
    exit;
}

// Récupérer les données JSON
$input = json_decode(file_get_contents('php://input'), true);

// Valider les données
if (!isset($input['name']) || !isset($input['email']) || !isset($input['message'])) {
    echo json_encode(['success' => false, 'message' => 'Données manquantes']);
    exit;
}

// Nettoyer et valider les données
$name = trim($input['name']);
$email = trim($input['email']);
$message = trim($input['message']);

// Validation des champs
if (empty($name) || empty($email) || empty($message)) {
    echo json_encode(['success' => false, 'message' => 'Tous les champs sont obligatoires']);
    exit;
}

if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
    echo json_encode(['success' => false, 'message' => 'Adresse email invalide']);
    exit;
}

if (strlen($name) < 2) {
    echo json_encode(['success' => false, 'message' => 'Le nom doit contenir au moins 2 caractères']);
    exit;
}

if (strlen($message) < 10) {
    echo json_encode(['success' => false, 'message' => 'Le message doit contenir au moins 10 caractères']);
    exit;
}

try {
    // Connexion à la base de données
    $db = getDBConnection();
    
    // Préparer la requête d'insertion
    $sql = "INSERT INTO contacts (full_name, email, message, is_read, created_at) 
            VALUES (?, ?, ?, 0, datetime('now'))";
    
    $stmt = $db->prepare($sql);
    $stmt->execute([$name, $email, $message]);
    
    // Vérifier si l'insertion a réussi
    if ($stmt->rowCount() > 0) {
        // Récupérer l'ID du message inséré
        $messageId = $db->lastInsertId();
        
        // Envoyer un email de notification (optionnel)
        sendNotificationEmail($name, $email, $message);
        
        echo json_encode([
            'success' => true,
            'message' => 'Votre message a été envoyé avec succès ! Nous vous répondrons dans les plus brefs délais.',
            'message_id' => $messageId
        ]);
    } else {
        echo json_encode(['success' => false, 'message' => 'Erreur lors de l\'enregistrement du message']);
    }
    
} catch (PDOException $e) {
    error_log("Erreur base de données contact: " . $e->getMessage());
    echo json_encode([
        'success' => false, 
        'message' => 'Erreur serveur lors de l\'enregistrement du message'
    ]);
} catch (Exception $e) {
    error_log("Erreur générale contact: " . $e->getMessage());
    echo json_encode([
        'success' => false, 
        'message' => 'Erreur lors de l\'envoi du message'
    ]);
}

/**
 * Envoie un email de notification (optionnel)
 */
function sendNotificationEmail($name, $email, $message) {
    $to = COMPANY_EMAIL;
    $subject = "Nouveau message de contact - " . SITE_NAME;
    
    $emailContent = "
    Nouveau message reçu depuis le formulaire de contact :
    
    Nom : $name
    Email : $email
    Date : " . date('d/m/Y à H:i') . "
    
    Message :
    " . wordwrap($message, 70) . "
    
    ---
    Cet email a été envoyé automatiquement depuis le site " . SITE_NAME . "
    ";
    
    $headers = "From: " . COMPANY_EMAIL . "\r\n" .
               "Reply-To: " . $email . "\r\n" .
               "X-Mailer: PHP/" . phpversion();
    
    // Essayer d'envoyer l'email (silencieusement)
    @mail($to, $subject, $emailContent, $headers);
}
?>