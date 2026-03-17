<?php include('config.php'); ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>BigRedH Media Bridge - Documentation</title>
    <style>
        body { background:#36393f; color:#dcddde; font-family:sans-serif; line-height:1.6; padding:40px; margin:0; }
        .container { max-width: 900px; margin: auto; }
        .box { background:#2f3136; padding:20px; border-radius:8px; margin-bottom:20px; border:1px solid #202225; }
        h1, h2, h3 { color:#fff; }
        pre { background:#202225; padding:15px; border-radius:8px; color:#85d2af; overflow-x:auto; }
        code { background:#202225; color:#faa61a; padding:2px 4px; border-radius:4px; font-family: monospace; }
        .method { background:#43b581; color:white; padding:3px 8px; border-radius:4px; font-size:12px; font-weight:bold; }
    </style>
</head>
<body>
<div class="container">
    <h1>BigRedH Media Bridge</h1>
    <p>The standard for ephemeral media sharing on the Hotline Communications network.</p>

    <div class="box">
        <h2>API Reference</h2>
        <h3><span class="method">POST</span> /upload.php</h3>
        <p><strong>Required Field:</strong> <code>file</code> (Binary image data)</p>
        <p><strong>Optional Field:</strong> <code>client_id</code> (String, max 50 chars. e.g. "MyHotlineClient-v1")</p>
        
        <pre>
// JSON Response
{
  "success": true,
  "url": "http://images.bigredh.com/u/abcdef123.jpg",
  "width": 1024,
  "height": 768,
  "expires_at": "2026-03-18 21:00:00"
}</pre>
    </div>

    <div class="box">
        <h2>Inline Rendering (Standard)</h2>
        <p>Clients should scan chat for this Regex and render the results as an image tag:</p>
        <code>http:\/\/images\.bigredh\.com\/u\/[a-f0-9]+\.(jpg|jpeg|png|gif|bmp)</code>
    </div>

    <div class="box">
        <h2>Server Maintenance</h2>
        <p>Administrators should set a Cron Job to run hourly (<code>0 * * * *</code>):</p>
        <code>php /path/to/cleanup.php</code>
    </div>

    <footer style="text-align:center; color:#72767d; font-size:12px;">
        Media Retention: <?php echo $web_config['media_expiry_hrs']; ?> Hours | <a href="admin.php" style="color:#72767d;">Admin Panel</a>
    </footer>
</div>
</body>
</html>