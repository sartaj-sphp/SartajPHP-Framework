/**
 * TinyMCE version 6.4.1 (2023-03-29)
 */

(function () {
    'use strict';

    var pluginManager = tinymce.util.Tools.resolve('tinymce.PluginManager');
    var tinyTools = tinymce.util.Tools.resolve('tinymce.util.Tools');
    const isNullable = a => a === null || a === undefined;
    const isNonNullable = a => !isNullable(a);
    const isCustomList = list => /\btox\-/.test(list.className);
    const isChildOfBody = (editor, elm) => {
        return editor.dom.isChildOf(elm, editor.getBody());
    };
    const matchNodeNames = regex => node => isNonNullable(node) && regex.test(node.nodeName);
    const isListNode = matchNodeNames(/^(OL|UL|DL)$/);
    const isTableCellNode = matchNodeNames(/^(TH|TD)$/);
    const inList = (editor, parents, nodeName) => findUntil(parents, parent => isListNode(parent) && !isCustomList(parent), isTableCellNode).exists(list => list.nodeName === nodeName && isChildOfBody(editor, list));
    const getSelectedStyleType = editor => {
        const listElm = editor.dom.getParent(editor.selection.getNode(), 'ol,ul');
        const style = editor.dom.getStyle(listElm, 'listStyleType');
        return Optional.from(style);
    };
    const isWithinNonEditable = (editor, element) => element !== null && !editor.dom.isEditable(element);
    const isWithinNonEditableList = (editor, element) => {
        const parentList = editor.dom.getParent(element, 'ol,ul,dl');
        return isWithinNonEditable(editor, parentList);
    };
    const styleValueToText = styleValue => {
        return styleValue.replace(/\-/g, ' ').replace(/\b\w/g, chr => {
            return chr.toUpperCase();
        });
    };
    const normalizeStyleValue = styleValue => isNullable(styleValue) || styleValue === 'default' ? '' : styleValue;
    const makeSetupHandler = (editor, nodeName) => api => {
            const nodeChangeHandler = e => {
                api.setActive(inList(editor, e.parents, nodeName));
                api.setEnabled(!isWithinNonEditableList(editor, e.element));
            };
            editor.on('NodeChange', nodeChangeHandler);
            return () => editor.off('NodeChange', nodeChangeHandler);
        };

    const addOpenDialog = editor => {
        const openDialog = () => editor.windowManager.open({
                title: 'Sphp TextBox',
                body: {
                    type: 'panel',
                    items: [
                        {
                            type: 'input',
                            name: 'title',
                            label: 'Title'
                        }
                    ]
                },
                buttons: [
                    {
                        type: 'cancel',
                        text: 'Close'
                    },
                    {
                        type: 'submit',
                        text: 'Save',
                        buttonType: 'primary'
                    }
                ],
                onSubmit: (api) => {
                    const data = api.getData();
                    /* Insert content when the window form is submitted */
                    editor.insertContent('<input id="' + data.title + '" runat="server" value="" placeholder="' + data.title + '">');
                    api.close();
                }
            });
        /* Add a button that opens a window */
        editor.ui.registry.addButton('sphpinput1', {
            text: 'TextBox1',
            onAction: () => {
                /* Open window */
                openDialog();
            }
        });
        editor.ui.registry.addButton('panel', {
            text: 'Panel',
            onAction: () => {
                editor.insertContent('<div class="card"><div class="card-header">Title</div><div class="card-body">content here</div><div class="card-footer">footer</div></div>');
            },
             onPostRender: function() {
                var ctrl = this;
                    console.log("d");
                editor.on('NodeChange', function(e) {
                    console.log(e.element);
                    ctrl.active(
                        e.element.className.indexOf('inline-code-highlight') !== -1
                    );
                });
            }
        });
        /* Adds a menu item, which can then be included in any menu via the menu/menubar configuration */
        editor.ui.registry.addMenuItem('sphpinput', {
            text: 'TextBox1',
            onAction: () => {
                /* Open window */
                openDialog();
            }
        });
       
 editor.ui.registry.addMenu('cb', {
      text: 'Blocks',
      fetch: function(callback) {
        var items = [
          {
            type: 'menuitem',
            text: 'Insert Card',
            onAction: function() {
              editor.insertContent('<div class="card">Card content</div>');
            }
          },
          {
            type: 'menuitem',
            text: 'Insert Alert',
            onAction: function() {
              editor.insertContent('<div class="alert">Alert message</div>');
            }
          }
        ];
        callback(items);
      }
    });
    
        
    };

    var Plugin = () => {
        pluginManager.add('sphpinput', (editor,url) => {
            //if (editor.hasPlugin('lists')) {
                addOpenDialog(editor);
                //register$1(editor);
                //register(editor);
                //register$2(editor);
            //} else {
                //console.error('Please use the Lists plugin together with the Advanced List plugin.');
            //}
        });
    };
    
    
//demo code start, not use
    const addSplitButton = (editor, id, tooltip, cmd, nodeName, styles) => {
        editor.ui.registry.addSplitButton(id, {
            tooltip,
            icon: nodeName === 'OL' ? 'ordered-list' : 'unordered-list',
            presets: 'listpreview',
            columns: 3,
            fetch: callback => {
                const items = tinyTools.map(styles, styleValue => {
                    const iconStyle = nodeName === 'OL' ? 'num' : 'bull';
                    const iconName = styleValue === 'disc' || styleValue === 'decimal' ? 'default' : styleValue;
                    const itemValue = normalizeStyleValue(styleValue);
                    const displayText = styleValueToText(styleValue);
                    return {
                        type: 'choiceitem',
                        value: itemValue,
                        icon: 'list-' + iconStyle + '-' + iconName,
                        text: displayText
                    };
                });
                callback(items);
            },
            onAction: () => editor.execCommand(cmd),
            onItemAction: (_splitButtonApi, value) => {
                applyListFormat(editor, nodeName, value);
            },
            select: value => {
                const listStyleType = getSelectedStyleType(editor);
                return listStyleType.map(listStyle => value === listStyle).getOr(false);
            },
            onSetup: makeSetupHandler(editor, nodeName)
        });
    };
    
    const addButton = (editor, id, tooltip, cmd, nodeName, styleValue) => {
        editor.ui.registry.addToggleButton(id, {
            active: false,
            tooltip,
            icon: nodeName === 'OL' ? 'ordered-list' : 'unordered-list',
            onSetup: makeSetupHandler(editor, nodeName),
            onAction: () => editor.queryCommandState(cmd) || styleValue === '' ? editor.execCommand(cmd) : applyListFormat(editor, nodeName, styleValue)
        });
    };
    const addControl = (editor, id, tooltip, cmd, nodeName, styles) => {
        if (styles.length > 1) {
            addSplitButton(editor, id, tooltip, cmd, nodeName, styles);
        } else {
            addButton(editor, id, tooltip, cmd, nodeName, normalizeStyleValue(styles[0]));
        }
    };
    const register = editor => {
        addControl(editor, 'numlist', 'Numbered list', 'InsertOrderedList', 'OL', getNumberStyles(editor));
        addControl(editor, 'bullist', 'Bullet list', 'InsertUnorderedList', 'UL', getBulletStyles(editor));
    };

//demo code end
    Plugin();

})();
