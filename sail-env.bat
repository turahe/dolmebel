@echo off
setlocal enabledelayedexpansion

REM Laravel Sail Environment Management Script for Windows
REM This script provides easy commands for managing different environments (local/production)

:main
if "%1"=="" goto help
if "%1"=="help" goto help
if "%1"=="--help" goto help
if "%1"=="-h" goto help
if "%1"=="start-local" goto start-local
if "%1"=="start-prod" goto start-prod
if "%1"=="stop" goto stop
if "%1"=="restart" goto restart
if "%1"=="logs" goto logs
if "%1"=="status" goto status
if "%1"=="artisan" goto artisan
if "%1"=="npm" goto npm
if "%1"=="setup" goto setup
goto unknown

:start-local
echo [INFO] Starting Laravel Sail for LOCAL development...
call :setup_env local
call :setup_hosts_local
call :start_services local
call :run_migrations local
call :build_assets local
echo [SUCCESS] Local development environment is now running!
call :show_urls_local
goto end

:start-prod
echo [INFO] Starting Laravel Sail for PRODUCTION...
call :setup_env prod
call :start_services prod
call :run_migrations prod
call :build_assets prod
call :optimize_production
echo [SUCCESS] Production environment is now running!
call :show_urls_prod
goto end

:stop
if "%2"=="" (
    echo [INFO] Stopping all Laravel Sail services...
    php vendor\bin\sail down
) else (
    echo [INFO] Stopping %2 environment...
    php vendor\bin\sail -f docker-compose.%2.yml down
)
echo [SUCCESS] Services stopped successfully
goto end

:restart
if "%2"=="" (
    echo [ERROR] Please specify environment (local or prod)
    goto end
)
echo [INFO] Restarting %2 environment...
call :stop %2
if "%2"=="local" (
    call :start-local
) else if "%2"=="prod" (
    call :start-prod
)
goto end

:logs
if "%2"=="" (
    echo [INFO] Showing logs for all services...
    php vendor\bin\sail logs -f
) else (
    echo [INFO] Showing logs for %2 environment...
    php vendor\bin\sail -f docker-compose.%2.yml logs -f
)
goto end

:status
if "%2"=="" (
    echo [INFO] Checking status of all services...
    php vendor\bin\sail ps
) else (
    echo [INFO] Checking status of %2 environment...
    php vendor\bin\sail -f docker-compose.%2.yml ps
)
goto end

:artisan
if "%2"=="" (
    echo [ERROR] Please specify environment (local or prod)
    goto end
)
if "%3"=="" (
    echo [ERROR] Please provide an artisan command
    goto end
)
echo [INFO] Running artisan command in %2 environment: %*
php vendor\bin\sail -f docker-compose.%2.yml artisan %*
goto end

:npm
if "%2"=="" (
    echo [ERROR] Please specify environment (local or prod)
    goto end
)
if "%3"=="" (
    echo [ERROR] Please provide an npm command
    goto end
)
echo [INFO] Running npm command in %2 environment: %*
php vendor\bin\sail -f docker-compose.%2.yml npm %*
goto end

:setup
if "%2"=="" (
    echo [ERROR] Please specify environment (local or prod)
    goto end
)
call :setup_env %2
goto end

:setup_env
if not exist env.%1 (
    echo [ERROR] Environment file env.%1 not found!
    echo [INFO] Available environments: local, prod
    exit /b 1
)
echo [INFO] Setting up %1 environment...
copy env.%1 .env
echo [SUCCESS] Environment %1 configured successfully
exit /b 0

:setup_hosts_local
echo [INFO] Setting up hosts file entries for local development...
echo [WARNING] Please manually add the following entries to your hosts file (C:\Windows\System32\drivers\etc\hosts):
echo 127.0.0.1 dolmebel.local
echo 127.0.0.1 traefik.dolmebel.local
echo 127.0.0.1 mailpit.dolmebel.local
echo 127.0.0.1 rabbitmq.dolmebel.local
echo [INFO] Run as Administrator to modify hosts file automatically
exit /b 0

:start_services
echo [INFO] Starting services for %1 environment...
php vendor\bin\sail -f docker-compose.%1.yml up -d
echo [INFO] Waiting for services to be ready...
timeout /t 10 /nobreak >nul
exit /b 0

:run_migrations
echo [INFO] Running database migrations...
if "%1"=="prod" (
    php vendor\bin\sail -f docker-compose.%1.yml artisan migrate --force
) else (
    php vendor\bin\sail -f docker-compose.%1.yml artisan migrate
)
exit /b 0

:build_assets
echo [INFO] Installing npm dependencies and building assets...
if "%1"=="prod" (
    php vendor\bin\sail -f docker-compose.%1.yml npm ci --only=production
) else (
    php vendor\bin\sail -f docker-compose.%1.yml npm install
)
php vendor\bin\sail -f docker-compose.%1.yml npm run build
exit /b 0

:optimize_production
echo [INFO] Optimizing Laravel for production...
php vendor\bin\sail -f docker-compose.prod.yml artisan config:cache
php vendor\bin\sail -f docker-compose.prod.yml artisan route:cache
php vendor\bin\sail -f docker-compose.prod.yml artisan view:cache
exit /b 0

:show_urls_local
echo [INFO] Access your application at: http://dolmebel.local
echo [INFO] Traefik dashboard: http://traefik.dolmebel.local
echo [INFO] Mailpit: http://mailpit.dolmebel.local
echo [INFO] RabbitMQ: http://rabbitmq.dolmebel.local
exit /b 0

:show_urls_prod
echo [INFO] Access your application at: https://dolmebel.com
echo [INFO] Traefik dashboard: https://traefik.dolmebel.com
echo [INFO] Mailpit: https://mailpit.dolmebel.com
echo [INFO] RabbitMQ: https://rabbitmq.dolmebel.com
exit /b 0

:help
echo Laravel Sail Environment Management Script for Windows
echo.
echo Usage: %0 [COMMAND] [ENVIRONMENT] [OPTIONS]
echo.
echo Commands:
echo   start-local    Start local development environment
echo   start-prod     Start production environment
echo   stop [env]     Stop services (local or prod)
echo   restart [env]  Restart services (local or prod)
echo   logs [env]     Show logs (local or prod)
echo   status [env]   Show status (local or prod)
echo   artisan [env]  Run Laravel artisan commands
echo   npm [env]      Run npm commands
echo   setup [env]    Setup environment configuration
echo   help           Show this help message
echo.
echo Environments:
echo   local          Local development (dolmebel.local)
echo   prod           Production (dolmebel.com)
echo.
echo Examples:
echo   %0 start-local
echo   %0 start-prod
echo   %0 artisan local migrate
echo   %0 npm local run dev
echo   %0 logs prod
echo   %0 stop local
goto end

:unknown
echo [ERROR] Unknown command: %1
call :help
goto end

:end
endlocal