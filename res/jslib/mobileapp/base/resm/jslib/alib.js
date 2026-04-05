window["parseAndroidData"] = function (data){
    parseSphpResponse(data + ",",function(ret){}); 
};
window["parseAndroidSphpData"] = function (data){
    parseSphpResponse(data ,function(ret){}); 
};
window["callKotlinGate"] = function (ctrl,data={}){
    Android.callKotlinGate(ctrl,JSON.stringify(data));
};
window["callKotlinGateEvent"] = function (ctrl,evt,evtp="",data={}){
    Android.callKotlinGateEvent(ctrl,evt,evtp,JSON.stringify(data));
};        
window["callSphpGateEvent"] = function (ctrl,evt,evtp="",data={},timeout=30){
    Android.callSphpGateEvent(ctrl,evt,evtp,JSON.stringify(data),timeout);
};        
window["hasPermission"] = function (permission){
    return Android.hasPermission(permission);
};
window["requestPermission"] = function (permission) {
    Android.requestPermission(permission);
};
window["hasAllPermissions"] = function (aryPermissions){
    return Android.hasAllPermissions(JSON.stringify(aryPermissions));
};
window["requestAllPermissions"] = function (aryPermissions) {
    Android.requestAllPermissions(JSON.stringify(aryPermissions));
};
window["restorePermissions"] = function (aryPermissions) {
    Android.restorePermissions(JSON.stringify(aryPermissions));
};
