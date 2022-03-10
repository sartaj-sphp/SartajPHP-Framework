<div id="layout1" runat="server" path="sartajc/desktop/Layout.php" pathres="temp/default/comp/desktop/">
<div id="layout1_north" class="ui-layout-north">
    <div style="float: left;">
    <h1 class="heading">Randhawa Tech Software</h1>
    </div>
    <div style="float: right;">
<h1 class="heading">Welcome <?php echo $_SESSION['uid'].' '; ?></h1>
<a href="<?php print getEventPath('logout','','softlog'); ?>">Logout</a>
    </div>
      <div style="clear: both;"></div>
</div>

<div id="layout1_west" class="ui-layout-west">
<div id="menu" class="menu">
<?php 
$tmp = new TempFile("temp/default/menu_prof/menu.php");
$tmp->run(); $tmp->render();
?>

</div>
</div>
<!-- Center Content Part Start Here -->
<div id="layout1_center" class="ui-layout-center">
<div id="srvmsg">Server is Ready for Working</div>
<div id="srvmsg2"></div>
<div id="outid"></div>
<div id="chat_window" style="display:none;"></div>
</div>
<div id="buffer1" style="display:none;"></div>
</div>
<!-- Center Content Part End Here -->

<div id="layout1_east" class="ui-layout-east">
<h1 class="headerbar">Updates</h1>
<div class="panel">Check news here</div>
<h1 class="headerbar">Chat Box</h1>
<div class="panel">
    <a href="#" onclick="getURL('softhome-chat-aman.html');">Aman</a><br />
    <a href="#" onclick="getURL('softhome-chat-sumin.html');">Sumin</a><br />
    <a href="#" onclick="getURL('softhome-chat-joban.html');">Joban</a><br />
</div>
<h1 class="headerbar">Live Music</h1>
<div class="panel">
This Function Temporarily Stopped
    <!--
<OBJECT id='mediaPlayer1' width="160" height="150"
classid='CLSID:22d6f312-b0f6-11d0-94ab-0080c74c7e95'
codebase='http://activex.microsoft.com/activex/controls/mplayer/en/nsmp2inf.cab#Version=5,1,52,701'
standby='Loading Microsoft Windows Media Player components...' type='application/x-oleobject'>
<param name='fileName' value="http://192.168.35.100/resimg/playlist.m3u">
<param name='animationatStart' value='true'>
<param name='transparentatStart' value='true'>
<param name='autoStart' value="true">
<param name='showControls' value="true">
<param name ="ShowAudioControls"value="true">
<param name="ShowStatusBar" value="true">
<param name='autosize' value="true">
<param name='loop' value="false">
<EMBED type='application/x-mplayer2'
pluginspage='http://microsoft.com/windows/mediaplayer/en/download/'
id='mediaPlayer' name='mediaPlayer' displaysize='100' autosize='true'
bgcolor='darkblue' showcontrols="true" showtracker='true'
showdisplay='true' showstatusbar='true' videoborder3d='true' width="160" height="150"
src="http://192.168.35.100/resimg/playlist.m3u" autostart="true" designtimesp='5311' loop="false">
</EMBED>
</OBJECT>
    -->
</div>
</div>
<div id="layout1_south" class="ui-layout-south">Powered By Randhawa Tech</div>
</div>