# BigRedH Media Bridge 🚀

The **BigRedH Media Bridge** is a lightweight, ephemeral media sharing solution designed for the **Hotline Communications** network. It allows users to upload images and receive a direct URL that modern Hotline clients can render inline within chat.

---

## 🛠 Installation & Setup

### 1. Database Configuration
* [cite_start]Import the included `SQL Setup.sql` into your MySQL/MariaDB environment[cite: 1].
* [cite_start]This will create the `media_uploads` and `banned_users` tables[cite: 1].

### 2. Configure Environment
Open `config.php` and replace the following placeholders with your actual server details:

| Key | Description |
| :--- | :--- |
| `db_host` | Usually `localhost` |
| `db_user` | Your database username |
| `db_pass` | Your database password |
| `db_name` | Your database name |
| `base_url` | Your full URL (e.g., `https://images.yourdomain.com/`) |

### 3. Set Admin Password
1.  Run `passwordHasher.php` in your web browser.
2.  Copy the long hashed string provided on the page.
3.  Paste that string into the `admin_hash` field within `config.php`.

### 4. Permissions
* Ensure the `u/` directory exists in the root.
* The web server must have **write permissions** for this folder (e.g., `chmod 755 u/`).

---

## 🧹 Automated Maintenance
To keep your server from filling up, set a **Cron Job** to run the cleanup script every hour:

```bash
0 * * * * php /path/to/your/site/cleanup.php


---

## 🛡️ Moderation & Administration

The `admin.php` panel provides a visual interface for managing your ephemeral storage and maintaining community standards.

> [!IMPORTANT]
> Access to the admin panel is protected by the `admin_hash` set in your `config.php`. Ensure you use a strong password when generating your hash.

### Key Features:
* **Visual Gallery**: Review all currently hosted images in a responsive grid layout.
* **IP Tracking**: See the uploader's IP address and the specific Hotline client used for the upload.
* **Manual Nuke**: Instantly deletes the image from the `u/` directory and removes its database record.
* **Automated Banning**: Using the "Nuke" button automatically adds the uploader's IP to the `banned_users` table to prevent future abuse.

### Security Note
The included `.htaccess` file is configured to enforce **HTTPS** and strictly deny direct web access to your `config.php` file to prevent credential leakage.

---
