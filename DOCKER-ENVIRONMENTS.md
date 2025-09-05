# Docker Compose Local & Production Environments

This guide explains how to use separate Docker Compose configurations for local development and production environments with Traefik.

## 🏗️ Architecture Overview

### Local Development (`docker-compose.local.yml`)
- **Domain**: `dolmebel.local`
- **SSL**: HTTP only (no SSL certificates)
- **Debug**: Enabled
- **Volumes**: Bind mounts for live code changes
- **Services**: All development tools enabled

### Production (`docker-compose.prod.yml`)
- **Domain**: `dolmebel.com`
- **SSL**: HTTPS with Let's Encrypt certificates
- **Debug**: Disabled
- **Volumes**: Named volumes for data persistence
- **Services**: Optimized for production

## 🚀 Quick Start

### Prerequisites

- Docker Desktop installed and running
- Git
- PHP 8.4+ (for running Sail commands)

### 1. Clone and Setup

```bash
git clone <your-repo>
cd dolmebel
```

### 2. Choose Your Environment

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

## 🌐 Access Points

### Local Development
- **Main Application**: http://dolmebel.local
- **Traefik Dashboard**: http://traefik.dolmebel.local
- **Mailpit**: http://mailpit.dolmebel.local
- **RabbitMQ Management**: http://rabbitmq.dolmebel.local

### Production
- **Main Application**: https://dolmebel.com
- **Traefik Dashboard**: https://traefik.dolmebel.com
- **Mailpit**: https://mailpit.dolmebel.com
- **RabbitMQ Management**: https://rabbitmq.dolmebel.com

## 📋 Environment Configurations

### Local Development Features

#### `docker-compose.local.yml`
- **HTTP Only**: No SSL certificates for faster development
- **Debug Mode**: Full debugging enabled
- **Live Reload**: Code changes reflect immediately
- **Development Tools**: All debugging services enabled
- **Local Domain**: Uses `.local` TLD for local development

#### `env.local`
```env
APP_ENV=local
APP_DEBUG=true
APP_URL=http://dolmebel.local
DOMAIN=dolmebel.local
LOG_LEVEL=debug
```

### Production Features

#### `docker-compose.prod.yml`
- **HTTPS Only**: Automatic SSL certificates via Let's Encrypt
- **Production Optimized**: Debug disabled, caching enabled
- **Data Persistence**: Named volumes for data safety
- **Security**: Enhanced security configurations
- **Real Domain**: Uses actual domain for production

#### `env.prod`
```env
APP_ENV=production
APP_DEBUG=false
APP_URL=https://dolmebel.com
DOMAIN=dolmebel.com
LOG_LEVEL=error
SESSION_ENCRYPT=true
```

## 🛠️ Management Commands

### Using Environment Scripts

#### Linux/macOS (`sail-env.sh`):
```bash
# Start environments
bash sail-env.sh start-local       # Start local development
bash sail-env.sh start-prod        # Start production

# Stop environments
bash sail-env.sh stop local         # Stop local environment
bash sail-env.sh stop prod          # Stop production environment
bash sail-env.sh stop               # Stop all environments

# Restart environments
bash sail-env.sh restart local      # Restart local environment
bash sail-env.sh restart prod       # Restart production environment

# View logs
bash sail-env.sh logs local         # View local logs
bash sail-env.sh logs prod          # View production logs

# Check status
bash sail-env.sh status local       # Check local status
bash sail-env.sh status prod         # Check production status

# Run commands
bash sail-env.sh artisan local migrate # Run artisan in local
bash sail-env.sh artisan prod migrate  # Run artisan in production
bash sail-env.sh npm local run dev     # Run npm in local
bash sail-env.sh npm prod run build    # Run npm in production

# Setup environment
bash sail-env.sh setup local        # Setup local environment
bash sail-env.sh setup prod         # Setup production environment
```

#### Windows (`sail-env.bat`):
```cmd
# Start environments
.\sail-env.bat start-local        # Start local development
.\sail-env.bat start-prod         # Start production

# Stop environments
.\sail-env.bat stop local          # Stop local environment
.\sail-env.bat stop prod           # Stop production environment
.\sail-env.bat stop                # Stop all environments

# Restart environments
.\sail-env.bat restart local       # Restart local environment
.\sail-env.bat restart prod        # Restart production environment

# View logs
.\sail-env.bat logs local          # View local logs
.\sail-env.bat logs prod           # View production logs

# Check status
.\sail-env.bat status local        # Check local status
.\sail-env.bat status prod          # Check production status

# Run commands
.\sail-env.bat artisan local migrate # Run artisan in local
.\sail-env.bat artisan prod migrate  # Run artisan in production
.\sail-env.bat npm local run dev     # Run npm in local
.\sail-env.bat npm prod run build    # Run npm in production

# Setup environment
.\sail-env.bat setup local         # Setup local environment
.\sail-env.bat setup prod          # Setup production environment
```

