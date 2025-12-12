(function () {
    'use strict';

    var pluginManager = tinymce.util.Tools.resolve('tinymce.PluginManager');

    var ImageEditor = function (editor) {
        this.editor = editor;
    };

    ImageEditor.prototype.openDialog = function () {
        var editor = this.editor;
        var selectedNode = editor.selection.getNode();
        var currentSrc = '';
        var currentAlt = '';
        var currentTitle = '';
        var currentWidth = '';
        var currentHeight = '';
        var isResponsive = true;
        var borderSize = 0;
        var borderColorClass = '';
        var styleClass = '';
        var alignClass = '';
        var marginClass = '';
        var aspectRatio = 0;
        var isNewImg = 0;

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
        // Check if an image is selected
        if (selectedNode.nodeName !== 'IMG') {
            const edtTagParent = findEdtTagParent(selectedNode);
            const imgtag = $('<img src="" title="..." alt="..." class="img img-fluid" />');
            if (edtTagParent) {
                selectedNode = imgtag[0];
                // Insert inside the edt-tag element
                $(edtTagParent).append(imgtag);
            } else {
                // If no edt-tag found, insert at cursor position
                editor.insertContent(imgtag[0].outerHTML);
            }

            //editor.windowManager.alert('Please select an image to edit.');
            //return;
            isNewImg = 1;
        } else {
            isNewImg = 1;

            // Get current image properties
            currentSrc = selectedNode.src || '';
            currentAlt = selectedNode.alt || '';
            currentTitle = selectedNode.title || '';
            currentWidth = selectedNode.width || '';
            currentHeight = selectedNode.height || '';

            // Check for responsive class
            isResponsive = selectedNode.classList.contains('img-fluid');

            // Get border properties
            var borderStyle = window.getComputedStyle(selectedNode).borderWidth;
            if (borderStyle && borderStyle !== '0px') {
                borderSize = parseInt(borderStyle) || 0;
            }

            // Get border color class
            var borderClasses = ['border-primary', 'border-secondary', 'border-success', 'border-danger',
                'border-warning', 'border-info', 'border-light', 'border-dark', 'border-white'];
            for (var i = 0; i < selectedNode.classList.length; i++) {
                var className = selectedNode.classList[i];
                if (borderClasses.includes(className)) {
                    borderColorClass = className;
                    break;
                }
            }

            // Get style class
            var styleClasses = ['rounded', 'rounded-top', 'rounded-end', 'rounded-bottom',
                'rounded-start', 'rounded-circle', 'rounded-pill', 'img-thumbnail'];
            for (var i = 0; i < selectedNode.classList.length; i++) {
                var className = selectedNode.classList[i];
                if (styleClasses.includes(className)) {
                    styleClass = className;
                    break;
                }
            }

            // Get alignment class
            var alignClasses = ['float-start', 'mx-auto', 'd-block', 'float-end'];
            for (var i = 0; i < selectedNode.classList.length; i++) {
                var className = selectedNode.classList[i];
                if (alignClasses.includes(className)) {
                    if (className === 'mx-auto' && selectedNode.classList.contains('d-block')) {
                        alignClass = 'mx-auto d-block';
                    } else {
                        alignClass = className;
                    }
                    break;
                }
            }

            // Get margin class
            var marginClasses = ['m-0', 'm-1', 'm-2', 'm-3', 'm-4', 'm-5', 'm-auto'];
            for (var i = 0; i < selectedNode.classList.length; i++) {
                var className = selectedNode.classList[i];
                if (marginClasses.includes(className)) {
                    marginClass = className;
                    break;
                }
            }

            // Calculate aspect ratio
            if (currentWidth > 0 && currentHeight > 0) {
                aspectRatio = currentWidth / currentHeight;
            }
        }

        // Prepare data to send to iframe
        var imageData = {
            src: currentSrc,
            alt: currentAlt,
            title: currentTitle,
            width: currentWidth,
            height: currentHeight,
            borderSize: borderSize,
            borderColorClass: borderColorClass,
            styleClass: styleClass,
            alignClass: alignClass,
            marginClass: marginClass,
            isResponsive: isResponsive,
            aspectRatio: aspectRatio
        };

        // Create a unique ID for this dialog instance
        var dialogId = 'image-editor-' + new Date().getTime();

        // Open dialog with iframe
        var dialog = editor.windowManager.open({
            title: 'Edit Image',
            body: {
                type: 'panel',
                items: [{
                        type: 'htmlpanel',
                        html: '<iframe src="pageplg-imgedt.html?insert=' + isNewImg + '" style="border: none;width:100%;height:600px;" id="' + dialogId + '-iframe"></iframe>'
                    }]
            },
            buttons: [
                {
                    type: 'cancel',
                    text: 'Cancel',
                    name: 'cancel'
                },
                {
                    type: 'submit',
                    text: 'Save',
                    primary: true,
                    name: 'save'
                }
            ],
            initialData: {},
            onSubmit: function (api) {
                // Get the iframe
                var iframe = document.getElementById(dialogId + '-iframe');

                // Request data from iframe
                iframe.contentWindow.postMessage({
                    action: 'getFormData',
                    dialogId: dialogId
                }, '*');

                // Listen for response from iframe
                var messageHandler = function (event) {
                    if (event.data.action === 'formData' && event.data.dialogId === dialogId) {
                        window.removeEventListener('message', messageHandler);

                        var formData = event.data;

                        // Update the image in the editor
                        editor.undoManager.transact(function () {
                            // Set basic attributes
                            editor.dom.setAttrib(selectedNode, 'src', formData.src);
                            editor.dom.setAttrib(selectedNode, 'alt', formData.alt);

                            // Set dimensions - remove if 0 or responsive
                            if (formData.width > 0 && !formData.isResponsive) {
                                editor.dom.setAttrib(selectedNode, 'width', formData.width);
                            } else {
                                editor.dom.setAttrib(selectedNode, 'width', null);
                            }

                            if (formData.height > 0 && !formData.isResponsive) {
                                editor.dom.setAttrib(selectedNode, 'height', formData.height);
                            } else {
                                editor.dom.setAttrib(selectedNode, 'height', null);
                            }

                            // Remove all classes first
                            var classesToRemove = [
                                'img-fluid', 'rounded', 'rounded-top', 'rounded-end', 'rounded-bottom',
                                'rounded-start', 'rounded-circle', 'rounded-pill', 'img-thumbnail',
                                'float-start', 'float-end', 'mx-auto', 'd-block',
                                'm-0', 'm-1', 'm-2', 'm-3', 'm-4', 'm-5', 'm-auto',
                                'border-primary', 'border-secondary', 'border-success', 'border-danger',
                                'border-warning', 'border-info', 'border-light', 'border-dark', 'border-white'
                            ];

                            classesToRemove.forEach(function (className) {
                                editor.dom.removeClass(selectedNode, className);
                            });

                            // Add responsive class if needed
                            if (formData.isResponsive) {
                                editor.dom.addClass(selectedNode, 'img-fluid');
                            }

                            // Add border color class if needed
                            if (formData.borderColorClass) {
                                editor.dom.addClass(selectedNode, formData.borderColorClass);
                            }

                            // Add style class if needed
                            if (formData.styleClass) {
                                editor.dom.addClass(selectedNode, formData.styleClass);
                            }

                            // Add alignment class if needed
                            if (formData.alignClass) {
                                if (formData.alignClass === 'mx-auto d-block') {
                                    editor.dom.addClass(selectedNode, 'mx-auto');
                                    editor.dom.addClass(selectedNode, 'd-block');
                                } else {
                                    editor.dom.addClass(selectedNode, formData.alignClass);
                                }
                            }

                            // Add margin class if needed
                            if (formData.marginClass) {
                                editor.dom.addClass(selectedNode, formData.marginClass);
                            }

                            // Set border size
                            if (formData.borderSize > 0) {
                                editor.dom.setStyle(selectedNode, 'border', formData.borderSize + 'px solid');
                            } else {
                                editor.dom.setStyle(selectedNode, 'border', '');
                            }
                        });

                        api.close();
                    }
                };

                window.addEventListener('message', messageHandler);
            }
        });

        // Send data to iframe after it loads
        var iframe = document.getElementById(dialogId + '-iframe');
        iframe.onload = function () {
            iframe.contentWindow.postMessage({
                action: 'init',
                imageData: imageData,
                dialogId: dialogId
            }, '*');
        };
    };

    // Register plugin
    var Plugin = function (editor) {
        var imageEditor = new ImageEditor(editor);

        // Add toolbar button
        editor.ui.registry.addButton('imageeditor', {
            icon: 'image',
            tooltip: 'Edit Image',
            onAction: function () {
                imageEditor.openDialog();
            }
        });

        // Add menu item
        editor.ui.registry.addMenuItem('imageeditor', {
            icon: 'image',
            text: 'Edit Image',
            onAction: function () {
                imageEditor.openDialog();
            }
        });

        // Add context toolbar button
        editor.ui.registry.addContextToolbar('imageeditor', {
            predicate: function (node) {
                return node.nodeName === 'IMG';
            },
            items: 'imageeditor',
            position: 'node',
            scope: 'node'
        });
    };

    // Register the plugin
    pluginManager.add('plgimg', Plugin);
})();