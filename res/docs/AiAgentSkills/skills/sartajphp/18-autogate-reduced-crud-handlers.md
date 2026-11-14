# AutoGate and AutoGatePermis

Teach an AI when to **extend AutoGate** to reuse stock list/edit/AJAX handlers instead of rewriting them. Demo: `ex18auto`. Sources under `vendor/sartajphp/sartajphp/res/Slib/apps/helper/`.

## When to use

- DB table + list Front + edit Front with the usual AJAX dialog/holder flow  
- Want built-in `rowclick`, `showall_show`, `page_submit` → insert/update, search hooks  

**Not** for: one-off pages, custom APIs, or “generate my whole app from SQL” (that is optional tooling — `AiInfo` / `GenAppFromDb` — not required for agents to code Gates).

## Mental model

`AutoGate` extends `BasicGate` and implements common PageEvents. Your subclass sets table + two FrontFiles and calls `parent::onstart()`. `AutoGatePermis` adds `hasPermission` style checks around the same flow.

## Develop

```php
include_once(SphpBase::sphpSettings()->slibPath . '/apps/helper/AutoGate.php');

class Ex18auto extends AutoGate
{
    public function onstart()
    {
        global $masterf;
        $this->setTableName('ex17_doc');
        $this->formid = 'form2';
        $this->showallFront = new \Sphp\Tools\FrontFile('list');
        $this->genFormFront = new \Sphp\Tools\FrontFile('edit');
        $this->setMasterFile($masterf);
        parent::onstart();
    }
}
```

Front expectations (from AutoGate):

| Piece | Requirement |
|-------|-------------|
| List | Pagination Component `id="showall"` |
| Edit | HTMLForm `id="form2"` (or `$this->formid`) |
| Delete control | Component `btnDel` (AutoGate toggles render) |
| AJAX target | `#showall_editor` (and often a jQuery UI dialog `#showall_dlg`) |

Stock events include `page_event_rowclick` (`viewData` + `addJsonFront`), `page_event_showall_show`, `page_submit` → `insert`/`update`, `page_event_addform`, etc. Override only what you need.

## Run / test

```bat
sphpdesk\sphpserver\sphpserver-win.exe --proj .\ --port 8000 --host 127.0.0.1
```

Open `/ex18auto.html` after `/ex17comps-install.html` (shared `ex17_doc` table). Verified 2026-10-26: list HTML loads.

## Related

- Manual CRUD: [10](10-database-communication-in-gate.md), [17](17-builtin-form-and-data-components.md)  
- Permissions: [09](09-permissions-and-authentication.md) · use `AutoGatePermis` when roles matter  
- Ebook: [ebook2](https://www.sartajphp.com/ebook2-fullbook.html)  
