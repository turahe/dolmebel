# Laravel Sail with Traefik Setup

This guide explains how to use Laravel Sail with Traefik for local development with automatic SSL certificates and reverse proxy capabilities.

## 🚀 Quick Start

### Prerequisites

- Docker Desktop installed and running
- Git
- PHP 8.4+ (for running Sail commands)

### 1. Clone and Setup

```bash
git clone <your-repo>
cd dolmebel
cp env.example .env
```

### 2. Configure Environment

Edit your `.env` file and update the following Traefik settings:

```env
# Traefik Configuration
DOMAIN=dolmebel.com
ACME_EMAIL=admin@dolmebel.com

# Laravel Sail Configuration
WWWGROUP=1000
WWWUSER=1000
SAIL_XDEBUG_MODE=develop,debug
SAIL_XDEBUG_CONFIG="client_host=host.docker.internal"
```

### 3. Setup Hosts File

**Linux/macOS:**
```bash
./sail-traefik.sh setup-hosts
```

**Windows:**
```cmd
sail-traefik.bat setup-hosts
```

Or manually add to your hosts file:
```
127.0.0.1 dolmebel.com
127.0.0.1 traefik.dolmebel.com
127.0.0.1 mailpit.dolmebel.com
127.0.0.1 rabbitmq.dolmebel.com
```

### 4. Start Services

**Linux/macOS:**
```bash
./sail-traefik.sh start
```

**Windows:**
```cmd
sail-traefik.bat start
```

## 🌐 Access Points

Once started, you can access:

- **Main Application**: https://dolmebel.com
- **Traefik Dashboard**: https://traefik.dolmebel.com
- **Mailpit (Email Testing)**: https://mailpit.dolmebel.com
- **RabbitMQ Management**: https://rabbitmq.dolmebel.com

## 📋 Available Services

### Core Services
- **Laravel App**: PHP 8.4 with Apache
- **Traefik**: Reverse proxy with automatic SSL
- **MySQL**: Database server
- **Redis**: Cache and session storage

### Development Tools
- **Mailpit**: Email testing and debugging
- **RabbitMQ**: Message queue with management UI
- **Meilisearch**: Full-text search engine
- **MinIO**: S3-compatible object storage
- **Soketi**: WebSocket server for real-time features

## 🛠️ Management Commands

### Using the Management Scripts

**Linux/macOS (`sail-traefik.sh`):**
```bash
./sail-traefik.sh start          # Start all services
./sail-traefik.sh stop           # Stop all services
./sail-traefik.sh restart        # Restart all services
./sail-traefik.sh logs            # View logs
./sail-traefik.sh status          # Check service status
./sail-traefik.sh artisan migrate # Run artisan commands
./sail-traefik.sh npm run dev     # Run npm commands
```

**Windows (`sail-traefik.bat`):**
```cmd
sail-traefik.bat start          # Start all services
sail-traefik.bat stop           # Stop all services
sail-traefik.bat restart        # Restart all services
sail-traefik.bat logs            # View logs
sail-traefik.bat status          # Check service status
sail-traefik.bat artisan migrate # Run artisan commands
sail-traefik.bat npm run dev     # Run npm commands
```

### Direct Sail Commands

```bash
# Start services
./vendor/bin/sail up -d

# Stop services
./vendor/bin/sail down

# View logs
./vendor/bin/sail logs -f

# Run artisan commands
./vendor/bin/sail artisan migrate
./vendor/bin/sail artisan tinker

# Run npm commands
./vendor/bin/sail npm install
./vendor/bin/sail npm run dev
./vendor/bin/sail npm run build

# Access shell
./vendor/bin/sail shell
```

## 🔧 Configuration

### Traefik Configuration

Traefik is configured with the following features:

- **Automatic SSL**: Let's Encrypt certificates for HTTPS
- **Dashboard**: Web UI for monitoring routes and services
- **Docker Integration**: Automatic service discovery
- **Load Balancing**: Built-in load balancing capabilities

### Service Labels

Each service includes Traefik labels for automatic routing:

```yaml
labels:
  - traefik.enable=true
  - traefik.http.routers.app.rule=Host(`dolmebel.com`)
  - traefik.http.routers.app.entrypoints=websecure
  - traefik.http.routers.app.tls.certresolver=letsencrypt
```

### Environment Variables

Key environment variables for Traefik:

```env
DOMAIN=dolmebel.com                # Your domain
ACME_EMAIL=admin@dolmebel.com      # Email for Let's Encrypt
```

## 🐛 Troubleshooting

### Common Issues

1. **Services won't start**
   ```bash
   # Check Docker is running
   docker --version
   
   # Check for port conflicts
   netstat -tulpn | grep :80
   ```

2. **SSL certificate issues**
   ```bash
   # Check Traefik logs
   ./vendor/bin/sail logs traefik
   
   # Verify domain resolution
   nslookup dolmebel.com
   ```

3. **Database connection issues**
   ```bash
   # Check MySQL logs
   ./vendor/bin/sail logs mysql
   
   # Test database connection
   ./vendor/bin/sail artisan tinker
   # Then run: DB::connection()->getPdo();
   ```

### Reset Everything

```bash
# Stop and remove all containers
./vendor/bin/sail down

# Remove all volumes (WARNING: This will delete all data)
docker volume prune

# Start fresh
./sail-traefik.sh start
```

## 🔒 Security Notes

- SSL certificates are automatically generated for local development
- All services are accessible via HTTPS
- Traefik dashboard is protected by host-based routing
- Database passwords should be changed in production

## 📚 Additional Resources

- [Laravel Sail Documentation](https://laravel.com/docs/sail)
- [Traefik Documentation](https://doc.traefik.io/traefik/)
- [Docker Compose Documentation](https://docs.docker.com/compose/)

## 🤝 Contributing

When adding new services:

1. Add the service to `docker-compose.yml`
2. Add Traefik labels for routing
3. Update environment variables in `env.example`
4. Update this documentation
5. Test the new service integration

## 📝 License

This project is open-sourced software licensed under the [MIT license](https://opensource.org/licenses/MIT).
