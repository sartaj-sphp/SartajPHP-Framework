<?php
/**
 * This Component can only work in Mobile App.
 */
class MediaPlayer extends Sphp\Tools\Component{

    protected function oninit(){
        // check if Parent Gate is MobileGate Type Object
        if(!property_exists($this->frontobj->parentGate,"mobappid")){
            $this->fu_unsetrender();
        }

    }
    
    protected function onrender(){
        /* @var \Sphp\Tools\MobileGate */
        $pgate = $this->frontobj->parentGate;
        $pgate->addKotlinDir($this->myPath . "/mplayer");
        //$pgate->addKotlinGate($this->myPath . "/MPlayer.kt");
        $pgate->addAndroidSetting("dependency", 'implementation("androidx.media3:media3-exoplayer:1.3.1")'); 
        $pgate->addAndroidSetting("dependency", 'implementation("androidx.media3:media3-ui:1.3.1")');
        $pgate->addAndroidSetting("dependency", 'implementation("androidx.media3:media3-exoplayer-rtsp:1.3.1")');
    // HLS extension - REQUIRED for .m3u8 streams
        $pgate->addAndroidSetting("dependency", 'implementation("androidx.media3:media3-exoplayer-hls:1.3.1")');
    // For DASH (if needed)
        $pgate->addAndroidSetting("dependency", 'implementation("androidx.media3:media3-exoplayer-dash:1.3.1")');
    // For session management (optional)
        $pgate->addAndroidSetting("dependency", 'implementation("androidx.media3:media3-session:1.3.1")');
        
        $pgate->addAndroidSetting("application",'<activity android:name="com.sartajphp.gate.mplayer.PlayerActivity" />');

        
    }
} 
