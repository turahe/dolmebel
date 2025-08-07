# GitHub Actions Workflows

This directory contains GitHub Actions workflows for the Laravel 12 application.

## Workflows

### 1. Laravel Tests (`run-tests.yml`)

**Triggers:** Push to master/main, Pull requests to master/main

**Purpose:** Runs the main test suite for the Laravel application.

**Features:**
- PHP 8.4 setup with all required extensions
- Node.js 20 for frontend asset building
- MySQL 8.0 service for database testing
- SQLite for unit tests
- Code coverage reporting with Codecov
- Automatic database migration and seeding

**Steps:**
1. Checkout code
2. Setup PHP 8.4 with extensions
3. Setup Node.js 20
4. Copy environment file
5. Install Composer and NPM dependencies
6. Build assets
7. Generate application key
8. Set directory permissions
9. Create database and run migrations
10. Execute tests with coverage
11. Upload coverage to Codecov

### 2. Security Analysis (`security-analysis.yml`)

**Triggers:** Push to master/main, Pull requests to master/main, Weekly (Sundays)

**Purpose:** Performs security checks and static code analysis.

**Features:**
- Composer security audit
- PHPStan static analysis
- Laravel Pint code style checking
- PHP CS Fixer code style validation
- Dependency review for pull requests

**Steps:**
1. Checkout code
2. Setup PHP 8.4
3. Install Composer dependencies
4. Run Composer audit
5. Run PHPStan analysis
6. Run Laravel Pint
7. Run PHP CS Fixer
8. Dependency review (PR only)

### 3. Deploy to Production (`deploy.yml`)

**Triggers:** Push to master, Manual dispatch

**Purpose:** Deploys the application to production server.

**Features:**
- Production-optimized builds
- Caching of config, routes, and views
- Database migrations
- Server reload commands

**Steps:**
1. Checkout code
2. Setup PHP 8.4 and Node.js 20
3. Install production dependencies
4. Build assets
5. Generate application key
6. Cache configuration, routes, and views
7. Run database migrations
8. Deploy to server via SSH
9. Reload PHP-FPM and Nginx

## Required Secrets

For the deployment workflow, you need to configure these secrets in your GitHub repository:

- `HOST`: Your server's IP address or domain
- `USERNAME`: SSH username
- `SSH_KEY`: Private SSH key for server access
- `PORT`: SSH port (usually 22)

## Configuration

### Environment Variables

The workflows use these environment variables for testing:

```bash
DB_CONNECTION=sqlite
DB_DATABASE=database/database.sqlite
CACHE_DRIVER=array
QUEUE_CONNECTION=sync
SESSION_DRIVER=array
MAIL_MAILER=array
```

### Code Coverage

The test workflow generates code coverage reports and uploads them to Codecov. The minimum coverage is set to 80%.

### Dependencies

The workflows automatically install and cache:
- Composer dependencies
- NPM dependencies
- PHP extensions
- Node.js modules

## Local Development

To run the same checks locally:

```bash
# Install dependencies
composer install
npm install

# Run tests
php artisan test

# Run security audit
composer audit

# Run static analysis (if PHPStan is installed)
./vendor/bin/phpstan analyse

# Run code style checks
./vendor/bin/pint --test
```

## Troubleshooting

### Common Issues

1. **Memory limits**: PHPStan may need more memory. The workflow sets `--memory-limit=2G`.

2. **Database connection**: Tests use SQLite for faster execution. Production uses MySQL.

3. **Asset building**: Make sure your `package.json` has a `build` script.

4. **Permissions**: The workflow sets proper permissions for storage and cache directories.

### Adding New Tools

To add new static analysis or testing tools:

1. Add the tool to your `composer.json` or `package.json`
2. Update the appropriate workflow file
3. Add the tool to the local development instructions above
