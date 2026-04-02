const { contextBridge } = require('electron');

// Expose safe APIs to renderer process
contextBridge.exposeInMainWorld('api', {
  version: process.version,
  platform: process.platform
});
