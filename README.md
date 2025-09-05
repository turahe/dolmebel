# 🏪 Dolmebel - Laravel 12 E-commerce Platform

A modern, full-featured e-commerce platform built with Laravel 12, featuring Vue.js frontend, Docker containerization, and comprehensive CI/CD workflows.

## 🚀 Features

### Core Framework
- **Laravel 12** - Latest Laravel framework with PHP 8.4 support
- **Vue.js 3** - Modern reactive frontend with Inertia.js
- **Tailwind CSS 4** - Utility-first CSS framework
- **Vite 7** - Lightning-fast build tool
- **TypeScript** - Type-safe JavaScript development

### E-commerce Features
- **Product Management** - Complete product catalog with categories, brands, and suppliers
- **Shopping Cart** - Full cart functionality with session management
- **Checkout Process** - Secure checkout with multiple payment methods
- **Order Management** - Comprehensive order tracking and management
- **Inventory Management** - Real-time inventory tracking
- **Pricing System** - Flexible pricing with discounts and promotions

### User Management
- **Authentication** - Laravel Breeze authentication system
- **User Roles & Permissions** - Spatie Laravel Permission package
- **Profile Management** - Complete user profile system
- **Address Management** - Multiple addresses per user
- **Wallet System** - Digital wallet functionality

### Content Management
- **Blog System** - Full blog with categories and tags
- **FAQ Management** - Dynamic FAQ system
- **Page Management** - Custom pages with SEO optimization
- **Media Management** - File upload and management system
- **SEO Tools** - Built-in SEO optimization

### Development Features
- **Docker Support** - Complete Docker containerization with Laravel Sail
- **Traefik Integration** - Reverse proxy with automatic SSL
- **Multiple Environments** - Local and production configurations
- **CI/CD Workflows** - GitHub Actions for testing and deployment
- **Code Quality** - PHPStan, Laravel Pint, and PHP CS Fixer
- **Testing** - Comprehensive test suite with PHPUnit

## 📋 Requirements

- **PHP**: 8.2 or higher (8.4 recommended)
- **Composer**: 2.0 or higher
- **Node.js**: 18 or higher (20 recommended)
- **npm**: 9 or higher
- **Docker**: 20.10 or higher
- **Docker Compose**: 2.0 or higher

## 🛠️ Installation

### 1. Clone the Repository
```bash
git clone https://github.com/turahe/dolmebel.git
cd dolmebel
```

### 2. Install Dependencies
```bash
# Install PHP dependencies
composer install

# Install Node.js dependencies
npm install --legacy-peer-deps
```

### 3. Environment Setup
```bash
# Copy environment file
cp .env.example .env

# Generate application key
php artisan key:generate

# Create SQLite database for testing
touch database/database.sqlite
```

### 4. Database Setup
```bash
# Run migrations
php artisan migrate

# Seed the database
php artisan db:seed
```

### 5. Build Assets
```bash
# Build frontend assets
npm run build

# Or for development
npm run dev
```

## 🐳 Docker Setup

### Quick Start with Docker

#### For Local Development:
```bash
# Linux/macOS
bash sail-env.sh start-local

# Windows
.\sail-env.bat start-local
```

#### For Production:
```bash
# Linux/macOS
bash sail-env.sh start-prod

# Windows
.\sail-env.bat start-prod
```

### Manual Docker Commands

#### Local Environment:
```bash
# Start local development
php vendor/bin/sail -f docker-compose.local.yml up -d

# Access application
# http://dolmebel.local
```

#### Production Environment:
```bash
# Start production
php vendor/bin/sail -f docker-compose.prod.yml up -d

# Access application
# https://dolmebel.com
```

### Docker Services Included

- **Laravel Application** - Main application container
- **MySQL** - Database server
- **Redis** - Caching and session storage
- **Meilisearch** - Search engine
- **MinIO** - S3-compatible object storage
- **Mailpit** - Email testing
- **RabbitMQ** - Message queue
- **Soketi** - WebSocket server
- **Traefik** - Reverse proxy with SSL

## 🌐 Access Points

### Local Development
- **Main Application**: http://dolmebel.local
- **Traefik Dashboard**: http://traefik.dolmebel.local
- **Mailpit**: http://mailpit.dolmebel.local
- **RabbitMQ**: http://rabbitmq.dolmebel.local

### Production
- **Main Application**: https://dolmebel.com
- **Traefik Dashboard**: https://traefik.dolmebel.com
- **Mailpit**: https://mailpit.dolmebel.com
- **RabbitMQ**: https://rabbitmq.dolmebel.com

## 🧪 Testing

### Run Tests
```bash
# Run all tests
php artisan test

# Run with coverage
php artisan test --coverage

# Run specific test suite
php artisan test --testsuite=Feature
php artisan test --testsuite=Unit
```

### Test Configuration
- **PHPUnit** - Unit and feature testing
- **SQLite** - In-memory database for testing
- **Faker** - Test data generation
- **Mockery** - Mocking framework

## 🔧 Development Tools

