## About Laravel

Laravel is a web application framework with expressive, elegant syntax. We believe development must be an enjoyable and creative experience to be truly fulfilling. Laravel takes the pain out of development by easing common tasks used in many web projects.

## Project Setup Guide

### Prerequisites

Before you begin, ensure you have the following installed:
- PHP (^8.0.2 recommended)
- Composer
- Node.js (LTS version recommended)
- MySQL or other supported database system

### Installation

1. **Clone the repository**
   ```bash
   git clone e-commerce
   cd e-commerce
   ```

2. **Install PHP dependencies**

```bash
composer install
```

3. **Ensure storage:link is created**
Run this once if not already:

```bash
php artisan storage:link
```

4. **Database setup**

```bash
php artisan migrate
php artisan db:seed
```

5. **Install JavaScript dependencies**

```bash
npm install
```

### Running the Application

1. **Start the development server**

```bash
php artisan serve
```

2. **Compile assets**

```bash
npm run dev
```
