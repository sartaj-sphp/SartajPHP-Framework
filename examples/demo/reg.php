<?php
registerGate("index",__DIR__ ."/apps/Index.gate.php");
registerGate("bind_python",__DIR__ ."/apps/BindPython.gate.php");
registerGate("bind_node",__DIR__ ."/apps/BindNode.gate.php");

// find app in apps folder
if(!SphpBase::sphpRouter()->isRegisterCurrentRequest()){
    $pth = PROJ_PATH . "/apps/" . SphpBase::sphpRouter()->getCurrentRequest() . ".gate.php";
    if(is_file($pth)) SphpBase::sphpRouter()->registerCurrentRequest($pth);
}

