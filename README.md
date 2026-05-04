# Radish

Radish is a full-stack SPA recipe-sharing platform with Laravel Sanctum-based authentication. Implemented features including recipe creation with image uploads, user comments, reactions, and favorites, along with a responsive UI and filtering.

## Live Demo
[View Live App](https://radish-production.up.railway.app)

## Features
- Browse and search recipes by name and ingredients
- Filter recipes by meal type and difficulty
- User authentication with protected routes
- Create, edit, and delete personal recipes with image uploads
- React to recipes with emoji reactions
- Comment and reply on recipes
- Save favorite recipes
- View public profiles of recipe creators (Raddishers)
- Fully responsive design

## Tech Stack
**Frontend:**
- Vue.js
- Tailwind CSS
- Axios

**Backend:**
- Laravel 12
- Laravel Sanctum (authentication)
- MySQL

**Other:**
- Cloudinary (image storage)
- Railway (deployment)

## Prerequisites

Before you begin, ensure you have the following installed:

- PHP 8.1 or higher
- Composer
- Node.js & NPM
- MySQL

## Installation

1. **Clone the repository**
   ```bash
   git clone https://github.com/Aldrin-DP/radish.git
   cd radish
   ```

2. **Install PHP dependencies**
   ```bash
   composer install
   ```

3. **Install JavaScript dependencies**
   ```bash
   npm install
   ```

4. **Environment setup**
   ```bash
   cp .env.example .env
   php artisan key:generate
   ```

5. **Configure your database**
   
   Update your `.env` file with your database credentials:
   ```env
   DB_CONNECTION=mysql
   DB_HOST=127.0.0.1
   DB_PORT=3306
   DB_DATABASE=mangarider
   DB_USERNAME=your_username
   DB_PASSWORD=your_password
   ```

6. **Run database migrations**
   ```bash
   php artisan migrate
   ```

7. **Build frontend assets**
   ```bash
   npm run dev
   ```

8. **Start the development server**
   ```bash
   php artisan serve
   ```

   Visit `http://localhost:8000` in your browser

## Author
**Aldrin Pelayo**
- GitHub: [@Aldrin-DP](https://github.com/Aldrin-DP)

## Credits
Recipe content (images, ingredients and instructions) used for demo purposes are sourced from [Eatwell101](https://www.eatwell101.com/)
