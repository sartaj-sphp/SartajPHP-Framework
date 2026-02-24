<?php
namespace Sphp\tools {
/**
* Description of Gate
*
* @author Sartaj Singh
*/
class Gate extends SphpGate {
protected $auth = "GUEST";
protected $tblName = "";
protected $masterFile = "";
/** @var \Sphp\kit\Page $page */
public $page = "";
/** @var \Sphp\tools\FrontFile $frontform */
public $frontform;
/** @var \Sphp\tools\FrontFile $mainfrontform */
public $mainfrontform;
/** @var string $gate_dir_path Gate folder path */
public $gate_dir_path = "";
/** @var string $phppath res folder path */
public $phppath = "";
/** @var string $respath res browser url */
public $respath = "";
/** @var string $myrespath Gate browser url */
public $myrespath = "";
/** @var string $mypath Gate folder path */
public $mypath = "";
/** @var \Sphp\kit\JSServer $JSServer */
public $JSServer = null;
/** @var \Sphp\core\Request $Client */
public $Client = null;
/** @var \MySQL $dbEngine */
public $dbEngine = null;
/** @var \Sphp\core\DebugProfiler $debug */
public $debug = null;
/**
* Assign Default FrontFile to Gate for render
* @param \Sphp\tools\FrontFile $obj 
*/
public function setFrontFile($obj) {}
/**
* Get Current FrontFile assign to Gate for render
* @return \Sphp\tools\FrontFile
*/
public function getFrontFile() {}
/**
* Rendering Permission to default assigned FrontFile 
*/
public function showFrontFile() {}
/**
* Disable Rendering Permission to default assigned FrontFile 
*/
public function showNotFrontFile() {}
/**
* Set default table of Database to Sphp\Page object and this Gate.
* This information is important for Components and other database users objects.
* @param string $dbtable
*/
public function setTableName($dbtable) {}
/**
* get default database table assigned to Gate
* @return string
*/
public function getTableName() {}
/**
* get Gate event name trigger by browser
* @return string
*/
public function getEvent() {}
/**
* get Gate event parameter post by browser
* @return string
*/
public function getEventParameter() {}
/**
* onstart=1
* Gate Life Cycle Event
* override this event handler in your Gate to handle it.
* trigger when Gate start
*/
public function onstart() {}
/**
* onfrontinit=2
* Trigger After FrontFile Parse Phase, Component oninit and oncreate 
* Events and before Components onaftercreate event. Trigger for 
*  each Front File use with BasicGate
* Only Trigger if Front File is used with Gate
* override this event handler in your Gate to handle it.
* @param \Sphp\tools\FrontFile $frontobj
*/
public function onfrontinit($frontobj) {}
/** 
* onfrontprocess=3
* Trigger after onaftercreate Event of Component and before BasicGate onready and onrun Events 
* and also before ongateevent Event of Component 
* Only Trigger if Front File is used with Gate
* override this event handler in your Gate to handle it.
* @param \Sphp\tools\FrontFile $frontobj
*/
public function onfrontprocess($frontobj) {}
/**
* onready=4
* Gate Life Cycle Event
* override this event handler in your Gate to handle it.
* trigger after FrontFile Initialization and ready to Run Gate.
*/
public function onready() {}
/** 
* onrun=5
* Gate LifeCycle Event
* override this event handler in your Gate to handle it.
* trigger when Gate run after ready event and before trigger any PageEvent
*/
public function onrun() {}
/** 
* PageEvent Delete
* Trigger only when Browser access URL is matched with PageEvent
* Trigger only one PageEvent per request.
* Trigger after onrun Event and before on render.
* override this event handler in your Gate to handle it.
* trigger when browser get (url=index-delete.html)
* where index is Gate of Gate and Gate path is in reg.php file 
*/
public function page_delete() {}
/** 
* PageEvent View
* Trigger only when Browser access URL is matched with PageEvent
* Trigger only one PageEvent per request.
* Trigger after onrun Event and before on render.
* override this event handler in your Gate to handle it.
* trigger when browser get (url=index-view-19.html)
* where index is Gate of Gate and Gate path is in reg.php file 
* view = event name 
* 19 = recid of database table or any other value.
*/
public function page_view() {}
/** 
* PageEvent Submit
* Trigger only when Browser access URL is matched with PageEvent
* Trigger only one PageEvent per request.
* Trigger after onrun Event and before on render.
* override this event handler in your Gate to handle it.
* trigger when browser post Filled Form Components (url=index.html)
* where index is Gate of Gate and Gate path is in reg.php file 
*/
public function page_submit() {}
/** 
* PageEvent Insert
* Trigger only when Browser access URL is matched with PageEvent
* Trigger only one PageEvent per request.
* Trigger after onrun Event and before on render.
* override this event handler in your Gate to handle it.
* trigger when browser post Filled Empty Form Components (url=index.html)
* where index is Gate of Gate and Gate path is in reg.php file 
*/
public function page_insert() {}
/** 
* PageEvent Update
* Trigger only when Browser access URL is matched with PageEvent
* Trigger only one PageEvent per request.
* Trigger after onrun Event and before on render.
* override this event handler in your Gate to handle it.
* trigger when browser post Edited Form Components Which Filled with 
* \SphpBase::page()->viewData() (url=index.html) 
* from database with view_data function
* where index is Gate of Gate and Gate path is in reg.php file 
*/
public function page_update() {}
/** 
* PageEvent New
* Trigger only when Browser access URL is matched with PageEvent
* Trigger only one PageEvent per request.
* Trigger after onrun Event and before on render.
* override this event handler in your Gate to handle it.
* trigger when browser get URL (url=index.html) first time
* where index is Gate of Gate and Gate path is in reg.php file 
*/
public function page_new() {}
/** 
* onrender=10
* Gate Life Cycle Event
* override this event handler in your Gate to handle it.
* trigger when Gate render after run FrontFile but before start master
* file process. You can't manage FrontFile output here but you can replace FrontFile
* output in SphpBase::$dynData or change master file or add front place for master filepath
*/
public function onrender() {}
/**
* set path of master design file name
* @param string $masterFile
*/
public function setMasterFile($masterFile) {}
/**
* Set which user can access this Gate. Default user is GUEST.
* You can set session variable in login Gate 
* SphpBase::sphp_request()->session('logType','ADMIN');
* If user is not login with specific type then Gate exit and
* redirect according to the getWelcome function in comp.php
* @param string $authenticates <p>
* comma separated list of string. Example:- getAuthenticate("GUEST,ADMIN") or getAuthenticate("ADNIN")
* </p>
*/
public function getAuthenticate($authenticates) {}
/**
* Check if user has session secure url. This Gate can't work with cross session.
* Every Gate has unique url and expired with end of session. 
*/
public function getSesSecurity() {}
/**
* Advance function for change the behavior of Gate
* @param \Sphp\tools\FrontFile $frontobj
*/
/**
* Advance function for change the behavior of Gate
* @param \Sphp\tools\FrontFile $frontobj
*/
/**
* Advance function for change the behavior of Gate
*/
protected function _processEvent() {}
/**
* Advance function for change the behavior of Gate
*/
/**
* Advance function for change the behavior of Gate
*/
protected function _render() {}
}
}
