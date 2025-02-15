<?php
// Database configuration
$database = "database/contacts.db";

try {
    // Create database connection
    $db = new SQLite3($database);
    
    // Create table if not exists
    $db->exec("
        CREATE TABLE IF NOT EXISTS contacts (
            id INTEGER PRIMARY KEY AUTOINCREMENT,
            name TEXT NOT NULL,
            email TEXT NOT NULL,
            message TEXT NOT NULL,
            created_at DATETIME DEFAULT CURRENT_TIMESTAMP
        )
    ");

    // Get form data
    $name = SQLite3::escapeString($_POST['name']);
    $email = SQLite3::escapeString($_POST['email']);
    $message = SQLite3::escapeString($_POST['message']);

    // Insert data
    $stmt = $db->prepare("
        INSERT INTO contacts (name, email, message)
        VALUES (:name, :email, :message)
    ");
    
    $stmt->bindValue(':name', $name, SQLITE3_TEXT);
    $stmt->bindValue(':email', $email, SQLITE3_TEXT);
    $stmt->bindValue(':message', $message, SQLITE3_TEXT);
    
    if($stmt->execute()) {
        header("Location: thank_you.html");
        exit();
    } else {
        die("Error saving your message");
    }

} catch (Exception $e) {
    die("Database error: " . $e->getMessage());
}
?>