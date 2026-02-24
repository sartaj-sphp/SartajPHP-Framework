package com.sartajphp.gate.mplayer

import android.content.Intent
import com.sartajphp.webviewlib.KotlinGate

class MPlayerGate: KotlinGate() {

    suspend fun page_event_open(evtp: String) {
        val intent = Intent(KotlinApi.activity, PlayerActivity::class.java)
        intent.putExtra("rtsp_url", evtp)
        KotlinApi.activity.startActivity(intent)
    }

}
