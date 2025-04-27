# Health Information System - Client Management

## Project Overview

This system allows:

- Registering new clients
- Uploading client photos
- Viewing client profiles
- Searching for clients
- Viewing enrolled health programs

It is built using **PHP**, **MySQL**, **HTML/CSS**, and provides an **API** for client data access.

## Features

- 📄 Client registration with photo upload
- 📄 Program Management
- 🔍 Client search and profile viewing
- ✅ Duplicate email prevention
- 🔗 API endpoint for client data (`api_client.php`)

## Installation

1. Clone this repository
2. Import `health_system.sql` into your MySQL server from database column
3. Configure your database connection in `/includes/db.php`
4. Place project folder into your XAMPP/WAMP `htdocs`
5. Access it via `http://localhost/health-info-system/index.php`

## API Endpoint

- **GET** `/api_client.php?id=CLIENT_ID`
- **Response:** JSON containing client information.

## Technologies

- PHP
- MySQL
- HTML5/CSS3
- JavaScript (for modals)

---

✅ Project completed with ❤️ by [Rodgers Ndiege]
