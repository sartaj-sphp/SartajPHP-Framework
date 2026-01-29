# Chapter 1 – Introduction

## 1.0 SartajPHP Overview (Event-Oriented Model)

SartajPHP is an **event-oriented PHP framework** designed to build **event-driven applications** for web, AJAX, real-time, and CLI environments.

Instead of treating a browser request as a static page load, SartajPHP **translates each URL into server-side events**, called **PageEvents**.
Application logic is written around these events rather than controllers or route tables.

This model makes SartajPHP:

* Modular
* Extensible
* Suitable for traditional websites and real-time systems

SartajPHP acts as an **event translation and execution engine** between:

* Browser / Client
* Server
* Application logic

SartajPHP **does not rely on MVC controllers or route configuration files**.
Each request is resolved directly into an executable PageEvent.

---

## 1.1 SartajPHP Minimal Project Structure — Folder & File Purpose

> **Note:**
> Most **website-type projects only use the `/apps` folder**.
> The `/appsn` folder is optional and used only for **NativeApp** or **ConsoleApp** projects.

```text
/apps
  /fronts
    index_main.front
    calculator_main.front
  index.app
  calculator.app
  regapp.php

/appsn              # optional (not used by most websites)
  /spython
  /env
  chatserver.app
  regapp.php
  /console
    compile.app
    regapp.php

/cache
/plugin

/masters
  /default
    admmenu.php
    menu.php
    master.php
  db.php
  sphpcodeblock.php

.htaccess
app.sphp
cachelist.php
comp.php
composer.json
prerun.php
reg.php
start.php
```

---

## 1.2 Folder & File Responsibilities

| Path / File                    | Type     | Purpose                                                                                       |
| ------------------------------ | -------- | --------------------------------------------------------------------------------------------- |
| `/apps/`                       | Folder   | Holds **BasicApp** applications. This is the primary location for browser-based web projects. |
| `/apps/fronts/`                | Folder   | Stores **Front Files** (`*.front`) used for UI design and component layout.                   |
| `/apps/*.app`                  | App File | Defines BasicApp logic, Appgate, and PageEvents.                                              |
| `/apps/regapp.php`             | PHP File | Registers all BasicApps and other App Types with Appgate.                                     |
| `/appsn/`                      | Folder   | Optional. Holds **NativeApp** and **ConsoleApp** projects (CLI, services, long-running apps). |
| `/cache/`                      | Folder   | Stores cache, compiled data, and error logs. **Must be writable**.                            |
| `/plugin/`                     | Folder   | Stores plugin configuration and project-level plugin data.                                    |
| `/masters/`                    | Folder   | Stores **design and UI-related files** shared across Apps.                                    |
| `/masters/default/`            | Folder   | Default master assets used by the project.                                                    |
| `/masters/default/master.php`  | PHP File | Defines master design of HTML Output like head,body tags and JS,CSS Lib + App Dynamic Output  |
| `/masters/default/menu.php`    | PHP File | Defines menu structure for **guest (unauthorized) users**.                                    |
| `/masters/default/admmenu.php` | PHP File | Defines menu structure for **authorized / admin users**.                                      |
| `/masters/db.php`              | PHP File | Contains SQL queries to **create tables and insert default data during installation**.        |
| `/masters/sphpcodeblock.php`   | PHP File | Used to **extend or override FrontFile CodeBlocks** at project level.                         |
| `.htaccess`                    | Config   | Apache rewrite rules redirecting all requests to `start.php`.                                 |
| `app.sphp`                     | Config   | Desktop / environment-specific runtime settings.                                              |
| `cachelist.php`                | PHP File | Registers cacheable Appgate requests with cache engine.                                       |
| `comp.php`                     | PHP File | Project-level configuration (database, email, framework options).                             |
| `composer.json`                | Config   | Composer dependency configuration.                                                            |
| `prerun.php`                   | PHP File | Runs **before App loading**. Used for security headers, profiling, and third-party includes.  |
| `reg.php`                      | PHP File | Central registry that loads all `regapp.php` files.                                           |
| `start.php`                    | PHP File | **Single entry point**. Loads SartajPHP engine and runs the project.                          |

