<?php

class SphpPreRun extends Sphp\core\SphpPreRunP {

    public function onstart() {
        // manage bootstrap version for controls
        // it over write bootstrap version in master file
        //SphpJsM::addBootStrap5();
        //\SphpBase::sphp_response()->addHttpHeader('Access-Control-Allow-Origin', '*');
        //\SphpBase::sphp_response()->addHttpHeader('Access-Control-Allow-Methods', 'POST, GET, DELETE, PUT, PATCH, OPTIONS');
        //SphpBase::$sphp_api->addProp("pagetitle","Dashboard"); 
        $policy = SphpBase::sphp_response()->getSecurityPolicy("https://www.google.com https://*.google.com https://maps.googleapis.com https://cdnjs.cloudflare.com");
        SphpBase::sphp_response()->addSecurityHeaders($policy);
        //SphpBase::sphp_response()->addHttpHeader('Cross-Origin-Opener-Policy', 'same-origin-allow-popups https://www.google.com https://*.google.com https://maps.googleapis.com ');
        //SphpBase::sphp_response()->addHttpHeader('X-Frame-Options', 'SAMEORIGIN https://www.google.com https://*.google.com https://maps.googleapis.com');
    }

}
