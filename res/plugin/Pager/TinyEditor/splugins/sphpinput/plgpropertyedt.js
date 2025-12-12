// plugin.js
(function () {
    'use strict';
    var pluginManager = tinymce.util.Tools.resolve('tinymce.PluginManager');
    
    const setupSmartPropertyEditor = editor => {
        const tagEditors = {
            'p': ['color'], 'h1': ['color'], 'h2': ['color'], 'h3': ['color'],
            'div': ['color'], 'span': ['color'], 'img': ['image'], 
            'a': ['color'], 'button': ['color']
        };
        
        // Load external JS file
        const loadEditorScript = () => {
            return new Promise((resolve) => {
                if (window.PropertyEditors) return resolve();
                
                const script = document.createElement('script');
                script.src = 'property-editors.js';
                script.onload = resolve;
                document.head.appendChild(script);  
            });
        };
        
        editor.ui.registry.addContextMenu('smartPropertyEditor', {
            update: element => element ? ['editProperties'] : []
        });
        
        editor.ui.registry.addMenuItem('editProperties', {
            text: 'Tag Properties', icon: 'edit-properties',
            onAction: async function() {
                //await loadEditorScript();
                openPropertyEditor(editor.selection.getNode());
            }
        });
        
// plugin.js - Updated openPropertyEditor function
const openPropertyEditor2 = (element) => {
    window.PropertyEditors.currentElement = element;
    const tagName = element.tagName.toLowerCase();
    
    let htmlContent = '<div class="p-3" style="max-height: 70vh; overflow-y: auto;">';
    htmlContent += window.PropertyEditors.initEditors(tagName);
    htmlContent += '</div>';
    
    editor.windowManager.open({
        title: 'Edit Properties - ' + tagName,
        body: { type: 'panel', items: [{ type: 'htmlpanel', html: htmlContent }] },
        buttons: [{ type: 'cancel', text: 'Close' }],
        size: 'medium'
    });    
    
};

const openPropertyEditor = (element) => {
  window["currentElement"] = element;
  const tagName = element.tagName.toLowerCase();

  editor.windowManager.openUrl({
    title: 'Edit Properties - ' + tagName,
    url: './pagefsav-propedit.html?tag=' + tagName, // external HTML file
    buttons: [{ type: 'cancel', text: 'Close' }],
    size: 'large'
  });
};


    };
    
    pluginManager.add('smartpropertyeditor', setupSmartPropertyEditor);
})();