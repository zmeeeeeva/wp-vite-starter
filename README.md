## ✨ WordPress starter with Bedrock, Vite, React & TailwindCSS

*My go-to WordPress starter.*

[![License](https://img.shields.io/badge/license-MIT-blue.svg)](LICENSE)
[![Node.js](https://img.shields.io/badge/node-16%2B-brightgreen)](https://nodejs.org/)
[![npm](https://img.shields.io/badge/npm-%3E%3D8-blue)](https://www.npmjs.com/)
[![WordPress](https://img.shields.io/badge/wordpress-6.x-orange)](https://wordpress.org/)

---

### Table of Contents

* [Features](#-features)
* [Prerequisites](#-prerequisites)
* [Getting Started](#-getting-started)
    * [1. Install Laravel Valet](#1-install-laravel-valet)
    * [2. Configure Environment](#2-configure-environment)
    * [3. Setup Theme](#3-setup-theme)
    * [4. Install PHP Dependencies](#4-install-php-dependencies)
    * [5. Install JS Dependencies](#5-install-js-dependencies)
    * [6. Run Development Server](#6-run-development-server)
* [Building for Production](#building-for-production)

---

## ✨ Features

* **Vite** with fast HMR & optimized builds
* **TailwindCSS** with BEM
* **React** component-based UI
* **SVG Sprites** out of the box
* **Google Fonts** integration
* **Google Analytics** configured

---

## ✨Prerequisites

Before you begin, ensure you have the following installed:

* [PHP 8.1+](https://www.php.net/downloads)
* [Composer](https://getcomposer.org/)
* [Node.js 16+ & npm](https://nodejs.org/en/)
* [Laravel Valet](https://laravel.com/docs/11.x/valet) (macOS)
* MySQL or MariaDB

---

## ✨ Getting Started

### 1. Install Laravel Valet

```bash
brew install php@8.1
composer global require laravel/valet
valet install
```

Link and secure your app:

```bash
cd <project-root>
valet link <app-name>
valet secure <app-name>
```

### 2. Configure Environment

1. Copy the sample file:

   ```bash
   cp .env.example .env
   ```
2. Edit `.env` and update:

    * `DB_NAME` – your database
    * `WP_SITEURL` – `https://<app-name>.test`
    * `THEME_NAME` – your theme folder/text domain

### 3. Setup Theme

Customize theme scaffolding by running:

```bash
chmod +x setup.sh
./setup.sh
```

Provide your theme name when prompted to update folder, namespace, and text domain.

### 4. Install PHP Dependencies

```bash
composer install
```

### 5. Install JS Dependencies

```bash
npm install
```

### 6. Run Development Server

```bash
npm run dev
```

Visit `https://<app-name>.test/wp` and complete the WordPress setup wizard.

---

## ✨ Building for Production

When you’re ready to ship:

```bash
npm run build
```

This generates optimized assets in `./public` for deployment.

> Crafted with  ✨ by [zmeeva.io](https://github.com/zmeeeeeva)
