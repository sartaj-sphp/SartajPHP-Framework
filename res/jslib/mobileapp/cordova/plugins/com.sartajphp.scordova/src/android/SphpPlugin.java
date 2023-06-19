package com.sartajphp.scordova;

import android.Manifest;
import android.app.admin.DevicePolicyManager;
import android.content.ComponentName;
import android.content.Context;
import android.content.Intent;
import android.content.pm.ApplicationInfo;
import android.content.pm.PackageInfo;
import android.content.pm.PackageManager;

import android.annotation.SuppressLint;
import android.net.Uri;
import android.util.Log;
import java.lang.reflect.Method;
import org.apache.cordova.CallbackContext;
import org.apache.cordova.CordovaInterface;
import org.apache.cordova.CordovaPlugin;
import org.apache.cordova.CordovaResourceApi;
import org.apache.cordova.CordovaWebView;
import org.apache.cordova.LOG;
import org.apache.cordova.PluginResult;
import org.json.JSONArray;
import org.json.JSONException;
import org.json.JSONObject;


public class SphpPlugin extends CordovaPlugin {
    public static SJAPI sapi = null;
    //public static MainActivity mainObj = null;
    public static CordovaWebView webView1 = null;

    /**
     * Constructor.
     */
    public SphpPlugin() {
    }

    @Override
    public void initialize(CordovaInterface cordova, CordovaWebView webView) {
        //Log.d(TAG, "Initialize");
        SphpPlugin.sapi = new SJAPI(this);
        SphpPlugin.webView1 = webView;
    }

    public JSONObject getApkInfoPkg(String packageName) {
        JSONObject result = new JSONObject();
        try{
            Context context = this.cordova.getActivity().getApplicationContext();
            PackageManager pm = context.getPackageManager();
            //ApplicationInfo info = pm.getApplicationInfo(packageName, 0);
            PackageInfo info = pm.getPackageInfo(packageName, 0);
            if (info != null && info.packageName != null) {
                result.put("packageName",info.packageName);
                result.put("appName",info.applicationInfo.loadLabel(pm));
                result.put("versionName",info.versionName);
                return result;
            } else {
                return result;
            }
        }catch(Exception e){
            printErr(e.getMessage());
            return result;
        }

    }

    @Override
    protected void pluginInitialize() {
        //printLog("after Initialize " );
    }

    /**
     * Called when the system is about to start resuming a previous activity.
     *
     * @param multitasking		Flag indicating if multitasking is turned on for app
     */
    @Override
    public void onPause(boolean multitasking) {
       // printLog("p pause");
    }

    /**
     * Called when the activity will start interacting with the user.
     *
     * @param multitasking		Flag indicating if multitasking is turned on for app
     */
    @Override
    public void onResume(boolean multitasking) {
       // printLog("p resume");

    }

    /**
     * Called when the activity is becoming visible to the user.
     */
    @Override
    public void onStart() {
        //printLog("p start");
        //getPermissions();
    }
    /**
     * Called when the activity is no longer visible to the user.
     */
    @Override
    public void onStop() {
        //Log.d(TAG, "p stop");
    }

    /**
     * Called when the activity receives a new intent.
     */
    @Override
    public void onNewIntent(Intent intent) {
       // Log.d(TAG, "p new intent");
    }

    /**
     * The final call you receive before your activity is destroyed.
     */
    @Override
    public void onDestroy() {
        //Log.d(TAG, "p destroy");
    }

    public void printLog(String msg){
        Log.d("com.sartajphp", msg);
    }
    public void printErr(String msg){
        Log.e("com.sartajphp", msg);
    }

    @Override
    public boolean execute(final String action, final JSONArray args, final CallbackContext callbackContext) throws JSONException {
        if (action.equals("cool")) {
            final String message = args.getString(0);
            final SphpPlugin self = this;
            cordova.getThreadPool().execute(new Runnable() {
                public void run() {
                    self.coolMethod(message, callbackContext);
                 }
            });
            return true;
        }else{
            cordova.getThreadPool().execute(new Runnable() {
                public void run() {
                    try {
                        Method method = SJAPI.class.getMethod(action, JSONArray.class,CallbackContext.class);
                        method.invoke(sapi, args, callbackContext);
                    } catch (Exception e) {
                        printErr("Method is not found " + action);
                        callbackContext.error(action + " Method is not found");
                    }
                }
            });
            return true;
        }
    }

    public void coolMethod(String message, CallbackContext callbackContext) {
        if (message != null && message.length() > 0) {
            callbackContext.success(message + " check Java reply");
        } else {
            callbackContext.error("Expected one non-empty string argument.");
        }
    }

}
