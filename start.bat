@echo off
REM Personal Finance Tracker - Desktop Launcher
REM This script starts the PHP server and opens the application in your default browser

setlocal enabledelayedexpansion

REM Get the directory where this script is located
set "SCRIPT_DIR=%~dp0"
cd /d "%SCRIPT_DIR%"

echo.
echo ========================================
echo Personal Finance Tracker
echo ========================================
echo.

REM Check if PHP is installed
where php.exe >nul 2>nul
if errorlevel 1 (
    echo ERROR: PHP is not installed or not in your PATH
    echo Please install PHP 8.3+ from https://windows.php.net/
    echo.
    pause
    exit /b 1
)

REM Check if composer.lock exists (to verify dependencies are installed)
if not exist composer.lock (
    echo ERROR: Composer dependencies not installed
    echo Please run: composer install
    echo.
    pause
    exit /b 1
)

REM Check if database exists, if not initialize it
if not exist database\database.sqlite (
    echo Initializing database...
    php artisan migrate:fresh --seed --force
    echo Database initialized!
    echo.
)

REM Start PHP server
echo Starting PHP server...
echo Server will run on: http://localhost:8000
echo.
echo Press Ctrl+C to stop the server
echo.

REM Open browser automatically
timeout /t 2 /nobreak >nul
start http://localhost:8000/login

REM Run Laravel development server
php artisan serve --host=127.0.0.1 --port=8000
