#!/bin/bash

# Laravel Sail with Traefik Management Script
# This script provides easy commands for managing your Laravel Sail environment with Traefik

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

# Function to check if .env exists
check_env() {
    if [ ! -f .env ]; then
        print_warning ".env file not found. Creating from env.example..."
        cp env.example .env
        print_status "Please update .env with your configuration before continuing."
        exit 1
    fi
}

# Function to setup hosts file
setup_hosts() {
    print_status "Setting up hosts file entries..."
    
    DOMAIN=$(grep "^DOMAIN=" .env | cut -d '=' -f2)
    
    if [ -z "$DOMAIN" ]; then
        DOMAIN="dolmebel.com"
    fi
    
    # Check if entries already exist
    if grep -q "$DOMAIN" /etc/hosts 2>/dev/null; then
        print_warning "Host entries already exist for $DOMAIN"
    else
        print_status "Adding host entries for $DOMAIN..."
        echo "127.0.0.1 $DOMAIN" | sudo tee -a /etc/hosts
        echo "127.0.0.1 traefik.$DOMAIN" | sudo tee -a /etc/hosts
        echo "127.0.0.1 mailpit.$DOMAIN" | sudo tee -a /etc/hosts
        echo "127.0.0.1 rabbitmq.$DOMAIN" | sudo tee -a /etc/hosts
        print_success "Host entries added successfully"
    fi
}

# Function to start services
start() {
    print_status "Starting Laravel Sail with Traefik..."
    check_env
    
    # Start all services
    ./vendor/bin/sail up -d
    
    print_status "Waiting for services to be ready..."
    sleep 10
    
    # Run migrations
    print_status "Running database migrations..."
    ./vendor/bin/sail artisan migrate
    
    # Install npm dependencies and build assets
    print_status "Installing npm dependencies and building assets..."
    ./vendor/bin/sail npm install
    ./vendor/bin/sail npm run build
    
    print_success "Laravel Sail with Traefik is now running!"
    print_status "Access your application at: https://$(grep "^DOMAIN=" .env | cut -d '=' -f2)"
    print_status "Traefik dashboard: https://traefik.$(grep "^DOMAIN=" .env | cut -d '=' -f2)"
    print_status "Mailpit: https://mailpit.$(grep "^DOMAIN=" .env | cut -d '=' -f2)"
    print_status "RabbitMQ: https://rabbitmq.$(grep "^DOMAIN=" .env | cut -d '=' -f2)"
}

# Function to stop services
stop() {
    print_status "Stopping Laravel Sail services..."
    ./vendor/bin/sail down
    print_success "Services stopped successfully"
}

# Function to restart services
restart() {
    print_status "Restarting Laravel Sail services..."
    stop
    start
}

# Function to show logs
logs() {
    print_status "Showing logs for all services..."
    ./vendor/bin/sail logs -f
}

# Function to show status
status() {
    print_status "Checking service status..."
    ./vendor/bin/sail ps
}

# Function to run artisan commands
artisan() {
    if [ $# -eq 0 ]; then
        print_error "Please provide an artisan command"
        exit 1
    fi
    
    print_status "Running artisan command: $*"
    ./vendor/bin/sail artisan "$@"
}

# Function to run npm commands
npm() {
    if [ $# -eq 0 ]; then
        print_error "Please provide an npm command"
        exit 1
    fi
    
    print_status "Running npm command: $*"
    ./vendor/bin/sail npm "$@"
}

# Function to show help
show_help() {
    echo "Laravel Sail with Traefik Management Script"
    echo ""
    echo "Usage: $0 [COMMAND] [OPTIONS]"
    echo ""
    echo "Commands:"
    echo "  start       Start all services with Traefik"
    echo "  stop        Stop all services"
    echo "  restart     Restart all services"
    echo "  logs        Show logs for all services"
    echo "  status      Show status of all services"
    echo "  artisan     Run Laravel artisan commands"
    echo "  npm         Run npm commands"
    echo "  setup-hosts Setup hosts file entries"
    echo "  help        Show this help message"
    echo ""
    echo "Examples:"
    echo "  $0 start"
    echo "  $0 artisan migrate"
    echo "  $0 npm run dev"
    echo "  $0 logs"
}

# Main script logic
case "${1:-help}" in
    start)
        start
        ;;
    stop)
        stop
        ;;
    restart)
        restart
        ;;
    logs)
        logs
        ;;
    status)
        status
        ;;
    artisan)
        shift
        artisan "$@"
        ;;
    npm)
        shift
        npm "$@"
        ;;
    setup-hosts)
        setup_hosts
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
