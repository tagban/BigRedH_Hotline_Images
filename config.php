<?php
// Prevent direct access to config file
if (count(get_included_files()) == 1) exit("Direct access not permitted.");

$web_config = [
    // Database Credentials
    'db_host' => 'localhost',
    'db_user' => 'USER',
    'db_pass' => 'PASSWORD',
    'db_name' => 'DB NAME',

    // Security & Logic
    'admin_hash'       => 'HASHED PASSWORD(use passwordHasher.php)', // Replace with your actual hash
    'media_expiry_hrs' => 48,
    'upload_limit'     => 5,     
    'limit_window'     => 600,   
    'base_url'         => '<URL>' // ex:http://images.bigredh.com/
];

// Establish Connection
$conn = new mysqli($web_config['db_host'], $web_config['db_user'], $web_config['db_pass'], $web_config['db_name']);

if ($conn->connect_error) {
    error_log("Connection failed: " . $conn->connect_error);
    die("Database Connection Error.");
}
?>