### Direct Sail Commands

```bash
# Local environment
php vendor/bin/sail -f docker-compose.local.yml up -d
php vendor/bin/sail -f docker-compose.local.yml down
php vendor/bin/sail -f docker-compose.local.yml artisan migrate
php vendor/bin/sail -f docker-compose.local.yml npm run dev

# Production environment
php vendor/bin/sail -f docker-compose.prod.yml up -d
php vendor/bin/sail -f docker-compose.prod.yml down
php vendor/bin/sail -f docker-compose.prod.yml artisan migrate --force
php vendor/bin/sail -f docker-compose.prod.yml npm run build
```

## 🔧 Configuration Details

### Traefik Configuration

#### Local Development
- **API Dashboard**: Insecure (HTTP)
- **SSL**: Disabled
- **Certificates**: None
- **Logging**: Debug level

#### Production
- **API Dashboard**: Secure (HTTPS)
- **SSL**: Enabled with Let's Encrypt
- **Certificates**: Automatic renewal
- **Logging**: Info level

### Service Differences

| Service | Local | Production |
|---------|-------|------------|
| **SSL** | HTTP only | HTTPS with Let's Encrypt |
| **Debug** | Enabled | Disabled |
| **Volumes** | Bind mounts | Named volumes |
| **Restart Policy** | unless-stopped | unless-stopped |
| **Container Names** | `-local` suffix | `-prod` suffix |
| **Data Persistence** | Development data | Production data |

### Environment Variables

#### Local (`env.local`)
- `APP_ENV=local`
- `APP_DEBUG=true`
- `APP_URL=http://dolmebel.local`
- `DOMAIN=dolmebel.local`
- `LOG_LEVEL=debug`
- `SESSION_ENCRYPT=false`

#### Production (`env.prod`)
- `APP_ENV=production`
- `APP_DEBUG=false`
- `APP_URL=https://dolmebel.com`
- `DOMAIN=dolmebel.com`
- `LOG_LEVEL=error`
- `SESSION_ENCRYPT=true`

## 🐛 Troubleshooting

### Common Issues

1. **Environment file not found**
   ```bash
   # Check available environment files
   ls env.*
   
   # Setup environment
   ./sail-env.sh setup local
   ```

2. **Port conflicts**
   ```bash
   # Check what's using ports
   netstat -tulpn | grep :80
   netstat -tulpn | grep :443
   
   # Stop conflicting services
   sudo systemctl stop apache2  # or nginx
   ```

3. **SSL certificate issues (Production)**
   ```bash
   # Check Traefik logs
   ./sail-env.sh logs prod
   
   # Verify domain DNS
   nslookup dolmebel.com
   ```

4. **Database connection issues**
   ```bash
   # Check database logs
   ./sail-env.sh logs prod
   
   # Test connection
   ./sail-env.sh artisan prod tinker
   # Then run: DB::connection()->getPdo();
   ```

### Reset Environments

```bash
# Reset local environment
./sail-env.sh stop local
docker volume prune -f
./sail-env.sh start-local

# Reset production environment
./sail-env.sh stop prod
docker volume prune -f
./sail-env.sh start-prod
```

## 🔒 Security Considerations

### Local Development
- HTTP only (no SSL)
- Debug mode enabled
- Development passwords
- Local domain resolution

### Production
- HTTPS enforced
- Debug mode disabled
- Secure passwords required
- Real domain with SSL
- Data encryption enabled

## 📚 Additional Resources

- [Laravel Sail Documentation](https://laravel.com/docs/sail)
- [Traefik Documentation](https://doc.traefik.io/traefik/)
- [Docker Compose Documentation](https://docs.docker.com/compose/)
- [Let's Encrypt Documentation](https://letsencrypt.org/docs/)

## 🤝 Contributing

When adding new services:

1. Add to both `docker-compose.local.yml` and `docker-compose.prod.yml`
2. Configure appropriate settings for each environment
3. Update environment files (`env.local` and `env.prod`)
4. Update management scripts
5. Update this documentation
6. Test both environments

## 📝 License

This project is open-sourced software licensed under the [MIT license](https://opensource.org/licenses/MIT).
