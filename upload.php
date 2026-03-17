<?php
header('Content-Type: application/json');
header('Access-Control-Allow-Origin: *'); 
require_once('config.php');

$ip = $_SERVER['REMOTE_ADDR'];

// 1. Check for IP Bans
$checkBan = $conn->prepare("SELECT reason FROM banned_users WHERE identifier = ? AND type = 'IP'");
$checkBan->bind_param("s", $ip);
$checkBan->execute();
if ($checkBan->get_result()->num_rows > 0) {
    http_response_code(403);
    echo json_encode(["success" => false, "error" => "Access Denied: IP Banned"]);
    exit;
}

// 2. Capture Client ID (from POST or Header)
$client_id = $_POST['client_id'] ?? ($_SERVER['HTTP_X_CLIENT_ID'] ?? 'Unknown');
$client_id = substr(preg_replace("/[^a-zA-Z0-9\-\.]/", "", $client_id), 0, 50);

// 3. Rate Limiting Check
$checkLimit = $conn->prepare("SELECT COUNT(*) as total FROM media_uploads WHERE uploader_ip = ? AND upload_time > DATE_SUB(NOW(), INTERVAL ? SECOND)");
$checkLimit->bind_param("si", $ip, $web_config['limit_window']);
$checkLimit->execute();
if ($checkLimit->get_result()->fetch_assoc()['total'] >= $web_config['upload_limit']) {
    http_response_code(429);
    echo json_encode(["success" => false, "error" => "Rate limit exceeded. Please wait."]);
    exit;
}

// 4. Validate Upload
if (!isset($_FILES['file']) || $_FILES['file']['error'] !== UPLOAD_ERR_OK) {
    http_response_code(400);
    echo json_encode(["success" => false, "error" => "No file uploaded or server error."]);
    exit;
}

$ext = strtolower(pathinfo($_FILES['file']['name'], PATHINFO_EXTENSION));
$allowed = ['jpg', 'jpeg', 'png', 'gif', 'bmp'];
if (!in_array($ext, $allowed)) {
    http_response_code(415);
    echo json_encode(["success" => false, "error" => "Unsupported file type."]);
    exit;
}

// 5. Save File and Respond
$filename = bin2hex(random_bytes(12)) . "." . $ext;
$target = "u/" . $filename;

if (move_uploaded_file($_FILES['file']['tmp_name'], $target)) {
    list($width, $height) = getimagesize($target);
    $expiry = date('Y-m-d H:i:s', strtotime("+{$web_config['media_expiry_hrs']} hours"));

    $stmt = $conn->prepare("INSERT INTO media_uploads (filename, uploader_ip, client_id, expires_at) VALUES (?, ?, ?, ?)");
    $stmt->bind_param("ssss", $filename, $ip, $client_id, $expiry);
    $stmt->execute();

    echo json_encode([
        "success" => true,
        "url" => $web_config['base_url'] . $target,
        "width" => $width,
        "height" => $height,
        "expires_at" => $expiry,
        "client" => $client_id
    ]);
}
?>