> SartajPHP intentionally does **not** use `index.php`.
> All requests are redirected to `start.php` to ensure a controlled bootstrap process and avoid conflicts.

---

## 1.3 SartajPHP Installation & Resource Path Configuration

SartajPHP can be installed:

1. **Inside the project directory** (recommended via Composer)
2. **Outside the project directory** (shared installation)

The **resource (`res`) folder path must be explicitly defined in `start.php`**.

---

### 1.3.1 Installation Inside Project Directory (Composer)

```php
$sharedpath = "./vendor/sartajphp/sartajphp";
$respath    = "./vendor/sartajphp/sartajphp/res";

$slibversion = "Slib";
$libversion  = "Sphp";
```

---

### 1.3.2 Installation Outside Project Directory

```php
$sharedpath = "..";
$respath    = "../res";

$slibversion = "Slib";
$libversion  = "Sphp";
```

* `$sharedpath` → filesystem path to SartajPHP core
* `$respath` → **browser-accessible URL path** to the `res` folder

---

## 1.4 SartajPHP `res` Folder Structure

The `res` folder contains **shared framework-managed resources**.

### Resource Directory Layout

```text
/res
  /Score
    /Sphp        # Core runtime
    /SphpDoc     # Framework documentation
    /global      # Global default configurations

  /Slib
    /apps        # Shared Apps and libraries
    /comp        # Inbuilt Server Components

  /classes       # Shared PHP libraries
  /components    # UI Components
    /uikitdef    # Inbuilt UI Components and Default MasterFiles
  /jslib         # Shared JavaScript libraries
  /plugin        # Plugin resources
  /sample        # Sample project templates
```

---

### Purpose of Resource Folders

| Folder        | Purpose                                                |
| ------------- | ------------------------------------------------------ |
| `/Score`      | Core runtime, global configuration, and documentation. |
| `/Slib`       | Shared Apps, FrontFiles, Components, and MasterFiles.  |
| `/classes`    | Shared or third-party PHP libraries.                   |
| `/components` | UI Kit and other components for Front Files.           |
| `/jslib`      | Framework-managed JavaScript libraries.                |
| `/plugin`     | Plugin resources, Apps, FrontFiles, and assets.        |
| `/sample`     | Sample project templates for new projects.             |

---

### Important Design Note

> The `res` directory is **fully framework-managed**.
> Applications should reference resources using SartajPHP APIs rather than hardcoded paths to ensure:
>
> * Portability
> * Cache control
> * Upgrade safety

---

## 1.5 Common Framework Paths, URLs, and Runtime Location Helpers

SartajPHP provides a **consistent and centralized way to access filesystem paths and browser URLs** across the framework.
These values are resolved through **`SphpBase::sphp_settings()`** or helper methods, ensuring portability and correctness across environments.

---

### 1.5.1 Core Framework Paths (`SphpBase::sphp_settings()`)

All core framework paths and URLs are accessible via:

```php
SphpBase::sphp_settings()->*
```

| Resource Area         | Property Name        | Type        | Description                                                      |
| --------------------- | -------------------- | ----------- | ---------------------------------------------------------------- |
| `res/Slib`            | `slib_path`          | Server Path | Filesystem path to shared Slib resources                         |
| `res/Slib`            | `slib_res_path`      | Browser URL | Public URL to Slib resources                                     |
| `components/uikitdef` | `comp_uikit_path`    | UI Kit Path | Filesystem path to UI Kit Components                             |
| `components/uikitdef` | `comp_uikit_res_path`| Browser URL | Public URL to UI Kit Components resources                        |
| `res` folder          | `php_path`           | Server Path | Filesystem path to global `res` directory                        |
| `res` folder          | `res_path`           | Browser URL | Public URL of the global `res` directory                         |
| `res/Score`           | `lib_path`           | Server Path | Core runtime and framework internal libraries (server-side only) |

> `Score` resources are **never exposed to browser URLs** and are strictly server-side.

---

### 1.5.2 Project-Level Paths

These paths Constant describe where the **current project is located and executed from**.

