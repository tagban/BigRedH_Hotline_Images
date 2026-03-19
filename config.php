<?php
// Prevent direct access to config file
if (count(get_included_files()) == 1) exit("Direct access not permitted.");

$web_config = [
    // Database Credentials
    'db_host' => 'localhost',
    'db_user' => 'YOUR_USERNAME',
    'db_pass' => 'YOUR_PASS',
    'db_name' => 'YOUR_DB',

    // Security & Logic
    'admin_hash'       => 'YOUR_HASHED_PASSWORD', // Replace with your actual hash
    'media_expiry_hrs' => 48,
    'upload_limit'     => 5,     
    'limit_window'     => 600,   
    'base_url'         => 'http://images.bigredh.com/' 
];

// Establish Connection
$conn = new mysqli($web_config['db_host'], $web_config['db_user'], $web_config['db_pass'], $web_config['db_name']);

if ($conn->connect_error) {
    error_log("Connection failed: " . $conn->connect_error);
    die("Database Connection Error.");
}
?>