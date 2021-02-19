How to Install:-
download Node JS sphpserver applications from http://sartajphp.com/index-info-downloads.html

extract zip file and copy into your "res/sphpserver" folder

For Tutorials:- Check youtube channel:- https://www.youtube.com/channel/UCKENEpj-PZvpS2lC4cqh-7g


For Localhost:- 
Copy file "sapp.sphpn" into your project directory
For Window:- you can also copy "start.vbs" for hide console window.  

Settings.json file:-
phppath = set phppath if you don't want to use system path variable, otherwise leave empty.

Browser only use for desktop applications:-
browser = path to browser application file
browserparam = pass command line arguments to browser application

SSL Settings:- key, cert, ca  If these files paths are not absolute then it is always relative to "settings.json" folder. For localhost certificate is included. You need to register certificate as trusted certificate in your machine otherwise it will give warning for invalid certificate. Register RootCa.crt as trusted root certification authority (on window 10 right click install and select store). You can also create your own certificate with openssl.

You can also overwrite settings.json file with your project folder file. Create file path as "your project folder/sphpserver/settings.json"

For use of HTTPS and WSS protocol:-
You also need to set path for SSL certificate in settings.json

Command to run NodeJS SPHP Server:-

1. Run as server on fix port and host:-
./sphpserver-linux "/home/web/domain.com/public_html" "srvp3" 8001 "domain.com"

2. Run as desktop application on random port on localhost:- 
./sphpserver-linux "/home/web/domain.com/public_html" "srvpm" 

3. Run as server on random port on localhost:- 
./sphpserver-linux "/home/web/domain.com/public_html" "srvp" 

4. Run as child process no server:- 
./sphpserver-linux "/home/web/domain.com/public_html" "srvp2" 

For more info check:- sartajphp.com website


