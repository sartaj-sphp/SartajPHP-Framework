cordova.define("com.sartajphp.scordova.mservice.SphpPlugin", function(require, exports, module) {
var exec = require('cordova/exec');

exports.start = function (arg0, success, error) {
    exec(success, error, 'SphpPlugin', 'start', [arg0]);
};
exports.first_m = function (arg0, success, error) {
    exec(success, error, 'SphpPlugin', 'first_m', [arg0]);
};
exports.onEvent = function (arg0,success, error) {
    exec(success, error, 'SphpPlugin', 'onEvent', [arg0]);
};
exports.getApkInfo = function (apkurl,success, error) {
    exec(success, error, 'SphpPlugin', 'getApkInfo', [apkurl]);
};
exports.getApkInfoPkg = function (packagename,success, error) {
    exec(success, error, 'SphpPlugin', 'getApkInfoPkg', [packagename]);
};
exports.uninstallApp = function (pkgname,success, error) {
    exec(success, error, 'SphpPlugin', 'uninstallApp', [pkgname]);
};
exports.getIMEI = function (success, error) {
    exec(success, error, 'SphpPlugin', 'getIMEI', []);
};
exports.runShell = function (cmd,success, error) {
    exec(success, error, 'SphpPlugin', 'runShell', [cmd]);
};
exports.setDeviceOwner = function (success, error) {
    exec(success, error, 'SphpPlugin', 'setDeviceOwner', []);
};
exports.getInstalledApps = function (success, error) {
    exec(success, error, 'SphpPlugin', 'getInstalledApps', []);
};
exports.getPermissions = function (success, error) {
    exec(success, error, 'SphpPlugin', 'getPermissions', []);
};
exports.unblockStatusbar = function (success, error) {
    exec(success, error, 'SphpPlugin', 'unblockStatusbar', []);
};
exports.updateData = function (arg0,arg1,arg2, success, error) {
    exec(success, error, 'SphpPlugin', 'updateData', [arg0,arg1,arg2]);
};
exports.onMove = function (success, error) {
    exec(success, error, 'SphpPlugin', 'onMove', []);
};
exports.getCurrentPosition = function (success, error) {
    exec(success, error, 'SphpPlugin', 'getCurrentPosition', []);
};
exports.getCurrentAddress = function (success, error) {
    exec(success, error, 'SphpPlugin', 'getCurrentAddress', []);
};
exports.getGEOAddress = function (arg0,arg1,success, error) {
    exec(success, error, 'SphpPlugin', 'getGEOAddress', [arg0,arg1]);
};

});
