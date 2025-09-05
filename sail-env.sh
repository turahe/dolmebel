#!/bin/bash

# Laravel Sail Environment Management Script
# This script provides easy commands for managing different environments (local/production)

set -e

# Colors for output
RED='\033[0;31m'
GREEN='\033[0;32m'
YELLOW='\033[1;33m'
BLUE='\033[0;34m'
NC='\033[0m' # No Color

# Function to print colored output
print_status() {
    echo -e "${BLUE}[INFO]${NC} $1"
}

print_success() {
    echo -e "${GREEN}[SUCCESS]${NC} $1"
}

print_warning() {
    echo -e "${YELLOW}[WARNING]${NC} $1"
}

print_error() {
    echo -e "${RED}[ERROR]${NC} $1"
}

# Function to check if environment file exists
check_env_file() {
    local env_file="env.$1"
    if [ ! -f "$env_file" ]; then
        print_error "Environment file $env_file not found!"
        print_status "Available environments: local, prod"
        exit 1
    fi
}

# Function to setup environment
setup_env() {
    local env=$1
    check_env_file "$env"
    
    print_status "Setting up $env environment..."
    cp "env.$env" .env
    print_success "Environment $env configured successfully"
}

# Function to setup hosts file for local environment
setup_hosts_local() {
    print_status "Setting up hosts file entries for local development..."
    
    # Check if entries already exist
    if grep -q "dolmebel.local" /etc/hosts 2>/dev/null; then
        print_warning "Host entries already exist for dolmebel.local"
    else
        print_status "Adding host entries for dolmebel.local..."
        echo "127.0.0.1 dolmebel.local" | sudo tee -a /etc/hosts
        echo "127.0.0.1 traefik.dolmebel.local" | sudo tee -a /etc/hosts
        echo "127.0.0.1 mailpit.dolmebel.local" | sudo tee -a /etc/hosts
        echo "127.0.0.1 rabbitmq.dolmebel.local" | sudo tee -a /etc/hosts
        print_success "Host entries added successfully"
    fi
}

# Function to start local environment
start_local() {
    print_status "Starting Laravel Sail for LOCAL development..."
    setup_env "local"
    setup_hosts_local
    
    # Start services
    php vendor/bin/sail -f docker-compose.local.yml up -d
    
    print_status "Waiting for services to be ready..."
    sleep 10
    
    # Run migrations
    print_status "Running database migrations..."
    php vendor/bin/sail -f docker-compose.local.yml artisan migrate
    
    # Install npm dependencies and build assets
    print_status "Installing npm dependencies and building assets..."
    php vendor/bin/sail -f docker-compose.local.yml npm install
    php vendor/bin/sail -f docker-compose.local.yml npm run build
    
    print_success "Local development environment is now running!"
    print_status "Access your application at: http://dolmebel.local"
    print_status "Traefik dashboard: http://traefik.dolmebel.local"
    print_status "Mailpit: http://mailpit.dolmebel.local"
    print_status "RabbitMQ: http://rabbitmq.dolmebel.local"
}

# Function to start production environment
start_prod() {
    print_status "Starting Laravel Sail for PRODUCTION..."
    setup_env "prod"
    
    # Start services
    php vendor/bin/sail -f docker-compose.prod.yml up -d
    
    print_status "Waiting for services to be ready..."
    sleep 15
    
    # Run migrations
    print_status "Running database migrations..."
    php vendor/bin/sail -f docker-compose.prod.yml artisan migrate --force
    
    # Install npm dependencies and build assets
    print_status "Installing npm dependencies and building production assets..."
    php vendor/bin/sail -f docker-compose.prod.yml npm ci --only=production
    php vendor/bin/sail -f docker-compose.prod.yml npm run build
    
    # Optimize Laravel for production
    print_status "Optimizing Laravel for production..."
    php vendor/bin/sail -f docker-compose.prod.yml artisan config:cache
    php vendor/bin/sail -f docker-compose.prod.yml artisan route:cache
    php vendor/bin/sail -f docker-compose.prod.yml artisan view:cache
    
    print_success "Production environment is now running!"
    print_status "Access your application at: https://dolmebel.com"
    print_status "Traefik dashboard: https://traefik.dolmebel.com"
    print_status "Mailpit: https://mailpit.dolmebel.com"
    print_status "RabbitMQ: https://rabbitmq.dolmebel.com"
}

