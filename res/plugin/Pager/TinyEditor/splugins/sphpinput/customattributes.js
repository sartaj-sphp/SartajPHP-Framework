// custom-attributes-plugin.js
function debugm(msg){
    console.log(msg);
}
// custom-attributes-plugin.js
(function () {
    'use strict';
    
    var pluginManager = tinymce.util.Tools.resolve('tinymce.PluginManager');
    
    
    var setupCustomAttributes = function(editor) {
        // Extend the schema to add custom attributes to all elements
        editor.on('PreInit', function() {
            // Add custom attributes to all elements using the valid_elements format
            editor.schema.addValidElements('*[runat|runcb|runas|runtag|action|path]');
            
            // Override getElementRule to add our custom attributes to all elements
            var originalGetElementRule = editor.schema.getElementRule;
            editor.schema.getElementRule = function(name) {
                var rule = originalGetElementRule.call(this, name);
                
                if (rule) {
                    // Add our custom attributes to the existing rule
                    if (!rule.attributes) rule.attributes = {};
                    
                    // Add runat attribute support
                    rule.attributes.runat = {};
                    
                    // Add support for any attribute starting with "fun" (case-sensitive)
                    // We use a wildcard approach to match any fun* attribute
                    rule.attributes['runcb'] = {};
                    rule.attributes['runas'] = {};
                    rule.attributes['runtag'] = {};
                    rule.attributes['action'] = {};
                    rule.attributes['path'] = {};
                }
                
                return rule;
            };
            
        
        });
        
        
    };
    
    // Register plugin
    pluginManager.add('customattributes', function(editor) {
        setupCustomAttributes(editor);
    });
})();