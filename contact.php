<?php
header('Content-Type: application/json');
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: POST');
header('Access-Control-Allow-Headers: Content-Type');

// Check if request is POST
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    http_response_code(405);
    echo json_encode(['success' => false, 'message' => 'Method not allowed']);
    exit;
}

// Get and sanitize form data
$name = isset($_POST['name']) ? trim($_POST['name']) : '';
$email = isset($_POST['email']) ? trim($_POST['email']) : '';
$location = isset($_POST['location']) ? trim($_POST['location']) : '';
$subject = isset($_POST['subject']) ? trim($_POST['subject']) : '';
$message = isset($_POST['message']) ? trim($_POST['message']) : '';

// Validation
$errors = [];

if (empty($name)) {
    $errors[] = 'Name is required';
}

if (empty($email)) {
    $errors[] = 'Email is required';
} elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
    $errors[] = 'Invalid email format';
}

if (empty($location)) {
    $errors[] = 'Location is required';
}

if (empty($subject)) {
    $errors[] = 'Subject is required';
}

if (empty($message)) {
    $errors[] = 'Message is required';
}

// If there are validation errors, return them
if (!empty($errors)) {
    http_response_code(400);
    echo json_encode(['success' => false, 'message' => implode(', ', $errors)]);
    exit;
}

// Sanitize inputs to prevent XSS attacks
$name = htmlspecialchars($name, ENT_QUOTES, 'UTF-8');
$email = filter_var($email, FILTER_SANITIZE_EMAIL);
$location = htmlspecialchars($location, ENT_QUOTES, 'UTF-8');
$subject = htmlspecialchars($subject, ENT_QUOTES, 'UTF-8');
$message = htmlspecialchars($message, ENT_QUOTES, 'UTF-8');

// Email configuration
$to = 'devops@example.com'; // Change this to your email address
$email_subject = "Portfolio Contact Form: " . $subject;
$email_body = "You have received a new message from your portfolio contact form.\n\n";
$email_body .= "Name: $name\n";
$email_body .= "Email: $email\n";
$email_body .= "Location: $location\n";
$email_body .= "Subject: $subject\n\n";
$email_body .= "Message:\n$message\n";

$headers = "From: $email\r\n";
$headers .= "Reply-To: $email\r\n";
$headers .= "X-Mailer: PHP/" . phpversion();

// Send email
$mail_sent = mail($to, $email_subject, $email_body, $headers);

// Optional: Save to file (for backup/logging)
$log_file = 'contact_submissions.txt';
$log_entry = date('Y-m-d H:i:s') . " - Name: $name, Email: $email, Location: $location, Subject: $subject\n";
$log_entry .= "Message: $message\n";
$log_entry .= "---\n";

// Append to log file (create if doesn't exist)
file_put_contents($log_file, $log_entry, FILE_APPEND | LOCK_EX);

// Optional: Save to database (uncomment and configure if needed)
/*
try {
    $pdo = new PDO('mysql:host=localhost;dbname=portfolio_db', 'username', 'password');
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    
    $stmt = $pdo->prepare("INSERT INTO contact_submissions (name, email, location, subject, message, created_at) VALUES (?, ?, ?, ?, ?, NOW())");
    $stmt->execute([$name, $email, $location, $subject, $message]);
} catch (PDOException $e) {
    // Log error but don't fail the request
    error_log("Database error: " . $e->getMessage());
}
*/

// Return response
if ($mail_sent) {
    echo json_encode([
        'success' => true,
        'message' => 'Thank you! Your message has been sent successfully.'
    ]);
} else {
    // Even if mail fails, we've logged it, so return success
    // In production, you might want to handle this differently
    echo json_encode([
        'success' => true,
        'message' => 'Thank you! Your message has been received. We will get back to you soon.'
    ]);
}
?>

