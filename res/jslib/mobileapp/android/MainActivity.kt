package ##{$caller->mobappid}#

import android.os.Bundle
import android.util.Log
import androidx.activity.compose.setContent
import androidx.compose.foundation.layout.fillMaxSize
import androidx.compose.runtime.Composable
import androidx.compose.ui.Modifier
import androidx.compose.ui.viewinterop.AndroidView
import com.sartajphp.webviewlib.JSServerC
import com.sartajphp.webviewlib.MainActivityBase

import com.sartajphp.webviewlib.SphpRouter
import com.sartajphp.webviewlib.WebViewManager
import com.sartajphp.webviewlib.SphpKotlinApi

import org.json.JSONObject


class MainActivity : MainActivityBase() {

    override fun onCreate(savedInstanceState: Bundle?) {
        super.onCreate(savedInstanceState)
        //register App
        webViewManager = WebViewManager(this)
        webViewManager.KotlinApi.restoreAllDeclaredPermissions()
        //sRouter.RegisterGate("index","com.sartajphp.sphpview.IndexGate")
        autoRegisterApps()
        setContent {
            WebViewScreen()
        }
    }

    override fun updatePermissionResultApi(permission: String, granted: Boolean, permanentlyDenied: Boolean) {
        webViewManager.KotlinApi.onPermissionResult(permission, granted,permanentlyDenied)
    }
        private fun autoRegisterApps() {
        val json = assets
            .open("regapp.json")
            .bufferedReader()
            .use { it.readText() }

        val obj = JSONObject(json)

        obj.keys().forEach { key ->
            val classPath = obj.getString(key)
            try {
                webViewManager.Router.RegisterGate(key, classPath)
            } catch (e: Exception) {
                Log.e("SartajPHP", "Failed to register app: $classPath", e)
            }
        }
    }

    @Composable
    fun WebViewScreen() {
        val webView = webViewManager.createWebView()



        // Integrate the WebView into Jetpack Compose using AndroidView
        AndroidView(
            factory = {webView },
            modifier = Modifier.fillMaxSize()
        )
    }

}
