<?php
require_once('config.php');

// 1. Delete expired records from the Database
$sql = "DELETE FROM media_uploads WHERE expires_at < NOW()";
$conn->query($sql);

// 2. Scan the 'u/' folder for files that no longer have a DB record
$dir = "u/";
$files = glob($dir . "*");

foreach ($files as $file) {
    if (is_file($file)) {
        $filename = basename($file);
        
        // Check if this file still exists in our database
        $stmt = $conn->prepare("SELECT id FROM media_uploads WHERE filename = ?");
        $stmt->bind_param("s", $filename);
        $stmt->execute();
        $result = $stmt->get_result();
        
        // If it's NOT in the DB, it's expired or orphaned. Nuke it.
        if ($result->num_rows === 0) {
            unlink($file);
            echo "Deleted expired file: $filename <br>";
        }
    }
}

echo "Cleanup cycle complete.";
?>