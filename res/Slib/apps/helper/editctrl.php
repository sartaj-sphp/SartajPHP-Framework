<?php
//SphpBase::sphp_api()->addProp('page_title','set page_title prop in app');
//$policy = SphpBase::sphp_response()->getSecurityPolicy("*.*");
// SphpBase::sphp_response()->addSecurityHeaders(array());
//\SphpBase::sphp_response()->addHttpHeader('Access-Control-Allow-Origin', '*');
//\SphpBase::sphp_response->()addHttpHeader('Access-Control-Allow-Methods', 'POST, GET, DELETE, PUT, PATCH, OPTIONS');
//SphpBase::sphp_response()->addHttpHeader('Content-Security-Policy','media-src *.*;');

SphpBase::sphp_response()->removeHttpHeader('Strict-Transport-Security');
SphpBase::sphp_response()->removeHttpHeader('Content-Security-Policy');
SphpBase::sphp_response()->removeHttpHeader('Content-Security-Policy-Report-Only');
SphpBase::sphp_response()->removeHttpHeader('Cross-Origin-Opener-Policy');
SphpBase::sphp_response()->removeHttpHeader('X-Frame-Options');
SphpBase::sphp_response()->removeHttpHeader('X-Content-Type-Option');
SphpBase::sphp_response()->removeHttpHeader('X-Xss-Protection');
SphpBase::sphp_response()->addHttpHeader('Access-Control-Allow-Origin', '*');