| Path Name             | Identifier   | Description                                             |
| --------------------- | ------------ | ------------------------------------------------------- |
| Project Path          | `PROJ_PATH`  | Filesystem path of the directory containing `start.php` |
| Project Run Directory | `start_path` | Runtime working directory (usually same as `PROJ_PATH`) |

> `start_path` represents the **execution context**, while `PROJ_PATH` represents the **project root**.

---

### 1.5.3 Server & Website Base Paths

SartajPHP settings also exposes commonly required server and URL locations, accessible via:

```php
SphpBase::sphp_settings()->*
```

| Purpose              | Method / Property  | Type        |
| -------------------- | ------------------ | ----------- |
| Website Base URL     | `getBase_url()`    | Browser URL |
| Server Document Root | `getServer_path()` | Server Path |

* **Base URL** → Root URL of the website (protocol + domain + base folder)
* **Server Path** → Filesystem path to the web server document root

---

### 1.5.4 Unified Object-Level Path Conventions

Most SartajPHP runtime objects follow a **consistent naming convention** for paths and URLs.

| Object Type | Server Path Property | Browser URL Property |
| ----------- | -------------------- | -------------------- |
| App         | `mypath`             | `myresurl`           |
| FrontFile   | `mypath`             | `myresurl`           |
| Component   | `mypath`             | `myresurl`           |

**Meaning:**

* `mypath` → Filesystem location of the object
* `myresurl` → Public browser URL to the same object’s resource folder

This consistency allows developers to **move logic between App, FrontFile, and Component layers** without rewriting path logic.

---

### 1.5.5 Design Principle

> SartajPHP avoids hardcoded paths and URLs.
>
> All filesystem and browser locations should be resolved using:
>
> * `SphpBase::sphp_settings()`
> * Object-level properties (`mypath`, `myresurl`)

This ensures:

* Environment portability
* Clean separation of server-side and client-side resources
* Compatibility with caching, plugins, and shared installations

---

### File Creation Rules (For Models & Developers)

Each SartajPHP project file follows a strict responsibility rule:

| File | Rule |
|----|----|
| `.htaccess` | Only routing and access control. No PHP logic. |
| `start.php` | Bootstrap only. No project logic. |
| `reg.php` | App registration only. No business logic. |
| `prerun.php` | Pre-App hooks only (security, profiling, headers). |
| `comp.php` | Configuration only. No execution logic. |
| `cachelist.php` | Cache rules only. |
| `db.php` | Schema creation and default data only. |
| `menu.php` | Guest menu only. |
| `admmenu.php` | Authorized/admin menu only. |

❗ Never mix responsibilities across files.

---

This chapter explains the **minimum required project files** in SartajPHP, their purpose, and how they participate in the application lifecycle.

These files define **routing, caching, configuration, security, bootstrapping, database initialization, and UI menus**.

---

## 1.6 `.htaccess` – Apache Rewrite & Entry Control

SartajPHP uses a **single entry file (`start.php`)** for all browser requests.
Apache rewrite rules ensure that HTML-like URLs are translated into PageEvents.

```apache
Options +FollowSymLinks -Indexes
DirectoryIndex start.php

RewriteEngine On

# Route all .html / .htm requests
RewriteCond %{REQUEST_URI} \.(html|htm)$ [NC]
RewriteCond %{REQUEST_FILENAME} !-f
RewriteCond %{REQUEST_FILENAME} !-d
RewriteRule ^(.*)$ start.php [NC,L]

# Prevent direct access to .front and .app files
RewriteCond %{REQUEST_URI} \.(front|app)$ [NC]
RewriteRule ^(.*)$ start.php [NC,L]
```

### Purpose

* Forces **all requests** through `start.php`
* Prevents direct access to:

  * FrontFiles (`*.front`)
  * App files (`*.app`)
* Enables clean URLs like:

  ```
  index.html
  index-view-2.html
  chat-send-eml.html
  ```

---

## 1.7 `cachelist.php` – Cache Registration

Registers Appgate-level caching rules.

```php
<?php
addCacheList("index", 3600);
```

### Meaning

* Caches **all events under Appgate `index`**
* Cache duration: **3600 seconds**
* Reduces processing for static or semi-static pages

