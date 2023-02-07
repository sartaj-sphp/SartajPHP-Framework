<?php
//registerApp("index","apps/index.app");
// find app in apps folder
if(!SphpBase::sphp_router()->isRegisterCurrentRequest()){
    $pth = PROJ_PATH . "/apps/" . SphpBase::sphp_router()->getCurrentRequest() . ".app";
    if(is_file($pth)) SphpBase::sphp_router()->registerCurrentRequest($pth);
}

