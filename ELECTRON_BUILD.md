# Personal Finance Tracker - Electron Desktop App

This project includes an Electron wrapper to create a standalone `.exe` desktop application.

## Prerequisites

Before building the `.exe`, ensure you have:

1. **Node.js & npm** - Download from [nodejs.org](https://nodejs.org/)
2. **PHP 8.3** - With `php.exe` in your PATH
3. **Composer** - For managing PHP dependencies
4. All Laravel dependencies installed via `composer install`

## Project Structure

```
electron/
├── main.js           # Electron main process entry point
├── preload.js        # Security preload script
└── assets/
    ├── icon.png      # App icon (optional, 512x512 recommended)
    └── README.md     # Icon instructions
package.json          # npm configuration with electron build scripts
electron-builder.json # Electron builder configuration
```

## Development Mode

To run the app in development with hot-reload:

```bash
npm run electron-dev
```

This will:
1. Start the PHP Laravel server automatically
2. Open the Electron window loading `http://127.0.0.1:8000`
3. Enable developer tools for debugging

## Building the .exe Installer

### Step 1: Build Vite Assets
```bash
npm run build
```

### Step 2: Build Electron App
```bash
npm run electron-build
```

This creates:
- **NSIS Installer**: `dist/Personal Finance Tracker Setup 1.1.0.exe` (~300-400MB)
- **Portable EXE**: `dist/Personal-Finance-Tracker-1.1.0-portable.exe` (~270MB)

### All-in-One Command
```bash
npm run electron-build
```

## Output Files

After building, you'll find in the `dist/` directory:

1. **Setup Installer** (.exe)
   - Users double-click to install
   - Creates Start Menu shortcuts
   - Can specify installation directory
   - ~300-400MB size

2. **Portable Executable** (.exe)
   - Single file, no installation needed
   - Can run from USB drive
   - ~270MB size

## What Gets Bundled

The final `.exe` includes:
- ✅ Laravel application (app, routes, views, config)
- ✅ Database schema (SQLite)
- ✅ All PHP dependencies (vendor folder)
- ✅ Node modules (electron, etc.)
- ✅ Static assets (built from Vite)
- ✅ .env configuration file

**Requirements for end users**: 
- Windows 7 or later (64-bit)
- ~500MB free disk space
- NO separate PHP installation needed (will happen on app start)

## How It Works

When user runs the `.exe`:

1. Electron application starts
2. PHP server automatically launches on `127.0.0.1:8000`
3. Laravel app initializes with SQLite database
4. Electron window opens and loads the app
5. When user closes the app, PHP server stops automatically

## Customization

### Change App Icon
1. Create a `512x512` PNG image
2. Name it `icon.png`
3. Place in `electron/assets/`
4. Rebuild: `npm run electron-build`

### Change App Name
Edit `electron-builder.json`:
```json
{
  "productName": "Your App Name",
  "appId": "com.yourcompany.yourapp"
}
```

### Change Starting URL
Edit `electron/main.js`:
```javascript
mainWindow.loadURL('http://127.0.0.1:8000/login');
// Change to your desired route
```

## Troubleshooting

### PHP server doesn't start
- Ensure `php.exe` is in your system PATH
- Check that `artisan` file exists in project root
- Verify Laravel dependencies are installed: `composer install`

### Window doesn't load
- Ensure Laravel server is running
- Check that port `8000` is not in use
- Look for errors in console: `npm run electron-dev` (with dev tools open)

### Build fails
- Clear npm cache: `npm cache clean --force`
- Delete `node_modules` and `package-lock.json`, then `npm install`
- Ensure you're using Node.js 14+ and npm 6+

## File Size Notes

- NSIS Installer: ~300-400MB (includes uninstaller, registry entries)
- Portable: ~270MB (single file)
- Installed: ~500MB on disk

This is due to bundling:
- Electron browser engine (~150MB)
- PHP + Laravel framework (~100MB)
- Dependencies and assets (~50-100MB)

## Distribution

You can now distribute:
- Send users the `.exe` file directly
- Host on your website
- Submit to software portals
- Share via cloud storage

Users simply download and run - no installation process needed if using portable version.

## Environment Variables

The app uses `.env` file in the root directory. Important variables:

```env
APP_NAME="Personal Finance Tracker"
APP_ENV=production
APP_DEBUG=false
APP_URL=http://127.0.0.1:8000

DB_CONNECTION=sqlite
DB_DATABASE=database/database.sqlite

SESSION_DRIVER=database
```

These are bundled in the `.exe` and will be used when app runs.

## Additional Resources

- [Electron Documentation](https://www.electronjs.org/docs)
- [electron-builder Config](https://www.electron.build/configuration/configuration)
- [Laravel Documentation](https://laravel.com/docs)

---

**Version**: 1.1.0  
**Last Updated**: April 2, 2026
