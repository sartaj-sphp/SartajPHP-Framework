const sphpdesk = require('sphpdesk');
const { app, BrowserWindow } = require('electron');
var ls = null;
var win = null;
var mhost = '127.0.0.1';
var mport = 8000;
const path = require('path');

const createWindow = () => {
  win = new BrowserWindow({
    width: 800,
    height: 600,
    webPreferences: {
        nodeIntegration: true,    
    }
  });
  win.loadURL("http://" + mhost + ":" + mport);
};

app.whenReady().then(async () => {
    ret = await sphpdesk.run_sphp_server("127.0.0.1",0,0,path.resolve(__dirname + "/../demo"));
    mhost = ret.host;
    mport = ret.port;
    ls = ret.SphpServer;
    createWindow();
    app.on('activate', () => {
        if (BrowserWindow.getAllWindows().length === 0){
            createWindow();
         }
    })

});

app.on('window-all-closed', () => {
    ls.kill('SIGINT');
  if (process.platform !== 'darwin') app.quit();
})