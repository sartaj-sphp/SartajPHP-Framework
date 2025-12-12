(function () {
    'use strict';

    var pluginManager = tinymce.util.Tools.resolve('tinymce.PluginManager');
    var tinyTools = tinymce.util.Tools.resolve('tinymce.util.Tools');
    var tinyDom = tinymce.util.Tools.resolve('tinymce.dom.DOMUtils');

    const addOpenDialog = editor => {
        // Function to find the closest parent with edt-tag class
        const findEdtTagParent = (node) => {
            let current = node;
            while (current) {
                if (current.classList && current.classList.contains('edt-tag')) {
                    return current;
                }
                current = current.parentNode;
                // Stop if we reach the body element
                if (current === editor.getBody() || current.tagName === 'BODY') {
                    break;
                }
            }
            return null;
        };
        
        const json2Attr = (json1) => {
            return encodeURIComponent(JSON.stringify(json1));
        };
        const attr2json = (element) => {
            var jsonData = {};
            if (element.hasAttribute('data-sphp')) {
                try {
                    // Decode and parse the JSON data
                    jsonData = JSON.parse(decodeURIComponent(element.getAttribute('data-sphp')));
                }catch(e){

                }
            }
            return jsonData;
        };
        const processRunAtServer = (htmlString) => {
        // Create a temporary DOM element to parse the HTML
        const tempDiv = document.createElement('div');
        tempDiv.innerHTML = htmlString;

        // Find all elements with runat="server"
        const elementsWithRunAt = tempDiv.querySelectorAll('[runat="server"]');
        //find near form
        const selection = editor.selection;
        const selectedNode = selection.getNode();
        const form1 = $(selectedNode).closest(".frmsphp");

        if (elementsWithRunAt.length > 0) {
            for(let c=0; c<elementsWithRunAt.length;c++){
                if($(elementsWithRunAt[c]).attr("id") === undefined){
            // Open dialog to ask for ID
            var newId = prompt("Please enter name for SartajPhp Component. don't use space", "");
            newId = newId.trim().replaceAll(" ","_");
            if (newId !== null && newId !== "") {
                // Add ID to the first element with runat="server"
                elementsWithRunAt[c].setAttribute("id", newId.trim());
                
                if(["input","select","checkbox"].includes(elementsWithRunAt[c].nodeName.toLowerCase())){
                if(form1 !== null){
                    let d1 = attr2json(elementsWithRunAt[c]);
                    d1["funsetForm"] = ["",$(form1).attr("id")]; 
                    elementsWithRunAt[c].setAttribute("data-sphp",json2Attr(d1));
                }
                }
                }
            }
        }

            // Return the modified HTML
            insertBlockContent(tempDiv.innerHTML);
        }else{

        // Return original HTML if no runat="server" elements found
        insertBlockContent(htmlString);
        }
    };
    
 // Function to insert content at the right location
        const insertBlockContent = (content) => {
            const selection = editor.selection;
            const selectedNode = selection.getNode();
            
            // Find the closest edt-tag parent
            const edtTagParent = findEdtTagParent(selectedNode);
            
            if (edtTagParent) {
                // Insert inside the edt-tag element
                $(edtTagParent).append(content);
            } else {
                // If no edt-tag found, insert at cursor position
                editor.insertContent(content);
                
                // Show notification
                /*
                editor.notificationManager.open({
                    text: 'No .edt-tag parent found. Content inserted at cursor position.',
                    type: 'warning',
                    timeout: 3000
                });
                 * 
                 */
            }
        };        
        // Define all blocks in an associative array
        const arrBlocks = {
            "Cards": {
                "Simple Card": '<div class="card"><div class="card-body edt-tag">Simple card content</div></div>',
                "Card with Header": '<div class="card"><div class="card-header">Card Header</div><div class="card-body edt-tag"><h5 class="card-title">Card title</h5><p class="card-text">Card content goes here.</p></div></div>',
                "Full Card": '<div class="card"><div class="card-header">Featured</div><div class="card-body edt-tag"><h5 class="card-title">Special title treatment</h5><p class="card-text">With supporting text below as a natural lead-in to additional content.</p><a href="#" class="btn btn-primary">Go somewhere</a></div><div class="card-footer text-muted">2 days ago</div></div>'
            },
            "Form": {
            "Form Panel": '<div runtag="form" class="form frmsphp mt-3 mb-3 edt-tag" action="pagefrm.html" runat="server"><div class="card"><div class="card-body edt-tag">Simple  content</div></div></div>',
            "Text Input": '<div class="row mb-3"><label class="col-sm-3 col-form-label">Input Label</label><div class="col-sm-9"><input runat="server" data-sphp="'+ json2Attr({funsetMaxLen: ["num",40], funsetMinLen: ["num",1], funsetRequired: ["select","","--select--,Yes"], placeholder: ["","type"]}) +'" type="text" class="form-control"></div></div>',
            "Email Input": '<div class="row mb-3"><label class="col-sm-3 col-form-label">Email Address</label><div class="col-sm-9"><input runat="server" data-sphp="'+ json2Attr({funsetMaxLen: ["num",40], funsetMinLen: ["num",1], funsetRequired: ["select","","--select--,Yes"], placeholder: ["","name@example.com"]}) +'" type="email" class="form-control" ></div></div>',
            "Password Input": '<div class="row mb-3"><label class="col-sm-3 col-form-label">Password</label><div class="col-sm-9"><input runat="server" data-sphp="'+ json2Attr({funsetMaxLen: ["num",40], funsetMinLen: ["num",1], funsetRequired: ["select","","--select--,Yes"], placeholder: ["","Enter password"]}) +'" type="password" class="form-control" ></div></div>',
            "Textarea": '<div class="row mb-3"><label class="col-sm-3 col-form-label">Message</label><div class="col-sm-9"><div runtag="textarea" runat="server" data-sphp="'+ json2Attr({funsetMaxLen: ["num",40], funsetMinLen: ["num",1], funsetRequired: ["select","","--select--,Yes"], placeholder: ["","Your message"]}) +'" class="form-control" rows="3" ></div></div></div>',
            "Select": '<div class="row mb-3"><label class="col-sm-3 col-form-label">Select Option</label><div class="col-sm-9"><select runat="server" data-sphp="'+ json2Attr({funsetOptions: ["","Apple,Orange,Banana"] }) +'" class="form-select"></select></div></div>',
            "Checkbox": '<div class="row mb-3"><div class="col-sm-9 offset-sm-3"><div class="form-check"><input runat="server" data-sphp="'+ json2Attr({value: ["","Yes"] }) +'" class="form-check-input" type="checkbox"><label class="form-check-label">Default checkbox</label></div></div></div>',
            "Radio Buttons": '<div class="row mb-3"><div class="col-sm-9 offset-sm-3"><div class="form-check"><input runat="server" data-sphp="'+ json2Attr({value: ["","Yes"] }) +'" class="form-check-input" type="radio"><label class="form-check-label">Default radio</label></div></div></div>',
            "File Input": '<div class="row mb-3"><label class="col-sm-3 col-form-label">File Input</label><div class="col-sm-9"><input runat="server" data-sphp="'+ json2Attr({fuisetFileTypesAllowed: ["","image/pjpeg,image/jpeg,image/gif,image/png"], funsetMsgName: ["",""], fuisetFileMaxLen: ["num","800000000"], fuisetFileSavePath: ["","tiny_editor_imgs/<?php echo $tempobj->file1->getValue(); ?>"] }) +'" class="form-control" type="file"></div></div>',
            "Range Input": '<div class="row mb-3"><label class="col-sm-3 col-form-label">Range Input</label><div class="col-sm-9"><input type="range" class="form-range" id="customRange1"></div></div>',
            "Submit Button": '<div class="row mb-3"><div class="col-sm-9 offset-sm-3"><button type="submit" class="btn btn-primary">Submit</button></div></div>'
            }, 
            "Action":{
                "Emailer": '<div id="divemailer1" path="myplugpath/emailer.php" runat="server" class="row mb-3" ><label class="col-sm-3 col-form-label">Email Format</label><div class="col-sm-9"><p runat="server" data-comp="divemailer1" data-sphp="'+ json2Attr({Subject: ["","Query"], ToName: ["",""], ToEmail: ["",""]}) +'"  class="form-control" >Hi,</p></div></div>'
            },
            "Images": {
                "Image with Top Text": '<figure class="figure"><img src="cta-bg.jpg" class="figure-img img-fluid rounded" alt="..."><figcaption class="figure-caption">A caption for the above image.</figcaption></figure>',
                "Image with Bottom Text": '<figure class="figure"><img src="cta-bg.jpg" class="figure-img img-fluid rounded" alt="..."><figcaption class="figure-caption text-end">A caption for the above image.</figcaption></figure>',
                "Image Left Aligned": '<div class="clearfix"><img src="cta-bg.jpg" class="col-md-6 float-md-start mb-3 ms-md-3 img-fluid" alt="..."><p>Paragraph of text to the right of the image. You can add more content here to see how it wraps around the image.</p></div>',
                "Image Right Aligned": '<div class="clearfix"><img src="cta-bg.jpg" class="col-md-6 float-md-end mb-3 ms-md-3 img-fluid" alt="..."><p>Paragraph of text to the left of the image. You can add more content here to see how it wraps around the image.</p></div>'
            },
            "Layout": {
                "Two Column Grid": '<div class="container"><div class="row"><div class="col-md-6 edt-tag"><p>Left column content</p></div><div class="col-md-6 edt-tag"><p>Right column content</p></div></div></div>',
                "Three Column Grid": '<div class="container"><div class="row"><div class="col-md-4 edt-tag"><p>First column content</p></div><div class="col-md-4 edt-tag"><p>Second column content</p></div><div class="col-md-4 edt-tag"><p>Third column content</p></div></div></div>',
                "Jumbotron": '<div class="p-5 mb-4 bg-light rounded-3"><div class="container-fluid py-5"><h1 class="display-5 fw-bold">Custom jumbotron</h1><p class="col-md-8 fs-4">Using a series of utilities, you can create this jumbotron, just like the one in previous versions of Bootstrap. Check out the examples below for how you can remix and restyle it to your liking.</p><button class="btn btn-primary btn-lg" type="button">Example button</button></div></div>',
                "Card Grid": '<div class="row row-cols-1 row-cols-md-3 g-4"><div class="col"><div class="card h-100"><div class="card-body edt-tag"><h5 class="card-title">Card title</h5><p class="card-text">This is a wider card with supporting text below as a natural lead-in to additional content.</p></div><div class="card-footer"><small class="text-muted">Last updated 3 mins ago</small></div></div></div><div class="col edt-tag"><div class="card h-100"><div class="card-body edt-tag"><h5 class="card-title">Card title</h5><p class="card-text">This card has supporting text below as a natural lead-in to additional content.</p></div><div class="card-footer"><small class="text-muted">Last updated 3 mins ago</small></div></div></div><div class="col edt-tag"><div class="card h-100"><div class="card-body edt-tag"><h5 class="card-title">Card title</h5><p class="card-text">This is a wider card with supporting text below as a natural lead-in to additional content.</p></div><div class="card-footer"><small class="text-muted">Last updated 3 mins ago</small></div></div></div></div>'
            },
            "Paragraphs": {
                "Lead Paragraph": '<p class="lead">This is a lead paragraph. It stands out from regular paragraphs.</p>',
                "Blockquote": '<figure><blockquote class="blockquote edt-tag"><p>A well-known quote, contained in a blockquote element.</p></blockquote><figcaption class="blockquote-footer">Someone famous in <cite title="Source Title">Source Title</cite></figcaption></figure>',
                "Text Center": '<p class="text-center">This text is centered.</p>',
                "Text Muted": '<p class="text-muted">This text is muted.</p>'
            },
            "Components": {
                "Alert": '<div class="alert alert-primary edt-tag" role="alert">A simple primary alert—check it out!</div>',
                "Badge": '<h3>Example heading <span class="badge bg-secondary">New</span></h3>',
                "Button Group": '<div class="btn-group" role="group" aria-label="Basic example"><button type="button" class="btn btn-primary">Left</button><button type="button" class="btn btn-primary">Middle</button><button type="button" class="btn btn-primary">Right</button></div>',
                "Progress Bar": '<div class="progress"><div class="progress-bar" role="progressbar" style="width: 25%;" aria-valuenow="25" aria-valuemin="0" aria-valuemax="100">25%</div></div>'
            }
        };

        // Main Blocks menu button with nested submenus
        editor.ui.registry.addMenuButton('blocks', {
            text: 'Bootstrap Blocks',
            fetch: function (callback) {
                const menuItems = [];
                
                // Iterate through each category
                for (const [category, items] of Object.entries(arrBlocks)) {
                    menuItems.push({
                        type: 'nestedmenuitem',
                        text: category,
                        getSubmenuItems: function () {
                            const submenuItems = [];
                            
                            // Iterate through each item in the category
                            for (const [itemName, itemContent] of Object.entries(items)) {
                                submenuItems.push({
                                    type: 'menuitem',
                                    text: itemName,
                                    onAction: function () {
                                        processRunAtServer(itemContent);
                                    }
                                });
                            }
                            
                            return submenuItems;
                        }
                    });
                    
                    // Add separator between categories except after the last one
                    if (category !== Object.keys(arrBlocks)[Object.keys(arrBlocks).length - 1]) {
                        menuItems.push({ type: 'separator' });
                    }
                }
                
                callback(menuItems);
            }
        });
    };

    var Plugin = () => {
        pluginManager.add('bootstrapblocks', function(editor) {
            addOpenDialog(editor);
        });
    };
    
    Plugin();
})();