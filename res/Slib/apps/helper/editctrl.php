<?php
//SphpBase::sphpApi()->addProp('page_title','set page_title prop in app');
//$policy = SphpBase::sphpResponse()->getSecurityPolicy("*.*");
// SphpBase::sphpResponse()->addSecurityHeaders(array());
//\SphpBase::sphpResponse()->addHttpHeader('Access-Control-Allow-Origin', '*');
//\SphpBase::sphpResponse->()addHttpHeader('Access-Control-Allow-Methods', 'POST, GET, DELETE, PUT, PATCH, OPTIONS');
//SphpBase::sphpResponse()->addHttpHeader('Content-Security-Policy','media-src *.*;');

SphpBase::sphpResponse()->removeHttpHeader('Strict-Transport-Security');
SphpBase::sphpResponse()->removeHttpHeader('Content-Security-Policy');
SphpBase::sphpResponse()->removeHttpHeader('Content-Security-Policy-Report-Only');
SphpBase::sphpResponse()->removeHttpHeader('Cross-Origin-Opener-Policy');
SphpBase::sphpResponse()->removeHttpHeader('X-Frame-Options');
SphpBase::sphpResponse()->removeHttpHeader('X-Content-Type-Option');
SphpBase::sphpResponse()->removeHttpHeader('X-Xss-Protection');
SphpBase::sphpResponse()->addHttpHeader('Access-Control-Allow-Origin', '*');

