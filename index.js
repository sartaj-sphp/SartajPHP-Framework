#!/usr/bin/env node
const { spawn } = require('child_process');
//module/cli.js

const fs = require("fs"),
 path = require("path");

/** Parse the command line */
var args = process.argv;
var strparam = "";
var blnDeta = true;
for(var c=2;c<args.length; c++){
        //strparam +=  ' ' + args[c];
        if(args[c].toString().startsWith("--")) {
            blnDeta = false;
            //console.log(args[c]);
        }
}
ExecutePath = path.dirname(require.main.filename);

function start2(){ 
    //var start = (process.platform == 'darwin'? 'open': process.platform == 'win32'? "start": "xdg-open");
    var cmd = (process.platform == 'darwin'? 'sh': process.platform == 'win32'? ExecutePath + '\\res\\sphpserver\\sphpserver-win.exe': ExecutePath + '/res/sphpserver/sphpserver-linux');
    if(process.platform == 'win32'){
        blnDeta = false;
    }
    try{
           var options = {
                detached: blnDeta
            };
           //console.log(process.argv);
           const ls = spawn(cmd, process.argv.slice(2),options);
            ls.stdin.setEncoding('utf-8');
            ls.stdout.setEncoding('utf-8');
            ls.stdout.on('data', function(line){
		        console.log(line);
            });
        	ls.stderr.on('data', function (data) {
		        console.error('stderr: ' + data);
        	});

        	ls.on('exit', function (code, signal) {
		        console.log('exit code ' + code);
                process.exit();
        	});
            if(blnDeta){
                process.exit();
            }
    } catch(e) {
        console.error(e);
      } finally {
    //process.exit();
  }

/*
    var child = require('child_process').exec(cmd + strparam);
    console.log(cmd + strparam);
    child.stdout.pipe(process.stdout);

    child.on('exit', function(){
        console.log("exit");
        process.exit();
    }); 

    child.on('error',function (error) {
            console.error(error);
    });
*/
}


start2();

