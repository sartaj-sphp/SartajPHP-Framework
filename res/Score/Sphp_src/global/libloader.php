<?php
// libloader.php core, kit and tools folder not shipped
// start load library classes
include_once("{$libpath}/core/Engine.php");
include_once("{$libpath}/core/Settings.php");
include_once("{$libpath}/tools/SEvalP.php");
include_once("{$libpath}/tools/SEval.php");
include_once("{$libpath}/core/SphpAPI.php");
include_once("{$libpath}/core/Router.php");
include_once("{$libpath}/core/Request.php");
include_once("{$libpath}/core/Response.php");
include_once("{$libpath}/core/DebugProfiler.php");
include_once("{$libpath}/core/AppLoader.php");

include_once("{$libpath}/kit/Ajax.php");
include_once("{$libpath}/kit/JSServer.php");
include_once("{$libpath}/kit/Page.php");

//load seconday libs
include_once("{$libpath}/tools/SphpApp.php");
include_once("{$libpath}/tools/NodeText.php");
include_once("{$libpath}/tools/NodeTag.php");
include_once("{$libpath}/tools/HTMLDOMNode.php");
include_once("{$libpath}/tools/HTMLDOM.php");
include_once("{$libpath}/tools/SHTMLDOMOld.php");
include_once("{$libpath}/tools/HTMLParser.php");
include_once("{$libpath}/tools/FrontFile.php");
include_once("{$libpath}/tools/Component.php");
include_once("{$libpath}/tools/BasicApp.php");

//include_once("{$libpath}/tools/SHTMLDOM.php");
//include_once("{$libpath}/tools/SHTMLDOM2.php");
//include_once("{$libpath}/tools/HTMLDOM2.php");
//include_once("{$libpath}/tools/HTMLElement.php");
//include_once("{$libpath}/tools/HTMLText.php");


//include_once("{$libpath}/tools/WebApp.php");
//include_once("{$libpath}/tools/SubApp.php");
//include_once("{$libpath}/tools/CompApp.php");
//include_once("{$libpath}/tools/ComboApp.php");
//include_once("{$libpath}/tools/NativeApp.php");
//include_once("{$libpath}/tools/MobileHomeApp.php");
//include_once("{$libpath}/tools/ConsoleApp.php");

//include_once("{$libpath}/comp/ajax/Ajaxsenddata.php");
//include_once("{$libpath}/comp/data/DTable.php");
//include_once("{$libpath}/comp/data/Pagination.php");
//include_once("{$libpath}/comp/data/SearchQuery.php");
//include_once("{$libpath}/comp/Tag.php");

//start interface lib function
include_once("{$libpath}/tools/interfacefunctions.php");
