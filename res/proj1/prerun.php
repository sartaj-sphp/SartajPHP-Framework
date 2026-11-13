<?php

class SphpPreRun extends Sphp\Core\SphpPreRunP {

    public function onstart() {
        // manage bootstrap version for controls
        // it over write bootstrap version in master file
        //SphpJsM::addBootStrap5();
        //\SphpBase::sphpResponse()->addHttpHeader('Access-Control-Allow-Origin', '*');
        //\SphpBase::sphpResponse()->addHttpHeader('Access-Control-Allow-Methods', 'POST, GET, DELETE, PUT, PATCH, OPTIONS');
        //SphpBase::$sphpApi->addProp("pagetitle","Dashboard"); 
        $policy = SphpBase::sphpResponse()->getSecurityPolicy("https://www.google.com https://*.google.com https://maps.googleapis.com https://cdnjs.cloudflare.com");
        SphpBase::sphpResponse()->addSecurityHeaders($policy);
        //SphpBase::sphpResponse()->addHttpHeader('Cross-Origin-Opener-Policy', 'same-origin-allow-popups https://www.google.com https://*.google.com https://maps.googleapis.com ');
        //SphpBase::sphpResponse()->addHttpHeader('X-Frame-Options', 'SAMEORIGIN https://www.google.com https://*.google.com https://maps.googleapis.com');
    }

}
