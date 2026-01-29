// cordova hook
const { exec } = require("child_process");

module.exports = function(context) {
    //callShell('cordova plugin add ./masters/cordova/plugins/com.sartajphp.scordova');
    // auto version will update automatically
    callShell('cordova plugin add ./masters/cordova/plugins/com.sartajphp.scordova --link');
    //callShell('cordova plugin update com.sartajphp.scordova');
};

function callShell(cmd){
      // The CLI command that lead to this hook being executed
  exec(cmd, (error, stdout, stderr) => {
    if (error) {
        console.log(`error: ${error.message}`);
        return;
    }
    if (stderr) {
        console.log(`stderr: ${stderr}`);
        return;
    }
    console.log(`stdout: ${stdout}`);
});

}
