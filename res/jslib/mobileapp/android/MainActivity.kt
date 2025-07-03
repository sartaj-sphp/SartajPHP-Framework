package <?php echo $caller->mobappid ; ?>

import android.os.Bundle
import androidx.activity.ComponentActivity
import androidx.activity.compose.setContent
import androidx.compose.foundation.layout.fillMaxSize
import androidx.compose.runtime.Composable
import androidx.compose.ui.Modifier
import androidx.compose.ui.viewinterop.AndroidView

import com.sartajphp.webviewlib.SphpRouter
import com.sartajphp.webviewlib.WebViewManager

import org.json.JSONObject


class MainActivity : ComponentActivity() {
    private lateinit var webViewManager: WebViewManager
    private lateinit var sRouter: SphpRouter

    override fun onCreate(savedInstanceState: Bundle?) {
        super.onCreate(savedInstanceState)
        //register App
        webViewManager = WebViewManager(this)
        sRouter = webViewManager.getRouter()
        sRouter.RegisterApp("index","<?php echo $caller->mobappid ; ?>.Index")

        setContent {
            WebViewScreen()
        }
    }

    //override fun onSartajPhpCall(ctrl: String,evt: String,evtp: String,data : JSONObject) {

    /*
        runOnUiThread {
            val message = "$ctrl "
            Toast.makeText(this, "Button Clicked: $message", Toast.LENGTH_SHORT).show()
        }

         */
    //}

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
