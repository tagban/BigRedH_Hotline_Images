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