# Function to stop services
stop() {
    local env=$1
    if [ -z "$env" ]; then
        print_status "Stopping all Laravel Sail services..."
        php vendor/bin/sail down
    else
        print_status "Stopping $env environment..."
        php vendor/bin/sail -f "docker-compose.$env.yml" down
    fi
    print_success "Services stopped successfully"
}

# Function to restart services
restart() {
    local env=$1
    if [ -z "$env" ]; then
        print_error "Please specify environment (local or prod)"
        exit 1
    fi
    
    print_status "Restarting $env environment..."
    stop "$env"
    
    if [ "$env" = "local" ]; then
        start_local
    elif [ "$env" = "prod" ]; then
        start_prod
    fi
}

# Function to show logs
logs() {
    local env=$1
    if [ -z "$env" ]; then
        print_status "Showing logs for all services..."
        php vendor/bin/sail logs -f
    else
        print_status "Showing logs for $env environment..."
        php vendor/bin/sail -f "docker-compose.$env.yml" logs -f
    fi
}

# Function to show status
status() {
    local env=$1
    if [ -z "$env" ]; then
        print_status "Checking status of all services..."
        php vendor/bin/sail ps
    else
        print_status "Checking status of $env environment..."
        php vendor/bin/sail -f "docker-compose.$env.yml" ps
    fi
}

# Function to run artisan commands
artisan() {
    local env=$1
    shift
    
    if [ -z "$env" ]; then
        print_error "Please specify environment (local or prod)"
        exit 1
    fi
    
    if [ $# -eq 0 ]; then
        print_error "Please provide an artisan command"
        exit 1
    fi
    
    print_status "Running artisan command in $env environment: $*"
    php vendor/bin/sail -f "docker-compose.$env.yml" artisan "$@"
}

# Function to run npm commands
npm() {
    local env=$1
    shift
    
    if [ -z "$env" ]; then
        print_error "Please specify environment (local or prod)"
        exit 1
    fi
    
    if [ $# -eq 0 ]; then
        print_error "Please provide an npm command"
        exit 1
    fi
    
    print_status "Running npm command in $env environment: $*"
    php vendor/bin/sail -f "docker-compose.$env.yml" npm "$@"
}

# Function to show help
show_help() {
    echo "Laravel Sail Environment Management Script"
    echo ""
    echo "Usage: $0 [COMMAND] [ENVIRONMENT] [OPTIONS]"
    echo ""
    echo "Commands:"
    echo "  start-local    Start local development environment"
    echo "  start-prod     Start production environment"
    echo "  stop [env]     Stop services (local or prod)"
    echo "  restart [env]  Restart services (local or prod)"
    echo "  logs [env]     Show logs (local or prod)"
    echo "  status [env]   Show status (local or prod)"
    echo "  artisan [env]  Run Laravel artisan commands"
    echo "  npm [env]      Run npm commands"
    echo "  setup [env]    Setup environment configuration"
    echo "  help           Show this help message"
    echo ""
    echo "Environments:"
    echo "  local          Local development (dolmebel.local)"
    echo "  prod           Production (dolmebel.com)"
    echo ""
    echo "Examples:"
    echo "  $0 start-local"
    echo "  $0 start-prod"
    echo "  $0 artisan local migrate"
    echo "  $0 npm local run dev"
    echo "  $0 logs prod"
    echo "  $0 stop local"
}

# Main script logic
case "${1:-help}" in
    start-local)
        start_local
        ;;
    start-prod)
        start_prod
        ;;
    stop)
        stop "$2"
        ;;
    restart)
        restart "$2"
        ;;
    logs)
        logs "$2"
        ;;
    status)
        status "$2"
        ;;
    artisan)
        shift
        artisan "$@"
        ;;
    npm)
        shift
        npm "$@"
        ;;
    setup)
        if [ -z "$2" ]; then
            print_error "Please specify environment (local or prod)"
            exit 1
        fi
        setup_env "$2"
        ;;
    help|--help|-h)
        show_help
        ;;
    *)
        print_error "Unknown command: $1"
        show_help
        exit 1
        ;;
esac
