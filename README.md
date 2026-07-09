# URL Shortener

A simple URL shortener built with Laravel 12 and MySQL.
Users can generate short links that redirect anyone to the original URL.

---

## Roles

- **SuperAdmin** — invites new companies and their admins. Can view all short URLs across all companies.
- **Admin** — invites team members (admin or member) to their company. Can create short URLs and view all URLs in their company.
- **Member** — can create short URLs and view only their own.

---

## Setup

### Requirements

- PHP 8.2+
- Composer
- Node.js + npm
- MySQL (XAMPP or similar)

### Steps

**1. Clone the project**

```bash
git clone <your-github-repo-url>
cd URL-Shortner
```

**2. Install dependencies**

```bash
composer install
npm install
```

**3. Create environment file**

```bash
cp .env.example .env
php artisan key:generate
```

**4. Set up the database**

Edit `.env` and update these values:

```
DB_DATABASE=url_shortener
DB_USERNAME=root
DB_PASSWORD=
```

Create the database in phpMyAdmin manually (name it `url_shortener`).

**5. Run migrations and seed**

```bash
php artisan migrate:fresh --seed
```

This creates all tables and three test users:

| Email | Password | Role |
|---|---|---|
| superadmin@example.com | password | SuperAdmin |
| admin@acme.com | password | Admin |
| member@acme.com | password | Member |

**6. Build assets and start the server**

```bash
npm run build
php artisan serve
```

Visit: `http://127.0.0.1:8000`

---

## Running Tests

```bash
php artisan test
```

---

## How It Works

1. Login as Admin or Member and click **Generate URL**
2. Paste a long URL and submit
3. A short link is created (e.g. `http://127.0.0.1:8000/xk92mq`)
4. Anyone can visit that short link — no login needed — and get redirected to the original URL
