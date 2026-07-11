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

1. Clone the project

```bash
git clone https://github.com/Abhiraj0406/URL-Shortner.git
cd URL-Shortner
```

2. Install PHP and JavaScript dependencies

```bash
composer install
npm install
```

3. Create the environment file

```bash
cp .env.example .env
php artisan key:generate
```

4. Configure the database

Open the `.env` file and update the database settings:

```env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=url_shortner
DB_USERNAME=root
DB_PASSWORD=
```


Run the database migration and seeding commands below to create the schema and seed the demo data.

5. Run the Artisan setup commands

```bash
php artisan migrate
php artisan db:seed
```

The migrations will create the tables and seed three demo users:

| Email | Password | Role |
|---|---|---|
| superadmin@example.com | password | SuperAdmin |
| admin@acme.com | password | Admin |
| member@acme.com | password | Member |

6. Build assets and start the app

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
