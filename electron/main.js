const { app, BrowserWindow, Menu } = require('electron');
const path = require('path');
const { spawn } = require('child_process');
const os = require('os');
const fs = require('fs');

let mainWindow;
let phpProcess;

const isDev = process.env.NODE_ENV === 'development';
const appPath = path.join(__dirname, '..');

/**
 * Stop PHP server
 */
function stopPhpServer() {
  if (phpProcess) {
    console.log('Stopping PHP server...');
    phpProcess.kill();
  }
}

/**
 * Start PHP development server
 */
function startPhpServer() {
  return new Promise((resolve, reject) => {
    const phpCommand = process.platform === 'win32' ? 'php.exe' : 'php';
    const phpPath = path.join(appPath, 'artisan');

    console.log(`Starting PHP server from: ${appPath}`);
    console.log(`Using PHP command: ${phpCommand}`);

    phpProcess = spawn(phpCommand, [
      'artisan',
      'serve',
      '--host=127.0.0.1',
      '--port=8000'
    ], {
      cwd: appPath,
      stdio: 'pipe',
      detached: false
    });

    phpProcess.stdout.on('data', (data) => {
      const output = data.toString();
      console.log(`[PHP] ${output}`);
      
      // Server is ready when we see "Server running"
      if (output.includes('Server running')) {
        resolve();
      }
    });

    phpProcess.stderr.on('data', (data) => {
      console.error(`[PHP ERROR] ${data.toString()}`);
    });

    phpProcess.on('error', (error) => {
      console.error('Failed to start PHP server:', error);
      reject(error);
    });

    // Give server 10 seconds to start
    setTimeout(() => resolve(), 10000);
  });
}

/**
 * Create main application window
 */
function createWindow() {
  mainWindow = new BrowserWindow({
    width: 1200,
    height: 900,
    minWidth: 800,
    minHeight: 600,
    webPreferences: {
      preload: path.join(__dirname, 'preload.js'),
      nodeIntegration: false,
      contextIsolation: true,
    },
    icon: path.join(__dirname, 'assets', 'icon.png'),
    show: false
  });

  // Load localhost:8000
  mainWindow.loadURL('http://127.0.0.1:8000/login');

  // Show window when ready
  mainWindow.once('ready-to-show', () => {
    mainWindow.show();
  });

  // Dev tools in development
  if (isDev) {
    mainWindow.webContents.openDevTools();
  }

  mainWindow.on('closed', () => {
    mainWindow = null;
  });
}

/**
 * Create application menu
 */
function createMenu() {
  const template = [
    {
      label: 'File',
      submenu: [
        {
          label: 'Exit',
          accelerator: 'CmdOrCtrl+Q',
          click: () => {
            app.quit();
          }
        }
      ]
    },
    {
      label: 'View',
      submenu: [
        {
          label: 'Reload',
          accelerator: 'CmdOrCtrl+R',
          click: () => {
            mainWindow.reload();
          }
        },
        {
          label: 'Toggle Developer Tools',
          accelerator: 'CmdOrCtrl+Shift+I',
          click: () => {
            mainWindow.webContents.toggleDevTools();
          }
        }
      ]
    },
    {
      label: 'Help',
      submenu: [
        {
          label: 'About',
          click: () => {
            const { dialog } = require('electron');
            dialog.showMessageBox(mainWindow, {
              type: 'info',
              title: 'Personal Finance Tracker',
              message: 'Personal Finance Tracker v1.1',
              detail: 'Track your income, expenses, and savings goals with ease.'
            });
          }
        }
      ]
    }
  ];

  const menu = Menu.buildFromTemplate(template);
  Menu.setApplicationMenu(menu);
}

/**
 * App ready - start PHP server then create window
 */
app.on('ready', async () => {
  try {
    console.log('App ready, starting PHP server...');
    await startPhpServer();
    console.log('PHP server started successfully');
    
    createWindow();
    createMenu();
  } catch (error) {
    console.error('Failed to start application:', error);
    app.quit();
  }
});

/**
 * Quit when all windows closed
 */
app.on('window-all-closed', () => {
  stopPhpServer();
  
  if (process.platform !== 'darwin') {
    app.quit();
  }
});

/**
 * Re-create window on macOS when dock icon clicked
 */
app.on('activate', () => {
  if (mainWindow === null) {
    createWindow();
  }
});

/**
 * Handle app termination
 */
process.on('exit', () => {
  stopPhpServer();
});
