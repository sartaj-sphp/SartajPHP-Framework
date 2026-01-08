<?php
/**
 * Description of Jstore
 *
 * @author SARTAJ
 */

class Jstore extends \Sphp\tools\Component{
    private $tables = 'tables: []';
public function oncreate($element){
    $this->setHTMLName("");
    $this->registerEventJS('ready');
}


public function onjsrender(){
    addFileLink($this->myrespath . '/jsstore.js');
    //addFileLink($this->myrespath . '/jsstore.worker.js');
    if(is_dir("cache/sphpbin/resm/jslib") && !is_file("cache/sphpbin/resm/jslib/jsstore.worker.js")){
        copy(realpath($this->mypath) . '/jsstore.worker.js',"cache/sphpbin/resm/jslib/jsstore.worker.js");
        $workerpath = "cache/sphpbin/resm/jslib/jsstore.worker.js";
    }else if(is_dir("cache/sphpbin/resm/jslib")){
        $workerpath = "cache/sphpbin/resm/jslib/jsstore.worker.js";
    }else{
        $workerpath = $this->myrespath . '/jsstore.worker.js';          
    }
    $strdatajs = "";
    $blndatanotvalid = false;
    if(trim($this->innerHTML) != ""){
        $tbl1 = json_decode(trim($this->innerHTML),true);
        if(isset($tbl1["tables"])){
        $tbl2 = $tbl1["tables"];
        $this->tables = 'tables: ' .json_encode($tbl2);
        if(isset($tbl1["data"])){
            $strdatajs = "";
            foreach($tbl1["data"] as $key=>$val){
                    $strdatajs .= "sque1.addInQueue(new Promise(function(resolve2,reject2){
            connection.insert({
            into: '". $key ."',
            values: ". json_encode($val) ."
        }).then(function (rowsAdded) {
            if (rowsAdded > 0) {
                resolve2();
            }else{reject2();}
        }).catch(function(err){logMe(err);reject2();}); }));";
                }
                if($strdatajs != ""){
        $strdatajs = "var sque1 = new StQueue();". $strdatajs . "sque1.wait(function(){dbEngine.ondbready();});";
                }else{
                    $strdatajs = "dbEngine.ondbready();";
                }
        }else{
             $strdatajs = "dbEngine.ondbready();";
        }
        $this->unsetrender();
    }else{
        $blndatanotvalid = true;        
    }}else{
            $blndatanotvalid = true;
    }
    if($blndatanotvalid){
        $this->innerHTML = '{
    "tables": [{
    "name": "tblfdb",
    "columns": [{
        "name": "id",
        "primaryKey": true
    },
        {
            "name": "recname",
            "dataType": "string"
        },
        {
            "name": "recpath",
            "dataType": "object"
        }]},
    {
        "name": "tbllic",
        "columns": [{
            "name": "id",
            "primaryKey": true
        },
            {
                "name": "licname",
                "dataType": "string"
            },
            {
                "name": "starttime",
                "dataType": "number"
            },
            {
                "name": "endtime",
                "dataType": "number"
            },
            {
                "name": "lastps",
                "dataType": "string"
            },
            {
                "name": "extradata",
                "dataType": "string"
            }]
    }],
    "data": {
    "tblfdb": [{"id": 1, "recname": "pckg", "recpath": null}],
    "tbllic": [{"id": 1, "licname": "pckg", "starttime": 0, "endtime": 0, "lastps": "", "extradata": ""}]
    }
    }
';
    }
    addHeaderJSCode('jstore'. $this->name, ' var connection = new JsStore.Instance(new Worker("'. $workerpath .'"));
const dbEngine = {
    dbname: "'. $this->name .'",
    isopen: false,
    ondbready: function(){comp_'. $this->name .'_ready();},
    isRecordExist: function(selector, callback) {
        connection.select(selector).then(function (tbldatalist) {
            if (tbldatalist.length > 0) {
                callback(true);
            } else
            {
                callback(false);
            }
        });
    },
    select: function(selector,
        callback) {
        connection.select(selector).then(callback).catch(function (error) {
            logMe(error);
        })},
    insert: function(tblName,
        value,
        callback) {
        connection.insert({
            into: tblName,
            values: [value]
        }).then(function (rowsAdded) {
            if (rowsAdded > 0) {
                callback(rowsAdded);
            }
        }).catch(function (err) {
            logMe(err);
        });
    },
    checkDB: function(){
            connection.isDbExist(dbEngine.dbname).then(function (isExist) {
        if (isExist) {
            connection.openDb(dbEngine.dbname).then(function () {
                dbEngine.ondbready();
            });
        } else {
            var DataBase = {
                name: dbEngine.dbname,'. $this->tables .'
            };
            connection.createDb(DataBase).then(function (tables) {
                setTimeout(function() { '. $strdatajs .' }, 1000);
            });
        }
    }).catch(function (err) {
        console.log(err);
    });

    }
};
');
    addHeaderJSFunction('comp_'. $this->name .'_ready', 'function comp_'. $this->name .'_ready(event) {', '}');
    addHeaderJSFunctionCode("ready", $this->name, 'dbEngine.checkDB();');
}

public function onrender() {
    
}

}
