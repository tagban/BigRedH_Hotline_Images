<?php
session_start();
require_once('config.php');

if (isset($_GET['logout'])) { session_destroy(); header("Location: admin.php"); exit; }

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['password'])) {
    if (password_verify($_POST['password'], $web_config['admin_hash'])) {
        $_SESSION['media_admin'] = true;
        header("Location: admin.php");
        exit;
    }
}

if (!isset($_SESSION['media_admin'])): 
?>
    <body style="background:#23272a; color:white; font-family:sans-serif; display:flex; justify-content:center; align-items:center; height:100vh;">
        <form method="POST" style="background:#2f3136; padding:40px; border-radius:8px; text-align:center;">
            <h2>BigRedH Admin</h2>
            <input type="password" name="password" style="padding:10px; width:200px;"><br><br>
            <button type="submit" style="background:#5865f2; color:white; border:none; padding:10px 20px; border-radius:4px; cursor:pointer;">Login</button>
        </form>
    </body>
<?php else: 

if (isset($_GET['nuke'])) {
    $id = (int)$_GET['nuke'];
    $res = $conn->query("SELECT filename, uploader_ip FROM media_uploads WHERE id = $id")->fetch_assoc();
    if ($res) {
        if(file_exists("u/".$res['filename'])) unlink("u/".$res['filename']);
        $ip = $conn->real_escape_string($res['uploader_ip']);
        $conn->query("INSERT INTO banned_users (identifier, type, reason) VALUES ('$ip', 'IP', 'Manual Nuke')");
        $conn->query("DELETE FROM media_uploads WHERE id = $id");
    }
}

$result = $conn->query("SELECT * FROM media_uploads ORDER BY upload_time DESC");
?>
    <body style="background:#36393f; color:white; font-family:sans-serif; padding:20px;">
        <header style="display:flex; justify-content:space-between; align-items:center;">
            <h1>Moderation Gallery</h1>
            <a href="?logout=1" style="color:#72767d;">Logout</a>
        </header>
        <div style="display:grid; grid-template-columns: repeat(auto-fill, minmax(200px, 1fr)); gap:20px; margin-top:20px;">
            <?php while($row = $result->fetch_assoc()): ?>
                <div style="background:#2f3136; padding:10px; border-radius:4px; border:1px solid #202225;">
                    <img src="u/<?php echo $row['filename']; ?>" style="width:100%; height:140px; object-fit:contain; background:#000;">
                    <div style="font-size:11px; color:#b9bbbe; margin:10px 0;">
                        IP: <?php echo htmlspecialchars($row['uploader_ip']); ?><br>
                        App: <span style="color:#5865f2;"><?php echo htmlspecialchars($row['client_id']); ?></span>
                    </div>
                    <a href="?nuke=<?php echo $row['id']; ?>" style="display:block; text-align:center; background:#f04747; color:white; text-decoration:none; padding:5px; border-radius:3px; font-weight:bold;">NUKE & BAN</a>
                </div>
            <?php endwhile; ?>
        </div>
    </body>
<?php endif; ?>