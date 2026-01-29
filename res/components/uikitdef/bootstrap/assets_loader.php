<?php

function includeRequired() { 
    addBootStrap();
}

function includeFull() { 
    addBootStrap();
}

function addBootStrap() {
    global $jslibpath;
    if(SphpJsM::getJSLibVersion("bootstrap") == -1){ 
    SphpJsM::addFontAwesome6();
    /*addFileLinkCode('bootstrap5', '<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">'
            . '<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>');
     */
    addFileLink("$jslibpath/twitter/bootstrap5/bootstrap.min.css", true, "", "", "bootstrap:5");
    addFileLink("$jslibpath/twitter/bootstrap5/bootstrap.bundle.min.js", true);
    SphpJsM::addAlertDialog();
    SphpJsM::$jslib["bootstrap"] = 5;
    //SphpJsM::addFontAwesome();
    }
}
