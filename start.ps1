# Personal Finance Tracker - Desktop Launcher (PowerShell version)
# This script starts the PHP server and opens the application

Write-Host ""
Write-Host "========================================"
Write-Host "Personal Finance Tracker"
Write-Host "========================================"
Write-Host ""

# Set location to script directory
$ScriptDir = Split-Path -Parent -Path $MyInvocation.MyCommand.Definition
Set-Location $ScriptDir

# Check if PHP is installed
try {
    $phpVersion = php --version 2>$null
    if (-not $phpVersion) {
        throw "PHP not found"
    }
    Write-Host "✓ PHP found" -ForegroundColor Green
} catch {
    Write-Host "✗ ERROR: PHP is not installed or not in your PATH" -ForegroundColor Red
    Write-Host "Please install PHP 8.3+ from https://windows.php.net/" -ForegroundColor Yellow
    Read-Host "Press Enter to exit"
    exit 1
}

# Check if composer.lock exists
if (-not (Test-Path "composer.lock")) {
    Write-Host "✗ ERROR: Composer dependencies not installed" -ForegroundColor Red
    Write-Host "Please run: composer install" -ForegroundColor Yellow
    Read-Host "Press Enter to exit"
    exit 1
}

Write-Host "✓ Dependencies found" -ForegroundColor Green

# Check if database exists, if not initialize it
if (-not (Test-Path "database\database.sqlite")) {
    Write-Host ""
    Write-Host "Initializing database..." -ForegroundColor Cyan
    php artisan migrate:fresh --seed --force
    Write-Host "✓ Database initialized!" -ForegroundColor Green
    Write-Host ""
}

Write-Host "Starting PHP server..." -ForegroundColor Cyan
Write-Host "Server will run on: http://localhost:8000" -ForegroundColor Yellow
Write-Host ""
Write-Host "Application URL: http://localhost:8000/login" -ForegroundColor Yellow
Write-Host ""
Write-Host "Press Ctrl+C in this window to stop the server" -ForegroundColor Magenta
Write-Host ""

# Open browser automatically
Start-Sleep -Seconds 2
Start-Process "http://localhost:8000/login"

# Run Laravel development server
php artisan serve --host=127.0.0.1 --port=8000
