// plugin.js
(function () {
    'use strict';
    var pluginManager = tinymce.util.Tools.resolve('tinymce.PluginManager');
    var currentElement = null;

        // SphpComp Property Editor
    const initSphpCompEditor = () => {
        const element = currentElement;
        const id = element.getAttribute('id') || '';
        const dataSphp = element.getAttribute('data-sphp') || '';
        let html = '<div class="property-editors-container">';

        let properties = {};
        try {
            properties = JSON.parse(decodeURIComponent(dataSphp));
        } catch (e) {
            console.error('Error parsing data-sphp:', e);
        }

        html += `
            <div class="mb-3">
                <label class="form-label small">ID:</label>
                <input type="text" class="form-control form-control-sm" 
                       value="${id}" onkeyup="updateSphpCompId(this.value)">
            </div>
            <div class="mb-3">
                <label class="form-label small">Component Properties:</label>
                <div class="border rounded p-2 bg-light">`;

        // Add property fields
        let type = "text";
        Object.entries(properties).forEach(([key, value]) => {
            type = "text";
            if(value[0] == "num") type = "number";
            html += `
                <div class="mb-2">
                    <label class="form-label small">${key}:</label>`;
            if(value[0] == "select"){
                let a1 = value[2].split(",");
                let options = "";
                $.each(a1,function(i,v1){
                    if(value[1] == v1){
                        options += `<option selcted="selected">${v1}<option>`;                        
                    }else{
                        options += `<option>${v1}<option>`;
                    }
                });
            html += `
                    <select class="form-control form-control-sm" 
                           onchange="updateSphpCompProperty('${key}',$(this).val())">${options}</select>`;                
            }else{
            html += `
                    <input type="${type}" class="form-control form-control-sm" 
                           value="${value[1]}" 
                           onkeyup="updateSphpCompProperty('${key}', this.value)">`;
            }            
            html += `
                </div>`;
        });

        html += `</div></div>`;
         html += '</div>';
        return html;
    };

    window["updateSphpCompId"] = function(value) {
        if (currentElement) {
            currentElement.setAttribute('id', value);
        }
    };

    window["updateSphpCompProperty"] = function(key, value) {
        if (currentElement) {
            // Get current data-sphp
            const dataSphp = currentElement.getAttribute('data-sphp') || '';
            let properties = {};

            try {
                properties = JSON.parse(decodeURIComponent(dataSphp));
            } catch (e) {
                console.error('Error parsing data-sphp:', e);
            }

            // Update the property
            let v1 = properties[key];
            v1[1] = value;
            properties[key] = v1;
            // Set updated data-sphp
            currentElement.setAttribute('data-sphp', 
                encodeURIComponent(JSON.stringify(properties)));
        }
    };

    
    const setupSphpPropertyEditor = editor => {
        editor.on('focusin', function(e) {
                if ($(e.target).attr("runat") === 'server') {
                    currentElement = e.target;
                }
            });
        editor.ui.registry.addContextMenu('sphpPropertyEditor', {
            update: element => {
                return element && $(element).attr("runat") === 'server' ? ['sphpEditProperties'] : [];
            }
        });
        
        editor.ui.registry.addMenuItem('sphpEditProperties', {
            text: 'Comp Properties', icon: 'panel',
            onAction: async function() {
                // not working editor.selection.getNode()
                if(currentElement !== null){
                    openPropertyEditor(currentElement);
                }else if($(editor.selection.getNode()).attr("runat") === 'server'){
                    currentElement = editor.selection.getNode();
                    openPropertyEditor(currentElement);
                }else{
                    alert("Not SartajPhp Component");
                }
            }
        });
        
// plugin.js - Updated openPropertyEditor function
const openPropertyEditor = (element) => {
    const tagName = element.tagName.toLowerCase();
    
    let htmlContent = '<div class="p-3" style="max-height: 70vh; overflow-y: auto;">';
    htmlContent += initSphpCompEditor(tagName);
    htmlContent += '</div>';
    
    editor.windowManager.open({
        title: 'Edit Properties - ' + tagName + ':-' + element.getAttribute("id"),
        body: { type: 'panel', items: [{ type: 'htmlpanel', html: htmlContent }] },
        buttons: [{ type: 'cancel', text: 'Close' }],
        size: 'medium'
    });    
};

    };
    
    pluginManager.add('sphppropertyeditor', setupSphpPropertyEditor);
})();