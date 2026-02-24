<?php
/**
 * This Component can only work in Mobile App.
 */
class MediaPlayer extends Sphp\tools\Component{

    protected function oninit(){
        // check if Parent Gate is MobileGate Type Object
        if(!property_exists($this->frontobj->parentgate,"mobappid")){
            $this->fu_unsetrender();
        }

    }
    
    protected function onrender(){
        /* @var \Sphp\tools\MobileGate */
        $pgate = $this->frontobj->parentgate;
        $pgate->addKotlinDir($this->mypath . "/mplayer");
        //$pgate->addKotlinGate($this->mypath . "/MPlayer.kt");
        $pgate->addAndroidSetting("dependency", 'implementation("androidx.media3:media3-exoplayer:1.3.1")'); 
        $pgate->addAndroidSetting("dependency", 'implementation("androidx.media3:media3-ui:1.3.1")');
        $pgate->addAndroidSetting("dependency", 'implementation("androidx.media3:media3-exoplayer-rtsp:1.3.1")');
        
        $pgate->addAndroidSetting("application",'<activity android:name="com.sartajphp.gate.mplayer.PlayerActivity" />');

        
    }
} 