### Code Quality
```bash
# Laravel Pint (Code formatting)
./vendor/bin/pint

# PHPStan (Static analysis)
./vendor/bin/phpstan analyse

# PHP CS Fixer
./vendor/bin/php-cs-fixer fix
```

### Frontend Development
```bash
# Start Vite dev server
npm run dev

# Build for production
npm run build

# Watch for changes
npm run watch
```

### Database Management
```bash
# Run migrations
php artisan migrate

# Rollback migrations
php artisan migrate:rollback

# Seed database
php artisan db:seed

# Fresh migration with seeding
php artisan migrate:fresh --seed
```

## 📁 Project Structure

```
dolmebel/
├── app/
│   ├── Concerns/           # Shared concerns and traits
│   ├── Contracts/          # Repository interfaces
│   ├── Enums/             # PHP enums
│   ├── Events/            # Event classes
│   ├── Http/
│   │   ├── Controllers/   # Application controllers
│   │   └── Requests/      # Form request validation
│   ├── Models/            # Eloquent models
│   ├── Notifications/     # Email notifications
│   ├── Providers/         # Service providers
│   └── Repositories/      # Repository implementations
├── config/                 # Configuration files
├── database/
│   ├── factories/         # Model factories
│   ├── migrations/         # Database migrations
│   └── seeders/           # Database seeders
├── resources/
│   ├── css/               # Stylesheets
│   ├── js/
│   │   ├── components/    # Vue components
│   │   └── Pages/         # Inertia pages
│   └── views/             # Blade templates
├── routes/                # Route definitions
├── tests/                 # Test files
├── docker-compose.yml     # Main Docker Compose
├── docker-compose.local.yml  # Local environment
├── docker-compose.prod.yml   # Production environment
├── sail-env.sh           # Linux/macOS management script
├── sail-env.bat           # Windows management script
└── README.md              # This file
```

## 🔄 CI/CD Workflows

### GitHub Actions

#### Test Workflow (`.github/workflows/run-tests.yml`)
- **PHP 8.4** with all required extensions
- **MySQL 8.0** service
- **Node.js 20** with npm caching
- **Composer** dependency installation
- **Laravel** testing with coverage
- **Codecov** integration

#### Security Analysis (`.github/workflows/security-analysis.yml`)
- **Composer Audit** - Dependency vulnerability scanning
- **PHPStan** - Static analysis
- **Laravel Pint** - Code formatting
- **PHP CS Fixer** - Code style fixing
- **Dependency Review** - Security review

#### Deployment (`.github/workflows/deploy.yml`)
- **SSH Deployment** - Secure server deployment
- **Asset Building** - Frontend compilation
- **Database Migrations** - Production migrations
- **Service Reload** - Application restart

## 🚀 Deployment

### Production Deployment

1. **Server Requirements**:
   - Ubuntu 20.04+ or similar
   - Docker and Docker Compose
   - SSH access
   - Domain name configured

2. **Environment Variables**:
   ```env
   APP_ENV=production
   APP_DEBUG=false
   DB_CONNECTION=mysql
   DB_HOST=mysql
   DB_DATABASE=dolmebel
   DB_USERNAME=dolmebel
   DB_PASSWORD=your_secure_password
   ```

3. **Deploy**:
   ```bash
   # Using GitHub Actions (automatic)
   git push origin main

   # Manual deployment
   php vendor/bin/sail -f docker-compose.prod.yml up -d
   ```

## 📚 Documentation

- **[Docker Environments](DOCKER-ENVIRONMENTS.md)** - Complete Docker setup guide
- **[GitHub Workflows](.github/workflows/README.md)** - CI/CD documentation
- **[Laravel Documentation](https://laravel.com/docs)** - Official Laravel docs
- **[Vue.js Documentation](https://vuejs.org/guide/)** - Vue.js guide
- **[Inertia.js Documentation](https://inertiajs.com/)** - Inertia.js guide

## 🤝 Contributing

1. Fork the repository
2. Create a feature branch (`git checkout -b feature/amazing-feature`)
3. Commit your changes (`git commit -m 'Add some amazing feature'`)
4. Push to the branch (`git push origin feature/amazing-feature`)
5. Open a Pull Request

### Development Guidelines

- Follow PSR-12 coding standards
- Write tests for new features
- Update documentation as needed
- Use conventional commit messages

## 📄 License

This project is licensed under the MIT License - see the [LICENSE](LICENSE) file for details.

## 🆘 Support

- **Issues**: [GitHub Issues](https://github.com/your-username/dolmebel/issues)
- **Discussions**: [GitHub Discussions](https://github.com/your-username/dolmebel/discussions)
- **Email**: support@dolmebel.com

## 🙏 Acknowledgments

- [Laravel](https://laravel.com/) - The PHP framework
- [Vue.js](https://vuejs.org/) - The progressive JavaScript framework
- [Tailwind CSS](https://tailwindcss.com/) - Utility-first CSS framework
- [Inertia.js](https://inertiajs.com/) - The modern monolith
- [Traefik](https://traefik.io/) - The cloud native application proxy
- [Docker](https://www.docker.com/) - Containerization platform

---

**Built with ❤️ using Laravel 12, Vue.js 3, and modern web technologies.**
