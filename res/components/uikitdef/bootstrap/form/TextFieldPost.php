<?php
include_once(SphpBase::sphp_settings()->comp_uikit_path . "/form/TextField.php");


/**
 * Class: TextFieldPost
 *
 * Extended component of TextField that supports:
 *  - AJAX submission
 *  - WebSocket submission
 *  - Debounced request triggering (executes only when user stops typing)
 *
 * ---------------------------------------------------------------------
 * PURPOSE
 * ---------------------------------------------------------------------
 * This component is designed for scenarios such as:
 *
 *  • Live search boxes
 *  • Auto suggestions
 *  • Dynamic form validation
 *  • Real-time data queries
 *
 * The component prevents excessive server calls by using a debounce delay.
 *
 *
 * ---------------------------------------------------------------------
 * FILE LOCATION
 * ---------------------------------------------------------------------
 * If placed inside the SartajPHP UIKit directory:
 *
 * vendor/sartajphp/sartajphp/res/components/uikitdef/bootstrap/uikit/form/
 *
 * Then the Front File can reference it as:
 *
 *     path="uikit/form/TextFieldPost.php"
 *
 *
 * ---------------------------------------------------------------------
 * FUSION ATTRIBUTE MAPPING
 * ---------------------------------------------------------------------
 * SartajPHP allows Front Files to call component methods using Fusion Attributes.
 *
 * Attribute Prefix     Method Prefix
 * ----------------     -------------
 * fur-*                fu_*   (Fusion Render Method)
 * fui-*                fi_*   (Fusion Initialize Method)
 *
 * Example Mapping:
 *
 *     fur-submitAjax   →   fu_submitAjax()
 *
 *
 * ---------------------------------------------------------------------
 * ARGUMENT SEPARATOR
 * ---------------------------------------------------------------------
 * SartajPHP uses `,|` as the parameter separator inside Fusion Attributes.
 *
 * Example:
 *
 *     fur-submitAjax="keyup,|URL,|componentList,|delay"
 *
 *
 * ---------------------------------------------------------------------
 * FRONT FILE EXAMPLE
 * ---------------------------------------------------------------------
 *
 * <input
 *      id="txtsearch"
 *      runat="server"
 *      type="text"
 *      path="uikit/form/TextFieldPost.php"
 *      fur-submitAjax="keyup,|##{getEventURL('usersearch')}#,|txtname,|500"
 * />
 *
 *
 * ---------------------------------------------------------------------
 * SERVER SIDE (PARENT GATE) EXAMPLE
 * ---------------------------------------------------------------------
 *
 * $this->frontFile1
 *      ->getComponent("txtsearch")
 *      ->fu_submitAjax(
 *          "keyup",
 *          getEventURL('usersearch'),
 *          "txtname",
 *          500
 *      );
 *
 *
 * ---------------------------------------------------------------------
 * METHOD: fu_submitAjax()
 * ---------------------------------------------------------------------
 * Attaches a JavaScript event to the text field that submits the value
 * to a server endpoint using AJAX after a debounce delay.
 *
 * Parameters:
 *
 * @param string $eventName
 *        JavaScript event name (keyup, change, input, etc.)
 *
 * @param string $url
 *        Server endpoint URL.
 *        If empty, a default event gate URL will be generated.
 *
 * @param string $extracomp
 *        Comma separated list of additional component IDs whose values
 *        should also be submitted with the request.
 *
 * @param int $delay
 *        Debounce delay in milliseconds.
 *        The request will only be triggered when typing stops for this duration.
 *
 *
 * ---------------------------------------------------------------------
 * METHOD: fu_submitWS()
 * ---------------------------------------------------------------------
 * Similar to fu_submitAjax(), but sends data using WebSocket instead of HTTP.
 *
 * Parameters:
 *
 * @param string $eventName
 *        JavaScript event name to trigger the call.
 *
 * @param string $host
 *        Optional WebSocket host address.
 *
 * @param string $extracomp
 *        Additional component values to include in the request.
 *
 * @param string $gate
 *        Target native gate name.
 *
 * @param string $evt
 *        Event name for WebSocket processing.
 *
 * @param string $evtp
 *        Event parameter passed to the WebSocket gate.
 *
 * @param int $delay
 *        Debounce delay in milliseconds.
 *
 *
 * ---------------------------------------------------------------------
 * PERFORMANCE NOTES
 * ---------------------------------------------------------------------
 *
 * 1. Debouncing significantly reduces server load during typing events.
 *
 * 2. Recommended delay values:
 *
 *      Live search      : 300 – 500 ms
 *      Remote API calls : 500 – 800 ms
 *      Heavy queries    : 800 – 1200 ms
 *
 * 3. WebSocket mode is preferred for real-time interactive applications.
 *
 *
 * ---------------------------------------------------------------------
 * AUTHOR
 * ---------------------------------------------------------------------
 * SartajPHP Component Extension
 *
 */
