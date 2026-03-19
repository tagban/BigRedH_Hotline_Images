BigRedH Media Bridge: Documentation & Setup
The BigRedH Media Bridge is a specialized, ephemeral media sharing solution designed for the Hotline Communications network. It allows users to upload images and receive a direct URL that modern Hotline clients can render inline within chat.

System Requirements

PHP: 7.4 or higher.

Database: MySQL or MariaDB.

Extensions: mysqli, gd (for getimagesize), and openssl (for random_bytes).

Web Server: Apache (with mod_rewrite enabled for the included .htaccess).

Installation Steps
Database Setup:

Import the provided SQL Setup.sql into your database.

This creates the media_uploads table to track files and the banned_users table for moderation.

Configuration:

Open config.php and enter your database host, username, password, and database name.

Update the base_url to match your domain (e.g., http://images.yourserver.com/).

Security:

Run passwordHasher.php in your browser to generate a secure hash for your admin password.

Copy the resulting string and paste it into the admin_hash field in config.php.

File Permissions:

Create a directory named u/ in the root folder.

Ensure the web server has write access to this folder (typically chmod 755 or 775).

Automation:

Set up a Cron Job to run cleanup.php every hour to delete expired images:

0 * * * * php /path/to/your/site/cleanup.php

Features for Administrators

Moderation Gallery: Access admin.php to view all currently hosted images.


Manual Nuke: The "NUKE & BAN" button instantly deletes a file from the server and bans the uploader's IP address.

Ephemeral Storage: Files are automatically deleted after the timeframe specified in your config (default: 48 hours).

Rate Limiting: Prevents spam by limiting the number of uploads per IP within a specific window.

API Usage
To integrate this into a custom Hotline client or bot, send a POST request to upload.php:

Field: file (Binary image data).

Optional: client_id (To identify your specific application in the logs).
