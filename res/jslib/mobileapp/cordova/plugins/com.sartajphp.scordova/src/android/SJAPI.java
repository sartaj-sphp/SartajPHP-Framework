package com.sartajphp.scordova;

import android.Manifest;
import android.content.ContentValues;
import android.content.Context;
import android.content.Intent;
import android.content.pm.ApplicationInfo;
import android.content.pm.PackageInfo;
import android.content.pm.PackageManager;
import android.provider.Settings;
import android.util.Log;
import org.apache.cordova.CallbackContext;
import org.apache.cordova.CordovaArgs;
import org.apache.cordova.PluginResult;
import org.apache.cordova.CordovaActivity;
import org.json.JSONArray;
import org.json.JSONException;
import org.json.JSONObject;

import java.io.BufferedReader;
import java.io.ByteArrayOutputStream;
import java.io.Closeable;
import java.io.DataOutputStream;
import java.io.IOException;
import java.io.InputStream;
import java.io.InputStreamReader;
import java.util.List;


public class SJAPI {
    private static final String TAG = "cordova.plugin.sbgtask";
    private static JSONObject evtList = new JSONObject();
    private static SphpPlugin plugin;
    public static PackageManager pkg;


    SJAPI(SphpPlugin mObj) {
        SJAPI.plugin = mObj;
    }

    public void first_m(JSONArray args, CallbackContext callbackContext) throws JSONException {
        String message = args.getString(0);
        if (message != null && message.length() > 0) {
            callbackContext.success(message + " Java2");
        } else {
            callbackContext.error("Expected one non-empty string argument.");
        }
    }

    public void getPermissions(JSONArray args, CallbackContext callbackContext) throws JSONException {
        try {
            //plugin.getPermissions();
            callbackContext.success("OK");
        } catch (Exception e) {
            callbackContext.error("Err: " + e.getMessage());
        }
    }



    public void getApkInfoPkg(JSONArray args, CallbackContext callbackContext) throws JSONException {
        JSONObject message = plugin.getApkInfoPkg(args.getString(0));
        //String message = "test";
        if (message != null && message.length() > 0) {
//            Log.i(SphpPlugin.TAG,"imei= " + message.getString("imei"));
            callbackContext.success(message);
        } else {
            callbackContext.error(TAG + " APK Info not found.");
        }
    }


    public void onMove(JSONArray args, CallbackContext callbackContext) throws JSONException {
        evtList.put("onMove", callbackContext);
    }

    public void onEvent(JSONArray args, CallbackContext callbackContext) throws JSONException {
        CordovaArgs carg = new CordovaArgs(args);
        String eventName = carg.getString(0);
        if (eventName != null && eventName != "") {
            evtList.put(eventName, callbackContext);
        }
    }

    public static void triggerEvent(String evtName, JSONObject args) throws JSONException {
        if (evtList.has(evtName)) {
            CallbackContext calb = (CallbackContext) evtList.get(evtName);
            PluginResult pluginResult = new PluginResult(PluginResult.Status.OK, args);
            pluginResult.setKeepCallback(true);
            SphpPlugin.webView1.sendPluginResult(pluginResult, calb.getCallbackId());
            //calb.success(args);
        }
    }

    public static void sendEvent(String evtName, String msg) {
        JSONObject result = new JSONObject();
        try {
            result.put("result", msg);
            SJAPI.triggerEvent(evtName, result);
        } catch (JSONException e) {
        }
    }

}

