<?php
registerApp("index",__DIR__ ."/apps/index.app");
registerApp("bind_python",__DIR__ ."/apps/bind_python.app");
registerApp("bind_node",__DIR__ ."/apps/bind_node.app");

// find app in apps folder
if(!SphpBase::sphp_router()->isRegisterCurrentRequest()){
    $pth = PROJ_PATH . "/apps/" . SphpBase::sphp_router()->getCurrentRequest() . ".app";
    if(is_file($pth)) SphpBase::sphp_router()->registerCurrentRequest($pth);
}