---

## 1.8 `comp.php` (Company Details File) – Project Configuration File

Defines **project identity, database, authentication, mail, and master layout settings**.

```php
$cmpid   = "demo";
$cmpname = "SartajPHP Demo";

/* Database */
$duser = "root";
$db    = "db1";
$dpass = "mypass";

/* Debug mode between 0 to 3, 0 mean disable */
$debugmode = 2;

/* Admin Credentials */
$admuser = 'admin';
$admpass = '1234';
// Component UI Kit uikitdef/bootstrap folder
$ComponentUI = "/uikitdef/bootstrap"; // Bootstrap

/* Base Path Adjustment for Sub Folder*/
if ($basepath != "") {
    $basepath .= "/demo";
}

/* Mail Settings */
$mailServer = "mail.domain.com";
$mailUser   = "info@domain.com";
$mailPass   = "";
$mailPort   = "26";

/* Master Files, choose these or create your own global variable for your project */
/* GUEST master file or use for All login type Role */
$masterf = "{$comppath}{$ComponentUI}/masters/default/master.php";
/* MEMBER Role master file or use for All Profiles in Permissions as security rather then Role */
$mebmasterf  = $masterf;
```

### Welcome Redirect Logic

```php
/** This function getWelcome helps to find home page of authorised user and 
 *  call by SphpBase::page()->Authenticate("GUEST") and 
 * SphpBase::page()->getAuthenticatePerm("GUEST") functions when they failed to find 
 * Authorised user. Secure Applications use this function to redirect user on correct home 
 * Page like GUEST user will be forward to Webiste home page (index.app) 
 */
function getWelcome(){
    $page = SphpBase::page();

    switch ($page->getAuthenticateType()) {
        case "ADMIN":
            $page->forward(getAppURL("mebhome",'','',true));
            break;

        case "MEMBER":
            $page->forward(getAppURL("mebhome"));
            break;

        default:
            $page->forward(getAppURL("index"));
            break;
    }
}
```

### Purpose

* Central **project-level configuration**
* Authentication-aware landing routing
* Defines which MasterFile to load per user type

---

## 1.9 `prerun.php` – Pre-App Execution Hook

Executed **before any App is loaded**.

```php
<?php
class SphpPreRun extends Sphp\core\SphpPreRunP {

    public function onstart() {
        /* Create Property rather then use Global variables */
        SphpBase::sphp_api()->addProp('header_bg_height','200');
        /* Create Security Policy and Give permissions to third party URL */
        $policy = SphpBase::sphp_response()->getSecurityPolicy(
            "https://*.googletagmanager.com
             https://*.domain.com
             http://*.domain.com
             https://*.youtube.com
             http://*.youtube.com
             https://*.doubleclick.net
             https://*.openstreetmap.org
             https://cdn.leafletjs.com"
        );
        /* Set custom security policy */
        SphpBase::sphp_response()->addSecurityHeaders($policy);

        // Optional CORS headers
        // SphpBase::sphp_response()->addHttpHeader('Access-Control-Allow-Origin', '*');
    }
}
```

### Purpose

* Security headers (CSP, policies)
* Performance profiling
* Global runtime properties
* Third-party library bootstrapping

---

## 1.10 `reg.php` – App Registration & Auto Resolution

Registers Appgate → App file mappings.

```php
<?php
registerApp("index", __DIR__ . "/apps/index.app");

/**
 * Auto-register App if file exists
 */
if (!SphpBase::sphp_router()->isRegisterCurrentRequest()) {
    $pth = PROJ_PATH . "/apps/" .
           SphpBase::sphp_router()->getCurrentRequest() . ".app";

    if (is_file($pth)) {
        SphpBase::sphp_router()->registerCurrentRequest($pth);
    }
}
```

### Purpose

* Explicit App registration
* Automatic App discovery for small projects
* Prevents missing Appgate errors

---

## 1.11 `start.php` – Framework Bootstrap File

**Single entry point** for browser, CLI, and NativeApp execution.

