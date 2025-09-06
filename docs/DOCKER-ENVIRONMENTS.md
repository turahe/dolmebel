# Docker Compose Unified Environment

This guide explains how to use the unified Docker Compose configuration that works for both development and production environments with Traefik.

## 🏗️ Architecture Overview

### Unified Configuration (`docker-compose.yml`)
- **Single File**: Works for both development and production
- **Environment-Based**: Configured via environment variables
- **Traefik Integration**: Automatic SSL and routing
- **Security**: No internal ports exposed
- **Production Ready**: Container names, restart policies, health checks

### Optional Local Development (`docker-compose.local.yml`)
- **Simplified**: HTTP-only configuration for local development
- **Fast Setup**: No SSL certificates needed
- **Development Tools**: All debugging services enabled

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

### 2. Environment Configuration

Create a `.env` file in the project root:

```bash
# Application Configuration
APP_ENV=local                    # or 'production'
APP_DEBUG=true                   # or 'false' for production
APP_URL=http://dolmebel.local    # or 'https://dolmebel.com' for production

# Domain Configuration
DOMAIN=dolmebel.com

# Traefik Configuration
# For Development (HTTP):
TRAEFIK_ENTRYPOINT=web
TRAEFIK_PROTO=http
TRAEFIK_CERT_RESOLVER=

# For Production (HTTPS):
# TRAEFIK_ENTRYPOINT=websecure
# TRAEFIK_PROTO=https
# TRAEFIK_CERT_RESOLVER=letsencrypt

# Database Configuration
DB_DATABASE=dolmebel
DB_USERNAME=dolmebel
DB_PASSWORD=your-secure-password

# Service Configuration
MEILISEARCH_KEY=your-meilisearch-key
MINIO_ROOT_USER=admin
MINIO_ROOT_PASSWORD=your-secure-password
RABBITMQ_USER=admin
RABBITMQ_PASSWORD=your-secure-password
RABBITMQ_VHOST=/
RABBITMQ_QUEUE=default
PUSHER_APP_ID=app-id
PUSHER_APP_KEY=app-key
PUSHER_APP_SECRET=app-secret
ACME_EMAIL=admin@dolmebel.com

# Docker User Configuration
WWWGROUP=1000
WWWUSER=1000
```

### 3. Choose Your Environment

#### For Development (HTTP):
```bash
# Uses unified configuration with HTTP
docker-compose up -d
```

#### For Production (HTTPS):
```bash
# Set production environment variables
export APP_ENV=production
export APP_DEBUG=false
export APP_URL=https://dolmebel.com
export TRAEFIK_ENTRYPOINT=websecure
export TRAEFIK_PROTO=https
export TRAEFIK_CERT_RESOLVER=letsencrypt

# Start services
docker-compose up -d
```

#### For Local Development (Optional):
```bash
# Uses simplified local configuration
docker-compose -f docker-compose.local.yml up -d
```

## 🌐 Access Points

### Development (HTTP)
- **Main Application**: http://dolmebel.local
- **Traefik Dashboard**: http://traefik.dolmebel.local:8080
- **Mailpit**: http://mailpit.dolmebel.local
- **RabbitMQ Management**: http://rabbitmq.dolmebel.local

### Production (HTTPS)
- **Main Application**: https://dolmebel.com
- **Traefik Dashboard**: https://traefik.dolmebel.com
- **Mailpit**: https://mailpit.dolmebel.com
- **RabbitMQ Management**: https://rabbitmq.dolmebel.com

## 📋 Service Configuration

### Core Services

| Service | Purpose | Internal Port | External Access |
|---------|---------|---------------|-----------------|
| **Traefik** | Reverse Proxy | 80, 443, 8080 | ✅ HTTP/HTTPS + Dashboard |
| **App** | Laravel Application | 80 | ✅ Via Traefik |
| **PostgreSQL** | Database | 5432 | ❌ Internal Only |
| **Redis** | Cache/Sessions | 6379 | ❌ Internal Only |
| **Meilisearch** | Search Engine | 7700 | ❌ Internal Only |
| **MinIO** | Object Storage | 9000, 8900 | ❌ Internal Only |
| **Mailpit** | Email Testing | 8025 | ✅ Via Traefik |
| **RabbitMQ** | Message Queue | 5672, 15672 | ✅ Via Traefik |
| **Soketi** | WebSocket Server | 6001, 9601 | ❌ Internal Only |

### Security Features

- ✅ **No Internal Ports Exposed**: All services communicate internally
- ✅ **Traefik Routing**: Single entry point for external access
- ✅ **SSL Support**: Automatic HTTPS with Let's Encrypt
- ✅ **Container Names**: Explicit naming for better management
- ✅ **Restart Policies**: `unless-stopped` for production reliability
- ✅ **Health Checks**: Automatic service health monitoring

## 🛠️ Management Commands

### Using Unified Configuration

```bash
# Start services
docker-compose up -d

# Stop services
docker-compose down

# View logs
docker-compose logs -f
docker-compose logs -f app
docker-compose logs -f traefik

# Check status
docker-compose ps

# Restart services
docker-compose restart
docker-compose restart app

# Run Laravel commands
docker-compose exec app php artisan migrate
docker-compose exec app php artisan tinker
docker-compose exec app composer install

# Run NPM commands
docker-compose exec app npm install
docker-compose exec app npm run dev
docker-compose exec app npm run build
```

