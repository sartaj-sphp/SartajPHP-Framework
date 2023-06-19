//cordova.define("com.sartajphp.scordova.SphpPlugin", function(require, exports, module) {
var exec = require('cordova/exec');

exports.cool = function (arg0, success, error) {
    exec(success, error, 'SphpPlugin', 'cool', [arg0]);
};
function callJava(javafun,args, success, error){
    if(! isset(success)) success = console.log;
    if(! isset(error)) error = console.error;
    exec(success, error, 'SphpPlugin', javafun, args);
}
//});
