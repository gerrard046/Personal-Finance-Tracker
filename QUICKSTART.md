# 🚀 How to Run Personal Finance Tracker

Personal Finance Tracker is a Laravel desktop application that works on Windows, Mac, and Linux. Choose the method that works best for you.

## Method 1: Simple Launcher (Recommended for End Users) ✨

### For Windows Users

**Option A: Double-click the batch file**
```
start.bat
```
This will:
✅ Check if PHP is installed
✅ Initialize the database if needed
✅ Start the PHP server
✅ Open browser automatically to http://localhost:8000

**Option B: Use PowerShell (if .bat doesn't work)**
```powershell
powershell -ExecutionPolicy Bypass -File .\start.ps1
```

### What You Need
1. **PHP 8.3+** - Download from [windows.php.net](https://windows.php.net/)
   - Extract to a folder
   - Add to Windows PATH (`C:\php` for example)
   - Verify: Run `php --version` in cmd

2. **Composer** - Download from [getcomposer.org](https://getcomposer.org/)
   - Provides Laravel dependencies

3. That's it! Everything else is included.

### File Structure After Setup
```
Personal-Finance-Tracker/
├── start.bat              <- Double-click this!
├── start.ps1              <- Or run this
├── app/                   (Laravel application)
├── database/
│   └── database.sqlite    (Auto-created on first run)
├── composer.json          (Dependencies list)
└── ... (other Laravel files)
```

---

## Method 2: Manual Start (For Developers)

If you prefer to run commands manually:

### Step 1: Install Dependencies
```bash
composer install
```

### Step 2: Setup Database (First Run Only)
```bash
php artisan migrate:fresh --seed
```

This creates a demo user:
- Email: `demo@example.com`
- Password: `password123`

### Step 3: Start the Server
```bash
php artisan serve
```

### Step 4: Open in Browser
Visit: `http://localhost:8000`

---

## Method 3: Electron Desktop App (Windows)

We've included Electron wrapper files for a native desktop app experience. To build:

### Prerequisites
- Node.js 20+ (from [nodejs.org](https://nodejs.org/))
- npm (comes with Node.js)
- PHP 8.3+

### Build Steps
```bash
# Install Node dependencies
npm install

# Build the Electron app
npx electron-builder --win --publish never
```

Output files in `dist/`:
- **PersonalFinanceTracker-Setup.exe** - Installer
- **PersonalFinanceTracker-portable.exe** - Standalone executable

See [ELECTRON_BUILD.md](ELECTRON_BUILD.md) for detailed instructions.

---

## Method 4: Docker (Windows/Mac/Linux)

If you have Docker installed:

```bash
docker-compose up -d
```

Then visit: `http://localhost:8000`

For Docker setup, see [README_DOCKER.md](README_DOCKER.md)

---

## Troubleshooting

### "PHP not found" Error
✗ PHP is not installed or not accessible
```bash
# Fix: Add PHP to PATH
# 1. Download PHP from https://windows.php.net/
# 2. Extract to folder (e.g., C:\php)
# 3. Add C:\php to Windows PATH environment variable
# 4. Restart terminal/cmd
# 5. Verify: php --version
```

### "Composer not found" Error
✗ Composer is not installed
```bash
# Fix: Install Composer from https://getcomposer.org/
# Then run: composer install
```

### Port 8000 Already in Use
✗ Another application is using port 8000
```bash
# Option 1: Stop the other application
# Option 2: Use different port
php artisan serve --port=8001
# Then visit: http://localhost:8001
```

### Database Lock Error
✗ Database is locked (another instance running)
```bash
# Delete the lock file:
delete database/database.sqlite-wal
# Or simply restart the server
```

### Can't Open Browser Automatically
✓ This is fine! Manually open:
```
http://localhost:8000/login
```

---

## Features Guide

### 📊 Dashboard
- Real-time balance calculation
- Daily safe spending limit
- Status indicator (Green/Yellow/Red)
- Recent transactions

### 💰 Income & Expense Tracking
- Add income/expenses with categories
- Automatic balance calculations
- Transaction history with notes

### 🎯 Savings Goals
- Create savings targets (e.g., "Buy Shoes - 2M by June")
- View progress percentage
- Calculate required daily/monthly savings
- Auto-complete when target reached

### 📡 REST API
All features available via API:
- Authentication (login/register)
- Goals CRUD + savings endpoint
- Transactions CRUD + stats
- See [API_DOCUMENTATION.md](API_DOCUMENTATION.md)

---

## System Requirements

| Component | Minimum | Recommended |
|-----------|---------|-------------|
| OS | Windows 7+ | Windows 10+ |
| RAM | 512 MB | 2 GB |
| Disk | 100 MB | 500 MB |
| PHP | 8.0 | 8.3+ |
| Browser | Any modern | Latest Chrome/Edge |

---

## Environment Variables

The app uses a `.env` file for configuration. Important settings:

```env
APP_NAME=Personal Finance Tracker
APP_ENV=production
APP_DEBUG=false
APP_URL=http://localhost:8000

DB_CONNECTION=sqlite
DB_DATABASE=database/database.sqlite

SESSION_DRIVER=database
```

You can modify these if needed.

---

## Demo Credentials

Default demo user (auto-seeded on first run):
| Field | Value |
|-------|-------|
| Email | demo@example.com |
| Password | password123 |
| Status | Active |

You can add more users via the Register option.

---

## Getting Started Checklist

- [ ] Install PHP 8.3+
- [ ] Install Composer  
- [ ] Run `composer install`
- [ ] Run `start.bat` (Windows) or manual steps above
- [ ] Open http://localhost:8000/login
- [ ] Login with demo@example.com / password123
- [ ] Explore the dashboard
- [ ] Create your first income/expense/goal

---

## Need Help?

### Common Issues

**Q: App won't start**
A: Check that PHP is installed and in PATH. Run `php --version` in terminal.

**Q: Server keeps crashing**
A: Check that port 8000 is free. Try `php artisan serve --port=8001`

**Q: Can't login**
A: Database might not be initialized. Run:
```bash
php artisan migrate:fresh --seed
```

**Q: Reset database**
A: Delete `database/database.sqlite` and restart the server.

### Getting Help

- Check [API_DOCUMENTATION.md](API_DOCUMENTATION.md)
- Check [ELECTRON_BUILD.md](ELECTRON_BUILD.md)
- Check [RELEASE_NOTES.md](RELEASE_NOTES.md)

---

## Distribution to Others

### For End Users (No Setup):
1. Download `PersonalFinanceTracker-portable.exe` from releases
2. Double-click to run
3. No installation needed!

### For Developers:
1. Share the GitHub repository
2. They follow the "Manual Start" section above

### For Business:
1. Build Electron installer: `npm run electron-build`
2. Upload `dist/` files to your website
3. Users download and install like any normal Windows app

---

## Version Info

- **Current Version**: 1.1.0
- **Release Date**: April 2, 2026
- **Status**: Production Ready ✅

See [RELEASE_NOTES.md](RELEASE_NOTES.md) for full changelog.

---

**Developed with ❤️ using Laravel, Tailwind CSS, and Electron**