### Using Local Configuration (Optional)

```bash
# Start local services
docker-compose -f docker-compose.local.yml up -d

# Stop local services
docker-compose -f docker-compose.local.yml down

# Run commands in local environment
docker-compose -f docker-compose.local.yml exec app php artisan migrate
```

## 🔧 Environment Variables Reference

### Application Configuration
```bash
APP_ENV=local                    # Environment: local, production
APP_DEBUG=true                  # Debug mode: true, false
APP_URL=http://dolmebel.local   # Application URL
```

### Domain Configuration
```bash
DOMAIN=dolmebel.com             # Base domain for subdomains
```

### Traefik Configuration
```bash
TRAEFIK_ENTRYPOINT=web          # Entrypoint: web (HTTP), websecure (HTTPS)
TRAEFIK_PROTO=http              # Protocol: http, https
TRAEFIK_CERT_RESOLVER=          # SSL resolver: letsencrypt, empty
```

### Database Configuration
```bash
DB_DATABASE=dolmebel            # Database name
DB_USERNAME=dolmebel            # Database user
DB_PASSWORD=your-password       # Database password
```

### Service Configuration
```bash
# Meilisearch
MEILISEARCH_KEY=your-key        # Master key for Meilisearch

# MinIO
MINIO_ROOT_USER=admin          # MinIO root user
MINIO_ROOT_PASSWORD=password   # MinIO root password

# RabbitMQ
RABBITMQ_USER=admin            # RabbitMQ user
RABBITMQ_PASSWORD=password     # RabbitMQ password
RABBITMQ_VHOST=/               # RabbitMQ virtual host
RABBITMQ_QUEUE=default         # Default queue name

# Pusher/Soketi
PUSHER_APP_ID=app-id           # Pusher app ID
PUSHER_APP_KEY=app-key         # Pusher app key
PUSHER_APP_SECRET=app-secret   # Pusher app secret

# Let's Encrypt
ACME_EMAIL=admin@dolmebel.com  # Email for SSL certificates
```

## 🐛 Troubleshooting

### Common Issues

1. **Port conflicts**
   ```bash
   # Check what's using ports
   netstat -tulpn | grep :80
   netstat -tulpn | grep :443
   
   # Stop conflicting services
   sudo systemctl stop apache2  # or nginx
   ```

2. **SSL certificate issues (Production)**
   ```bash
   # Check Traefik logs
   docker-compose logs traefik
   
   # Verify domain DNS
   nslookup dolmebel.com
   ```

3. **Database connection issues**
   ```bash
   # Check database logs
   docker-compose logs pgsql
   
   # Test connection
   docker-compose exec app php artisan tinker
   # Then run: DB::connection()->getPdo();
   ```

4. **Application not accessible**
   ```bash
   # Check app logs
   docker-compose logs app
   
   # Check Traefik routing
   curl -I http://dolmebel.local
   ```

### Reset Environment

```bash
# Stop all services
docker-compose down

# Remove volumes (WARNING: This will delete all data)
docker volume prune -f

# Restart services
docker-compose up -d
```

## 🔒 Security Considerations

### Development
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
- No internal ports exposed

## 📁 File Structure

```
├── docker-compose.yml          # ✅ Unified configuration
├── docker-compose.local.yml    # ✅ Optional local development
├── docs/
│   ├── DOCKER-ENVIRONMENTS.md  # ✅ This documentation
│   └── DOCKER-ENVIRONMENTS.md  # ✅ Previous documentation
├── data/                       # ✅ Local data persistence
│   ├── postgres/
│   ├── redis/
│   ├── meilisearch/
│   ├── minio/
│   ├── rabbitmq/
│   └── traefik/
└── .env                        # ✅ Environment configuration
```

## 🚀 Deployment

### Development Deployment
```bash
# Clone repository
git clone <your-repo>
cd dolmebel

# Copy environment file
cp .env.example .env

# Start services
docker-compose up -d

# Run migrations
docker-compose exec app php artisan migrate

# Install dependencies
docker-compose exec app composer install
docker-compose exec app npm install
```

### Production Deployment
```bash
# Set production environment
export APP_ENV=production
export APP_DEBUG=false
export APP_URL=https://dolmebel.com
export TRAEFIK_ENTRYPOINT=websecure
export TRAEFIK_PROTO=https
export TRAEFIK_CERT_RESOLVER=letsencrypt

# Start services
docker-compose up -d

# Run production setup
docker-compose exec app php artisan migrate --force
docker-compose exec app php artisan config:cache
docker-compose exec app php artisan route:cache
docker-compose exec app php artisan view:cache
docker-compose exec app npm run build
```

## 📚 Additional Resources

- [Laravel Sail Documentation](https://laravel.com/docs/sail)
- [Traefik Documentation](https://doc.traefik.io/traefik/)
- [Docker Compose Documentation](https://docs.docker.com/compose/)
- [Let's Encrypt Documentation](https://letsencrypt.org/docs/)

## 🤝 Contributing

When adding new services:

1. Add to `docker-compose.yml` with environment-based configuration
2. Configure appropriate settings for both development and production
3. Update environment variables documentation
4. Update this documentation
5. Test both environments

## 📝 License

This project is open-sourced software licensed under the [MIT license](https://opensource.org/licenses/MIT).