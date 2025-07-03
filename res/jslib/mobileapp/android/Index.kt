package <?php echo $caller->mobappid ; ?>

import android.util.Log
import com.sartajphp.webviewlib.BasicApp
import com.sartajphp.webviewlib.JSServerC
import org.json.JSONObject
import java.time.LocalDateTime
import java.time.format.DateTimeFormatter
import kotlin.concurrent.thread

class Index(JSServer: JSServerC, ctrl:String, evt:String, evtp:String, data: JSONObject): BasicApp(JSServer,ctrl,evt,evtp,data) {

    override fun onstart(){
        Log.d("Index","on start");
    }
    override fun page_new() {
        thread {
            for (i in 1..4) {

                // Simulate a task that takes time
                Thread.sleep(2000) // Sleep for 5 seconds (5000 milliseconds)
                //val currentDateTime = LocalDateTime.now()
                //val formatter = DateTimeFormatter.ofPattern("yyyy-MM-dd HH:mm:ss")
                //val formattedDateTime = currentDateTime.format(formatter)
                //JSServer.addJSONHTMLBlock("p1", "Hello from kotlin " + formattedDateTime);
                JSServer.addJSONHTMLBlock("p1", "Hello from kotlin " + i.toString());
                JSServer.flush()
            }
            JSServer.addJSONJSBlock("onsen.loadPage(\"page2.html\");")
            JSServer.flush()
        }

    }
}