```php
<?php
$sharedpath   = "./vendor/sartajphp/sartajphp";
$respath      = "./vendor/sartajphp/sartajphp/res";
$slibversion  = "Slib";
$libversion   = "Sphp";
```

### Engine Boot Sequence (Generated Code)

```php
if (!defined("start_path")) {
    define("start_path", __DIR__);
}

$phppath = $sharedpath . "/res";
include_once("{$phppath}/Score/{$libversion}/global/start.php");

$globalapp = startSartajPHPEngine();

if ($globalapp != "") {
    require_once($globalapp);
    SphpBase::engine()->execute(true);
}
```

### Purpose

* Loads SartajPHP core
* Resolves execution mode
* Starts routing and event execution
* No `index.php` is used (intentional)

---

## 1.12 `db.php` – Database Initialization Script

Used during installation or admin tools.

```php
$mysql = SphpBase::dbEngine();
$mysql->connect();

$sql = "CREATE TABLE IF NOT EXISTS ips (
    id INTEGER PRIMARY KEY AUTOINCREMENT,
    submit_timestamp VARCHAR(20) NOT NULL,
    update_timestamp VARCHAR(20) NOT NULL,
    spcmpid VARCHAR(14),
    userid BIGINT NOT NULL,
    parentid BIGINT NOT NULL,
    sltinterface VARCHAR(50) NOT NULL,
    txtip_address VARCHAR(30) NOT NULL,
    txtnetmask VARCHAR(30) NOT NULL,
    txtgateway VARCHAR(30) NOT NULL
)";
$mysql->createTable($sql);
```

### Purpose

* Create required tables
* Insert default data
* Safe re-execution (`IF NOT EXISTS`)

---

## 1.13 `menu.php` & `admmenu.php` – UI Menu Definitions

Menus are **renderer-driven** and permission-aware. Here is example of `menu.php` 
and `master.php` files which handle all Roles (GUEST,MEMBER and ADMIN) type. 

### Menu `menu.php` file Example

```php
/* use bootstrap menu generater file provide by SartajPHP Framework */
include_once(SphpBase::sphp_settings()->slib_path . "/comp/bundle/menu/BootstrapMenu.php"); 
/* Create Class name as same as file name */
class menu extends BootstrapMenu{
    public function onstart() {
        //$this->setNavBarCss("navbar sticky-top navbar-expand-md bg-dark navbar-dark");
        $this->sphp_api->addMenu("Home", "","fa fa-home","root");
        $this->sphp_api->addMenuLink("Home", SphpBase::sphp_settings()->base_path,"fa fa-home","Home");
        $this->sphp_api->addMenuLink("Contact Us", getEventURL('page','contacts','index2'),"fa fa-fw fa-clock-o","Home");
        if(SphpBase::page()->getAuthenticateType() == "GUEST"){
            $this->sphp_api->addMenuLink("Login", getAppURL("signin"),"","Home");
        }else{
            // set menu permissions or login type, as comma separated value
            // not work if app is not using permission system like extend as PermisApp
            $this->sphp_api->addMenu("User",'',"fa fa-home","root",false,"ADMIN,MEMBER");
            $this->sphp_api->addMenuLink("Users",getAppURL('mebProfile'),"fa fa-users","User",false,"mebProfile-view");
            $this->sphp_api->addMenuLink("Profile Permission",getAppURL('mebProfilePermission'),"fa fa-users","User",false,"mebProfilePermission-view");
           // $this->sphp_api->addMenuLink("Profile Permission",getAppURL('mebProfilePermission'),"fa fa-users","User",false,"MEMBER");

            $this->sphp_api->addMenu("Tools",'',"","root",false,"ADMIN");
            $this->sphp_api->addMenuLink("Plugin Install",getAppURL('installer'),"fa fa-users","Tools");
            $this->sphp_api->addMenuLink("DB Install",getEventURL('install','install','mebhome'),"fa fa-users","Tools");
            
            $this->sphp_api->addMenuLink("Dashboard",getAppURL('mebhome'),"fa fa-home","Home");
            $this->sphp_api->addMenuLink("Logout", getEventURL("logout","","signin"),"","Home");
            include_once(PROJ_PATH . "/plugin/cmenu.php"); 
            include_once(PROJ_PATH . "/plugin/cmebmenu.php"); 
            include_once(PROJ_PATH . "/plugin/cadmmenu.php"); 
        }
    }
    
    public function getHeaderSubMenu() {
        return '<div class="dropdown text-end">
          <a href="#" class="d-block link-body-emphasis text-decoration-none dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false">
            <img src="'. SphpBase::sphp_settings()->slib_res_path . "/masters/default/imgs/android-icon-192x192.png" .'" alt="mdo" width="32" height="32" class="rounded-circle">
          </a>
          <ul class="dropdown-menu text-small">
            <li><a class="dropdown-item" href="#">getHeaderSubMenu from menu file</a></li>
            <li><a class="dropdown-item" href="#">for override this</a></li>
            <li><a class="dropdown-item" href="#">Profile</a></li>
            <li><hr class="dropdown-divider"></li>
            <li><a class="dropdown-item" href="#">Sign out</a></li>
          </ul>
        </div>';
    }
}
```

