Steps to convert any online webpage into Master File:- 
Master File provide design for SartajPHP App in which Front File output is displayed according to css,js libraries load in Master File. 
Here is easy way to convert any webpage into Master File of SartajPHP.
1. Identify HTML which is project wide not page wide and then copy all those HTML code into Master File.
2. Identify HTML layout and mark dynamic content, menu, footer menu and other dynamic places.
3. Copy paste dynamic content into Front File as Home Page as example index_main.front file. 
4. Convert all other dynamic Places as Front Places as PHP Class Files or Front Files.
5. Later convert few tags to Component to make reusability and Powerfull. 
6. Copy paste resources links into folder and make relative URL to master or use cdn links if possible.
7. cdn links need to setup permissions into prerun.php file

Convert the **STAX WordPress theme** into a **SartajPHP Master File**. Let's follow 7-step method.

### 🧱 Step 1: Identify Project-Wide HTML
From the STAX site, the project-wide elements that belong in your `master.php` are the fundamental page structure and assets.
*   **HTML Framework**: `<!DOCTYPE html>`, `<html>`, `<head>`, `<body>` tags.
*   **Global Meta Tags**: The viewport meta tag for responsive design.
*   **Global Assets**: Links to CSS frameworks (like Bootstrap for layout) and any site-wide JavaScript libraries. You'll use SartajPHP's `SphpBase::SphpJsM()::addBootStrap()` to load Bootstrap.
*   **Global Containers**: The outermost layout containers (like `.container-fluid` and `.row` classes) that appear on every page.

### 🎯 Step 2: Identify & Mark Dynamic Content Places
Looking at the STAX layout, we can identify these key dynamic areas:
*   **Primary Dynamic Area**: The large central hero section ("The Future of WordPress Is Here") and the content blocks below it. This is the **main content** that changes per page.
*   **Header/Navigation**: The site header and main menu (not explicitly detailed in the text but implied).
*   **Footer Area**: The site footer with menus and information.

In your `master.php`, you will replace these dynamic areas with SartajPHP Front Places.

### 🔄 Step 3: Create the Front File for Page Content
The unique content for the homepage (hero, feature blocks, testimonials, FAQ) goes into a Front File, for example, `index_main.front`.

**Example `apps/fronts/index_main.front`:**
```html
<!-- This content replaces the main dynamic area -->
<section class="hero">
    <h1>The Future of WordPress Is Here.</h1>
    <p>STAX is a WordPress block theme for the Full Site Editor...</p>
</section>

<section class="features">
    <h2>Block Theme Goodness</h2>
    <p>STAX is a block-based WordPress theme...</p>
    <!-- More content from the STAX page -->
</section>

<!-- WooCommerce products could be a Component -->
<div id="wooProducts" runat="server" path="slibpath/comp/server/ForEachLoop.php" fun-setObject="products">
    <div class="product">
        <h4>##{$wooProducts->getItem('name')}##</h4>
        <p>##{$wooProducts->getItem('price')}##</p>
    </div>
</div>
```

### ⚙️ Step 4 & 5: Create Front Places & Components
Dynamic sections like the **header menu**, **footer**, and **WooCommerce product list** are perfect candidates for Front Places or Components.

*   **Header & Footer**: Create as **Front Places** (e.g., `header.php`, `footer.php`) since they are global layout components. You would `addFrontPlace()` and `renderFrontPlace()` them in `master.php`.
*   **Reusable Blocks**: Elements like the **Testimonial Slider**, **FAQ Accordion**, or **Product Grid** should be created as powerful **Components**. This makes them reusable across different Front Files.

**Example `Header` Front Place (`masters/default/header.php`):**
```php
<?php
namespace masters\default;

use Sphp\tools\FrontPlace;


class header extends FrontPlace {
    public function _run() {
        // Add any specific CSS/JS for the header
        $this->addFileLink("/assets/css/header.css", "css");
    }
    public function render() {
        echo '<header class="site-header"><nav>... Main Menu Here ...</nav></header>';
    }
}
?>
```

### 📁 Step 6 & 7: Handle Resources and CDN Links
1.  **Local Assets**: Download the STAX theme's CSS/JS/Images. Place them in your project's `/assets/` folder and use relative paths.
2.  **CDN Links**: For common libraries (like Font Awesome icons used in STAX), use CDN links.
3.  **CDN Permissions**: Add the CDN domains to your `prerun.php` file to allow resource loading.

**Example `prerun.php` snippet:**
```php
<?php
// Allow resources from common CDNs
header("Content-Security-Policy: script-src 'self' https://cdnjs.cloudflare.com https://fonts.googleapis.com; style-src 'self' 'unsafe-inline' https://cdnjs.cloudflare.com https://fonts.googleapis.com;");
?>
```

### 📄 The Resulting Master File Structure
Here is a conceptual outline of your resulting `masters/default/master.php`:

```php
<?php
// masters/default/master.php
addFrontPlace("siteHeader", __DIR__ . "/header.php", "top");
addFrontPlace("siteFooter", __DIR__ . "/footer.php", "bottom");
runFrontPlace("siteHeader", "top");
runFrontPlace("siteFooter", "bottom");
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo $cmpname; ?> | STAX Inspired</title>
    <?php
        // Load Bootstrap via Framework
        SphpBase::SphpJsM()::addBootStrap();
        // Load STAX theme's main style
        echo '<link rel="stylesheet" href="/assets/css/stax-style.css">';
        // Load Font Awesome via CDN for icons
        echo '<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">';
        echo SphpBase::sphp_api()->getHeaderHTML();
    ?>
</head>
<body>
    <?php renderFrontPlace("siteHeader", "top"); ?>

    <main class="main-content container-fluid">
        <!-- The App's Front File output injects here -->
        <?php SphpBase::getAppOutput(); ?>
    </main>

    <?php renderFrontPlace("siteFooter", "bottom"); ?>

    <?php
        // Framework JS and custom scripts
        echo SphpBase::sphp_api()->getFooterHTML();
        echo '<script src="/assets/js/stax-scripts.js"></script>';
        echo SphpBase::sphp_api()->traceError(true);
    ?>
</body>
</html>
```

### ✅ Summary and Next Steps
You've successfully deconstructed the STAX theme. The **static shell** is in `master.php`, the **homepage content** is in `index_main.front`, and **reusable global parts** are in Front Places/Components.

To move forward:
1.  **Build the Components**: Start creating the Testimonial or Portfolio components you identified.
2.  **Populate with Data**: Your BasicApp (`index.app`) will fetch data (like products, posts) and pass it to the Front File and Components using `$frontobj->set()`.
3.  **Style Refinement**: Ensure your local `stax-style.css` matches the original design.


