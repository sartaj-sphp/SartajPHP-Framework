package com.sartajphp.gate.mplayer

import android.os.Bundle
import androidx.activity.ComponentActivity
import androidx.media3.common.MediaItem
import androidx.media3.exoplayer.ExoPlayer
import androidx.media3.ui.PlayerView

class PlayerActivity : ComponentActivity() {

    private lateinit var player: ExoPlayer

    override fun onCreate(savedInstanceState: Bundle?) {
        super.onCreate(savedInstanceState)

        val playerView = PlayerView(this)
        setContentView(playerView)

        val rtspUrl = intent.getStringExtra("rtsp_url")

        player = ExoPlayer.Builder(this).build()
        playerView.player = player

        val mediaItem = MediaItem.fromUri(rtspUrl!!)
        player.setMediaItem(mediaItem)
        //player.playWhenReady = true
        player.prepare()
        player.play()
    }

    override fun onDestroy() {
        player.pause()
        player.release()
        super.onStop()
        super.onDestroy()
    }
}
