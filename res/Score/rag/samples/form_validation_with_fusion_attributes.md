# ✅ Sample 2 — Form + Validation + Fusion Attributes

This sample demonstrates:

* `BasicGate` lifecycle
* **Form Component (auto AJAX)**
* **TextField Component**
* **Fusion attributes (`fui-`, `fur-`, `fun-`)**
* **Expression tags**
* **Server-side security & validation**
* **No superglobals**
* **Graceful error handling**

---

## 1️⃣ Application's Gate File

**`apps/register.gate.php`**

```php
<?php
use Sphp\tools\BasicGate;
use Sphp\tools\FrontFile;

class Register extends BasicGate
{
    private $frtMain = null;

    public function onstart()
    {
        // Setup only (no rendering here)
        $this->frtMain = new FrontFile("main");
    }

    /**
     * Default page request
     */
    public function page_new()
    {
        $this->setFrontFile($this->frtMain);
    }

    /**
     * Form submit (AJAX handled by Form Component)
     */
    public function page_event_submitForm($evtp)
    {
        // If no validation / processing error occurred
        if (!getCheckErr()) {

            // Read Component value
            $username = $this->frtMain->username->value;

            // Read non-component value (secured)
            $user_type = $this->Client->post('user_type');

            // Send result to browser
            $this->JSServer->addJSONHTMLBlock([
                "alt1",
                "Form submitted successfully.<br>Username: $username<br>User Type: $user_type"
				]
            );

            // Optional redirect
            // $this->page->forward(getGateURL("signin"));

        } else {

            // Components already displayed validation errors
            $this->JSServer->addJSONHTMLBlock("alt1", "Form submission failed.");

            // Developer debug info (only visible in debug mode)
            $this->debug->println(
                "Registration error for username: " .
                $this->frtMain->getComponent("username")->value
            );
        }
    }
}
```

### ✔ Why this is correct

* Uses **BasicGate shortcuts**

  * `$this->Client` instead of `$_REQUEST`
* No superglobals ❌
* No forced rendering ❌
* Graceful error handling ✅

---

## 2️⃣ FrontFile

**`fronts/register_main.front`**

```html
<title id="title1" runat="server">Register</title>

<h2>User Registration</h2>

Display Form Result Here:
<alert id="alt1" runat="server"></alert>

<form
    id="frmReg"
    runat="server"
    action="##{getEventURL('submitForm')}#"
    fun-setAJAX=""
>

<input type="hidden" name="user_type" value="customer" />

<input
    name="username"
    type="text"
    runat="server"
    fui-setForm="frmReg"
    fui-setMsgName="Username"
    fui-setRequired=""
    fui-setMinLen="3"
/>

<input
    name="email"
    type="email"
    runat="server"
    fui-setForm="frmReg"
    fui-setMsgName="Email"
    fui-setRequired=""
    fui-setEmail=""
/>

<input
    name="password"
    type="password"
    runat="server"
    fui-setForm="frmReg"
    fui-setMsgName="Password"
    fui-setRequired=""
    fui-setMinLen="6"
    fur-setPassword=""
/>

<input type="submit" value="Register" />

</form>
```

### ✔ Why this is correct

* **No JavaScript needed** → Form Component handles AJAX
* `fun-setAJAX` correctly enables AJAX submit
* Validation handled by Components
* Expression tags only where required
* No PHP, no `<html>` / `<body>` tags
* title component placed <title> Tag in Head Tag in output
---

## 3️⃣ Important Concepts Reinforced (For RAG)

### 🔹 BasicGate Shortcuts

| API                        | Shortcut          |
| -------------------------- | ----------------- |
| `SphpBase::JSServer()`     | `$this->JSServer` |
| `SphpBase::sphp_request()` | `$this->Client`   |
| `SphpBase::debug()`        | `$this->debug`    |
| `SphpBase::page()`         | `$this->page`     |

---

### 🔹 Security Model

* ❌ No `$_GET`, `$_POST`, `$_REQUEST`
* ✅ `$this->Client->post()` filters & validates
* Invalid data **never breaks flow**
* Errors shown **inside layout**, not as broken page

---

### 🔹 Error Handling Rule

| Situation          | Behavior                  |
| ------------------ | ------------------------- |
| Validation error   | Component displays error  |
| Logic error        | Gate decides response      |
| Critical PHP error | Stops (PHP limitation)    |
| Debug > 0          | Developer info in console |

---

## 🔒 RAG-Safe Canonical Rules Demonstrated

* FrontFile = **View only**
* Gate = **Event-driven**
* Components = **Self-validating**
* No controller-style request parsing
* No invented APIs
* No lifecycle abuse