class TextFieldPost extends \Sphp\comp\form\TextField {

    public function fu_submitAjax($eventName, $url = "", $extracomp = "", $delay = 500) {

        if ($url == "")
            $url = getEventURL($this->name . "_" . $eventName,"","","","",false,".gate",true);

        $selector = "#" . $this->name;

        $jsfun = str_replace("#", "", $selector);
        $jsfun = str_replace(".", "", $jsfun);
        $jsfun = "comp_" . $jsfun . "_" . $eventName;

        $this->onJsEvent($eventName, $jsfun);

        $lstcomp = "";
        if ($extracomp != "") {
            $ar1 = explode(",", $extracomp);
            foreach ($ar1 as $key => $val) {
                if($val[0] != '.') $val = "#$val";
                $lstcomp .= 'data["' . substr($val,1) . '"] = getValue("'. $val .'");';
            }
        }

        $timer = $jsfun . "_timer";

        addHeaderJSFunction(
            $jsfun,
            'var '.$timer.'; function ' . $jsfun . '(evtp){
                clearTimeout('.$timer.');
                '.$timer.' = setTimeout(function(){
                    var data = {};
                    data["' . $this->name . '"] = $("#' . $this->name . '").val();
                    '.$lstcomp.'
                    getURL("' . $url . '",data);
                },'.$delay.');
            ',
            '}'
        );
    }


    public function fu_submitWS($eventName, $host = "", $extracomp = "", $gate="main", $evt="", $evtp="", $delay = 500) {

        $selector = "#" . $this->name;

        $jsfun = str_replace("#", "", $selector);
        $jsfun = str_replace(".", "", $jsfun);
        $jsfun = "compws_" . $jsfun . "_" . $eventName;

        $this->onJsEvent($eventName, $jsfun);

        $lstcomp = "";
        if ($extracomp != "") {
            $ar1 = explode(",", $extracomp);
            foreach ($ar1 as $key => $val) {
                if($val[0] != '.') $val = "#$val";
                $lstcomp .= 'data["' . substr($val,1) . '"] = getValue("'. $val .'");';
            }
        }

        $subcode = "";

        if($host != "")
            $subcode .= "frontobj.websockethost = '$host';";

        $subcode .= "
            frontobj.getSphpSocket(function(wsobj1){
                wsobj1.callProcessNativeGate('$gate','$evt','$evtp',data);
            });
        ";

        $timer = $jsfun . "_timer";

        addHeaderJSFunction(
            $jsfun,
            'var '.$timer.'; function ' . $jsfun . '(evtp){
                clearTimeout('.$timer.');
                '.$timer.' = setTimeout(function(){
                    var data = {};
                    data["' . $this->name . '"] = $("#' . $this->name . '").val();
                    '.$lstcomp.'
                    '.$subcode.'
                },'.$delay.');
            ',
            '}'
        );
    }
}

