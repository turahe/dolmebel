@echo off
setlocal enabledelayedexpansion

REM Laravel Sail with Traefik Management Script for Windows
REM This script provides easy commands for managing your Laravel Sail environment with Traefik

:main
if "%1"=="" goto help
if "%1"=="help" goto help
if "%1"=="--help" goto help
if "%1"=="-h" goto help
if "%1"=="start" goto start
if "%1"=="stop" goto stop
if "%1"=="restart" goto restart
if "%1"=="logs" goto logs
if "%1"=="status" goto status
if "%1"=="artisan" goto artisan
if "%1"=="npm" goto npm
if "%1"=="setup-hosts" goto setup-hosts
goto unknown

:start
echo [INFO] Starting Laravel Sail with Traefik...
call :check_env
call :start_services
call :run_migrations
call :build_assets
echo [SUCCESS] Laravel Sail with Traefik is now running!
call :show_urls
goto end

:stop
echo [INFO] Stopping Laravel Sail services...
vendor\bin\sail down
echo [SUCCESS] Services stopped successfully
goto end

:restart
echo [INFO] Restarting Laravel Sail services...
call :stop
call :start
goto end

:logs
echo [INFO] Showing logs for all services...
vendor\bin\sail logs -f
goto end

:status
echo [INFO] Checking service status...
vendor\bin\sail ps
goto end

:artisan
if "%2"=="" (
    echo [ERROR] Please provide an artisan command
    goto end
)
echo [INFO] Running artisan command: %*
vendor\bin\sail artisan %*
goto end

:npm
if "%2"=="" (
    echo [ERROR] Please provide an npm command
    goto end
)
echo [INFO] Running npm command: %*
vendor\bin\sail npm %*
goto end

:setup-hosts
echo [INFO] Setting up hosts file entries...
echo [WARNING] Please manually add the following entries to your hosts file (C:\Windows\System32\drivers\etc\hosts):
echo 127.0.0.1 dolmebel.com
echo 127.0.0.1 traefik.dolmebel.com
echo 127.0.0.1 mailpit.dolmebel.com
echo 127.0.0.1 rabbitmq.dolmebel.com
echo [INFO] Run as Administrator to modify hosts file automatically
goto end

:check_env
if not exist .env (
    echo [WARNING] .env file not found. Creating from env.example...
    copy env.example .env
    echo [INFO] Please update .env with your configuration before continuing.
    exit /b 1
)
exit /b 0

:start_services
vendor\bin\sail up -d
echo [INFO] Waiting for services to be ready...
timeout /t 10 /nobreak >nul
exit /b 0

:run_migrations
echo [INFO] Running database migrations...
vendor\bin\sail artisan migrate
exit /b 0

:build_assets
echo [INFO] Installing npm dependencies and building assets...
vendor\bin\sail npm install
vendor\bin\sail npm run build
exit /b 0

:show_urls
echo [INFO] Access your application at: https://dolmebel.com
echo [INFO] Traefik dashboard: https://traefik.dolmebel.com
echo [INFO] Mailpit: https://mailpit.dolmebel.com
echo [INFO] RabbitMQ: https://rabbitmq.dolmebel.com
exit /b 0

:help
echo Laravel Sail with Traefik Management Script for Windows
echo.
echo Usage: %0 [COMMAND] [OPTIONS]
echo.
echo Commands:
echo   start       Start all services with Traefik
echo   stop        Stop all services
echo   restart     Restart all services
echo   logs        Show logs for all services
echo   status      Show status of all services
echo   artisan     Run Laravel artisan commands
echo   npm         Run npm commands
echo   setup-hosts Setup hosts file entries
echo   help        Show this help message
echo.
echo Examples:
echo   %0 start
echo   %0 artisan migrate
echo   %0 npm run dev
echo   %0 logs
goto end

:unknown
echo [ERROR] Unknown command: %1
call :help
goto end

:end
endlocal
