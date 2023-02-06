<h1>SartajPHP PHP Framework</h1>
<p align="center"><a href="http://sartajphp.com" target="_blank">
    <img src="http://sartajphp.com/temp/default/images/logo.png">
</a></p>

Info
-----------
[SartajPHP][1] is a **PHP framework** for web applications, Command Line Application, 
Desktop Application with Hybrid Technology and Mobile Application with Hybrid and Ajax Platform.
This PHP Framework used event oriented programming techniques. It is full flexible framework
where you can build any type of application like MVC, Component Oriented, API, Multi Tier,
Cross Platform, Web Service, plugin or extension for another PHP Frameworks, wrapper 
for another PHP frameworks or applications or your new things. This PHP Framework 
has lots of reusable **PHP components**. SartajPHP is giving life to lots of web,desktop and mobile applications.

VS Code Extension Available on Market Place search SartajPHP in VS code
------------
For more info see:- <a href="https://github.com/sartaj-singh/vscode-sartajphp-intellisense">https://github.com/sartaj-singh/vscode-sartajphp-intellisense</a>

Installation
------------

* [Install SartajPHP][1] with Composer or download zip file from github(see
  [GitHub][2]).
How to install it?

With NPM:----

npm install -g sphpdesk

After Installation run command

npx sphpdesk

It runs default project inside res folder. If you want to run directly sphpserver then you can create a symlink inside your bin folder.
For run with double click on file app.sphp, you need to register .sphp file type with sphpserver application. Right click on app.sphp
file and select open with and choose sphpserver application path.OR you can install on your desktop with installation file inside 
res/sphpserver folder


With Composer:----

Add to your composer.json:

    {

        "require": {

            "sartajphp/sartajphp": "dev-master"

        }

    }


Then

	composer install

		OR

	composer update


With Download Zip file from github :--------

After download copy res and demo folder in your root folder. res folder is called framework folder and demo folder is called 
project folder. You can create your component, classes etc. all reusable code in res folder and customized or project related code in 
project folder. Learn more:- [SartajPHP Website][1]


Sphp Server Commands:-
-------------

* Run Desk App mode:- sphpdesk proj_dir/app.sphp
* Run Server App mode:- sphpdesk --proj proj_dir
* Read Settings from app.sphp and you can change running mode of sphpserver


app.sphp file settings:-
-------------
You can over-write these settings with console arguments:-
"project": Name of project,
"type": Run Mode:- srvapp or deskapp or consoleapp,
"host": "localhost",
"port": 0 : port number to serve server
"secure": 0 : no https
"php": "php": use system installed PHP or ""
"browser": "default":- System Default or "$exepath/browser/nw" your custom browser,

   browser command line arguments example:-
"browserparam": ["--url=$url"],
"browserparam1": ["--allow-file-access-from-files", "--disable-web-security", "--user-data-dir=$projpath/cache","--app=$url", "--disable-features=CrossSiteDocumentBlockingIfIsolating"],
"browserparam2": ["--app=$url"],
"browserparam3": ["--new-window", "$url"]

command line example:-
./sphpserver-linux --proj "/home/admin/web/domain.com/public_html" --type "srvp3" --port 8001 --host "domain.com" --php "php" --key "/home/admin/conf/web/ssl.domain.com.key" --cert "/home/admin/conf/web/ssl.domain.com.crt" --ca "/home/admin/conf/web/ssl.domain.com.pem"


Documentation
-------------

* Read the [Getting Started guide][1] if you are new to SartajPHP.
* Video Tutorial on Youtube [SartajPHP Video Tutorial][3] to learn SartajPHP practically.
* [SartajPHP v4.3.x API][5]
* [SartajPHP v4.4.x API][6]
 

Community
---------

* Follow us on [GitHub][2], [Youtube][3] and [Facebook][4].

Contributing
------------

For Contribute and Support us please contacts on our [Facebook][4] Page

Security Issues
---------------

If you discover a security vulnerability within SartajPHP PHP Framework, please contacts us
[Facebook Page][4].



[1]: http://sartajphp.com
[2]: https://github.com/sartaj-singh/SartajPHP-Framework
[3]: https://www.youtube.com/channel/UCKENEpj-PZvpS2lC4cqh-7g
[4]: https://www.facebook.com/DevelopmentFramework/
[5]: http://www.sartajphp.com/api/
[6]: http://www.sartajphp.com/api2/
