BigRedH Media Bridge
An Ephemeral Media Gateway for the Hotline Communications Protocol
The BigRedH Media Bridge is a legacy-friendly, zero-SSL, HTTP-based API that allows Hotline clients to share and render inline media. By bridging the gap between 1990s-era text chat and modern rich media expectations, it provides a "fool-proof" workflow for the entire community.

🚀 The BigRedH Workflow
Upload: A modern Hotline client uploads an image to the bridge via a simple POST request.

Response: The bridge returns a JSON object containing a direct URL, image dimensions, and an expiration timestamp.

Broadcast: The client sends the URL as a standard Hotline chat message.

Render: Receiving clients recognize the images.bigredh.com domain via Regex and render the image inline. Legacy clients see a clickable link compatible with retro browsers.

🛠 Installation for Server Hosts
1. Database Setup
Import the provided database.sql into your MariaDB/MySQL environment. This creates the tables for tracking uploads and managing bans.

2. Configuration
Rename config.sample.php to config.php and update your credentials:

DB Details: Host, User, Pass, Name.

Security: Generate a password hash for the admin panel.

Retention: Set your media_expiry_hrs (Default: 48).

3. Permissions
Create a folder named u/ in your root directory and ensure it is writable by the server:

Bash
mkdir u
chmod 755 u
4. The Janitor (Cron Job)
To automate the 48-hour purge logic, set a Cron Job to run hourly:

Bash
0 * * * * php /path/to/cleanup.php
📡 API Documentation
POST /upload.php
Accepts image data and returns metadata.

Parameters:

file (Required): Binary image data (multipart/form-data).

client_id (Optional): String identifying your client software.

Sample Response:

JSON
{
  "success": true,
  "url": "http://images.bigredh.com/u/abcdef123456.jpg",
  "width": 1024,
  "height": 768,
  "expires_at": "2026-03-18 20:00:00",
  "client": "HotlineClient-v1"
}
Client Rendering Regex
Use this to scan chat logs for BigRedH media:
http:\/\/images\.bigredh\.com\/u\/[a-f0-9]+\.(jpg|jpeg|png|gif|bmp)

🛡 Moderation
The included admin.php provides a visual grid of all active media on your server.

Visual Audit: Instantly scan all current uploads.

IP Tracing: Identify the source of any upload.

Nuke & Ban: Single-click logic to delete the file, remove the database entry, and blacklist the uploader's IP.

📝 License
Distributed under the MIT License. See LICENSE for more information.