---

## 1.14 Master File `master.php` Example

This Master File use `menu.php` File and generate Final HTML output for Browser.
master file is always a PHP file but we can also add Front Files as 
intermediate file to help master file to use Component Power.
Fremaework methods getHeaderHTML and getFooterHTML gives framework output of JS and CSS inside 
master file layout. we can also include bootstrap as master design level rather then 
App base. So bootstrap and jQuery will be available in whole project. renderFrontPlace function 
render Front Place. Method getAppOutput of SphpBase use to get Application output. 

```php
<?php
/* Add menu.php file as Front Place in section "left" */
addFrontPlace("menu", __DIR__ . "/menu.php", "left");
/* Run Front Place in section "left" before SartajPHP header HTML Output */
runFrontPlace("menu", "left");
?>
<!DOCTYPE html>
<html>

<head lang="en">
    <meta http-equiv="Content-Type" content="text/html; charset=utf8" />
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <?php
        /* Add SartajPHP Managed Bootstrap CSS Library */ 
        SphpBase::SphpJsM()::addBootStrap();
        /* Print All SartajPHP Header generated Required */
        echo SphpBase::sphp_api()->getHeaderHTML();
    ?>
</head>

<body>
    <div class="container-fluid">
        <div class="row">
            <div class="col panel">
                <div class="row">
                    <div class="col">
                        <h2 class="heading" style="font-size:36px;"><?php echo $cmpname; ?></h2>
                    </div>
                </div>
                <div class="row">
                    <div class="col">
                        <?php 
                            /* Print Front Place "menu" Output */ 
                            renderFrontPlace("menu", "left"); 
                        ?>
                    </div>
                </div>
                <div class="row">
                    <div class="col">
                        <?php 
                            /* Print SartajPHP App generated Output with Front File Output */ 
                            SphpBase::getAppOutput(); 
                        ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <?php
        /* Print All SartajPHP Footer generated Required */ 
        echo SphpBase::sphp_api()->getFooterHTML();
        /* Print all errors related output for debug purposes */ 
        echo SphpBase::sphp_api()->traceError(true) . SphpBase::sphp_api()->traceErrorInner(true); 
    ?>
</body>

</html>
```

---

## 1.15 Menu & Cache API Reference (Developer Notes)

### Menu APIs

* `addMenu()`
* `addMenuLink()`
* `banMenu()`
* `banMenuLink()`
* `getMenuList()`
* `getMenuLinkList()`

Menus support:

* Role-based visibility
* AJAX links
* Keyboard shortcuts
* Renderer customization

---

### Cache API

```php
SphpBase::sphp_api()->addCacheList("index", 100);
```

| Cache Type | Meaning                    |
| ---------- | -------------------------- |
| `Appgate`  | Cache all events under App |
| `ce`       | Appgate + event            |
| `cep`      | Appgate + event + evtp     |
| `e`        | Any app event              |

---

### Design Principle

> SartajPHP separates **configuration**, **routing**, **security**, **rendering**, and **logic** into dedicated files.
>
> This keeps Apps small, FrontFiles clean, and execution predictable.

