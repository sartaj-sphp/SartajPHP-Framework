// property-editors.js
window.PropertyEditors = {
    currentElement: null,
    
    // Initialize all editors for an element
    initEditors: function(elementType) {
        if (!this.currentElement) return '';
        
        let html = '<div class="property-editors-container">';
        
        // Color Editor
        html += this.createSection('Text Color', this.initColorEditor('text'));
        
        // Background Color Editor
        html += this.createSection('Background Color', this.initColorEditor('background'));
        
        // Alignment Editor
        html += this.createSection('Alignment', this.initAlignmentEditor());
        
        // Spacing Editor
        if (['p', 'h1', 'h2', 'h3', 'div', 'span'].includes(elementType)) {
            html += this.createSection('Spacing', this.initSpacingEditor('margin'));
            html += this.createSection('Padding', this.initSpacingEditor('padding'));
        }
        
        // Image Editor
        if (elementType === 'img') {
            html += this.createSection('Image Properties', this.initImageEditor());
        }
        
        // Link Editor
        if (elementType === 'a') {
            html += this.createSection('Link Properties', this.initLinkEditor());
        }
        
        html += '</div>';
        return html;
    },
    
    // Create section with border
    createSection: function(title, content) {
        return `
            <div class="editor-section border-bottom pb-3 mb-3">
                <h6 class="section-title text-primary mb-3">${title}</h6>
                ${content}
            </div>
        `;
    },
    
    // Color Editor
    initColorEditor: function(colorType = 'text') {
        const isBackground = colorType === 'background';
        const bootstrapColors = isBackground ? this.bgColors : this.textColors;
        
        let html = `<div class="color-editor" data-type="${colorType}">
            <div class="btn-group-horizontal d-flex flex-wrap gap-2 mb-3">`;
        
        Object.entries(bootstrapColors).forEach(([key, color]) => {
            const isActive = this.currentElement.classList.contains(color.class);
            html += `
                <button type="button" class="btn btn-sm p-0 rounded-circle color-btn ${isActive ? 'active' : ''}" 
                        style="width: 32px; height: 32px; background-color: ${color.color};"
                        onclick="PropertyEditors.applyColor('${colorType}', '${color.class}', this)"
                        title="${key}">
                    ${isActive ? '✓' : ''}
                </button>`;
        });
        
        html += `</div>
            <div class="custom-color-container">
                <label class="form-label small mb-1">Custom Color:</label>
                <div class="input-group input-group-sm">
                    <input type="color" class="form-control form-control-color" 
                           onchange="PropertyEditors.applyCustomColor('${colorType}', this.value)"
                           value="${this.getCurrentColor(colorType)}">
                    <input type="text" class="form-control" placeholder="#hexcode" 
                           onkeyup="PropertyEditors.applyCustomColor('${colorType}', this.value)"
                           value="${this.getCurrentColor(colorType)}">
                </div>
            </div>`;
            
        if (isBackground) {
            html += `
            <div class="form-control form-check-inline mt-2">
                <input type="checkbox" class="form-check-input px-3 py-3 border" id="gradient-checkbox"
                       onchange="PropertyEditors.toggleGradient(this.checked)">
                <label class="form-check-label small" for="gradient-checkbox">Gradient</label>
            </div>
<div class="input-group input-group-sm">
            EndColor:- <input class="form-control form-control-color" type="color" id="gradient-endcolor" value="#ffff00" onchange="PropertyEditors.toggleGradient(true)" />
        </div>
`;
        }
        
        html += `</div>`;
        return html;
    },
    
    // Alignment Editor
    initAlignmentEditor: function() {
        const alignments = {
            left: { class: 'text-start', icon: '↖', name: 'Left' },
            center: { class: 'text-center', icon: '↑', name: 'Center' },
            right: { class: 'text-end', icon: '↗', name: 'Right' },
            justify: { class: 'text-justify', icon: '⇄', name: 'Justify' }
        };
        
        let html = '<div class="btn-group w-100" role="group">';
        
        Object.entries(alignments).forEach(([key, align]) => {
            const isActive = this.currentElement.classList.contains(align.class);
            html += `
                <button type="button" class="btn btn-sm ${isActive ? 'btn-primary' : 'btn-outline-primary'}" 
                        onclick="PropertyEditors.applyAlignment('${align.class}', this)"
                        title="${align.name}">
                    ${align.icon}
                </button>`;
        });
        
        html += '</div>';
        return html;
    },
    
    // Spacing Editor
    initSpacingEditor: function(spacingType = 'margin') {
        const spacings = {
            '0': { class: spacingType === 'padding' ? 'p-0' : 'm-0', name: 'None' },
            '1': { class: spacingType === 'padding' ? 'p-1' : 'm-1', name: 'XS' },
            '2': { class: spacingType === 'padding' ? 'p-2' : 'm-2', name: 'Small' },
            '3': { class: spacingType === 'padding' ? 'p-3' : 'm-3', name: 'Medium' },
            '4': { class: spacingType === 'padding' ? 'p-4' : 'm-4', name: 'Large' },
            '5': { class: spacingType === 'padding' ? 'p-5' : 'm-5', name: 'XL' }
        };
        
        let html = '<div class="btn-group btn-group-sm w-100" role="group">';
        
        Object.entries(spacings).forEach(([size, spacing]) => {
            const isActive = this.currentElement.classList.contains(spacing.class);
            html += `
                <button type="button" class="btn ${isActive ? 'btn-secondary' : 'btn-outline-secondary'}" 
                        onclick="PropertyEditors.applySpacing('${spacing.class}', '${spacingType}', this)">
                    ${spacing.name}
                </button>`;
        });
        
        html += '</div>';
        return html;
    },
    
    // Image Editor
    initImageEditor: function() {
        const src = this.currentElement.getAttribute('src') || '';
        const alt = this.currentElement.getAttribute('alt') || '';
        const styles = {
            rounded: { class: 'rounded', name: 'Rounded' },
            circle: { class: 'rounded-circle', name: 'Circle' },
            thumbnail: { class: 'img-thumbnail', name: 'Thumbnail' },
            responsive: { class: 'img-fluid', name: 'Responsive' }
        };
        
        let html = `
            <div class="mb-3">
                <label class="form-label small">Image URL:</label>
                <input type="url" class="form-control form-control-sm" 
                       value="${src}" onkeyup="PropertyEditors.updateImageSrc(this.value)">
            </div>
            <div class="mb-3">
                <label class="form-label small">Alt Text:</label>
                <input type="text" class="form-control form-control-sm" 
                       value="${alt}" onkeyup="PropertyEditors.updateImageAlt(this.value)">
            </div>
            <div class="btn-group btn-group-sm w-100" role="group">`;
        
        Object.entries(styles).forEach(([key, style]) => {
            const isActive = this.currentElement.classList.contains(style.class);
            html += `
                <button type="button" class="btn ${isActive ? 'btn-primary' : 'btn-outline-primary'}" 
                        onclick="PropertyEditors.toggleImageStyle('${style.class}', this)">
                    ${style.name}
                </button>`;
        });
        
        html += '</div>';
        return html;
    },
    
    // Link Editor
    initLinkEditor: function() {
        const href = this.currentElement.getAttribute('href') || '';
        const styles = {
            primary: { class: 'btn-primary', name: 'Primary' },
            secondary: { class: 'btn-secondary', name: 'Secondary' },
            success: { class: 'btn-success', name: 'Success' },
            danger: { class: 'btn-danger', name: 'Danger' },
            warning: { class: 'btn-warning', name: 'Warning' },
            info: { class: 'btn-info', name: 'Info' },
            light: { class: 'btn-light', name: 'Light' },
            dark: { class: 'btn-dark', name: 'Dark' }
        };

        let html = `
            <div class="mb-3">
                <label class="form-label small">Link URL:</label>
                <input type="url" class="form-control form-control-sm" 
                       value="${href}" onkeyup="PropertyEditors.updateLinkHref(this.value)">
            </div>
            <div class="form-check form-switch">
                <input class="form-check-input" type="checkbox" id="link-target" 
                       ${this.currentElement.getAttribute('target') === '_blank' ? 'checked' : ''}
                       onchange="PropertyEditors.updateLinkTarget(this.checked)">
                <label class="form-check-label small" for="link-target">Open in new tab</label>
            </div>
        <h4>Button Color</h4>
            <div class="btn-group btn-group-sm w-100" role="group">`;
           if(! this.currentElement.classList.contains("btn")) this.currentElement.classList.add("btn");
       Object.entries(styles).forEach(([key, style]) => {
           const isActive = this.currentElement.classList.contains(style.class);
          // if(this.currentElement.classList.contains(style.class)) this.currentElement.classList.remove(style.class);
            html += `
                <button type="button" class="btn ${isActive ? 'btn-primary' : 'btn-outline-primary'}" 
                        onclick="PropertyEditors.toggleImageStyle('${style.class}', this)">
                    ${style.name}
                </button>`;
        });
        
        html += '</div>';
        return html;
    },
    
    // Helper methods
    getCurrentColor: function(colorType) {
        return colorType === 'background' ? 
            (this.currentElement.style.backgroundColor || '#ff0000') : 
            (this.currentElement.style.color || '#ff0000');
    },
    
    // Action methods
    applyColor: function(colorType, colorClass, button) {
        if (!this.currentElement) return;
        
        const bootstrapColors = colorType === 'text' ? this.textColors : this.bgColors;
        
        // Remove all color classes
        for (const key in bootstrapColors) {
            this.currentElement.classList.remove(bootstrapColors[key].class);
        }
        
        // Remove inline styles
        if (colorType === 'background') {
            this.currentElement.style.backgroundColor = '';
            this.currentElement.style.background = '';
        } else {
            this.currentElement.style.color = '';
        }
        
        // Add selected class
        this.currentElement.classList.add(colorClass);
        
        // Update button states
        const buttons = button.parentElement.querySelectorAll('.color-btn');
        buttons.forEach(btn => btn.classList.remove('active'));
        button.classList.add('active');
        button.innerHTML = '✓';
    },
    
    applyCustomColor: function(colorType, colorValue) {
        if (!this.currentElement || !colorValue) return;
        
        const isBackground = colorType === 'background';
        const bootstrapColors = isBackground ? this.bgColors : this.textColors;
        
        // Remove all bootstrap classes
        for (const key in bootstrapColors) {
            this.currentElement.classList.remove(bootstrapColors[key].class);
        }
        
        // Update button states
        const buttons = document.querySelectorAll(`.color-editor[data-type="${colorType}"] .color-btn`);
        buttons.forEach(btn => {
            btn.classList.remove('active');
            btn.innerHTML = '';
        });
        
        // Apply custom color
        if (isBackground) {
            this.currentElement.style.backgroundColor = colorValue;
        } else {
            this.currentElement.style.color = colorValue;
        }
    },
    
    toggleGradient: function(enabled) {
        if (!this.currentElement) return;
        
        const currentColor = this.currentElement.style.backgroundColor;
        if (enabled && currentColor) {
            const endcolor = $("#gradient-endcolor").val(); console.log("color " + endcolor);
            this.currentElement.style.background = `linear-gradient(45deg, ${currentColor}, ${endcolor})`;
        } else {
            this.currentElement.style.background = '';
        }
    },
    
    applyAlignment: function(alignmentClass, button) {
        if (!this.currentElement) return;
        
        // Remove all alignment classes
        ['text-start', 'text-center', 'text-end', 'text-justify'].forEach(cls => {
            this.currentElement.classList.remove(cls);
        });
        
        // Add selected alignment
        this.currentElement.classList.add(alignmentClass);
        
        // Update button states
        const buttons = button.parentElement.querySelectorAll('button');
        buttons.forEach(btn => {
            btn.classList.remove('btn-primary');
            btn.classList.add('btn-outline-primary');
        });
        button.classList.remove('btn-outline-primary');
        button.classList.add('btn-primary');
    },
    
    applySpacing: function(spacingClass, spacingType, button) {
        if (!this.currentElement) return;
        
        // Remove all spacing classes
        const prefix = spacingType === 'padding' ? 'p-' : 'm-';
        const classes = Array.from(this.currentElement.classList).filter(cls => 
            cls.startsWith(prefix) && cls.length === 3
        );
        classes.forEach(cls => this.currentElement.classList.remove(cls));
        
        // Add selected spacing
        this.currentElement.classList.add(spacingClass);
        
        // Update button states
        const buttons = button.parentElement.querySelectorAll('button');
        buttons.forEach(btn => {
            btn.classList.remove('btn-secondary');
            btn.classList.add('btn-outline-secondary');
        });
        button.classList.remove('btn-outline-secondary');
        button.classList.add('btn-secondary');
    },
    
    updateImageSrc: function(src) {
        if (this.currentElement) {
            this.currentElement.setAttribute('src', src);
        }
    },
    
    updateImageAlt: function(alt) {
        if (this.currentElement) {
            this.currentElement.setAttribute('alt', alt);
        }
    },
    
    toggleImageStyle: function(styleClass, button) {
        if (!this.currentElement) return;
        let self = this;
        self.currentElement.classList.toggle(styleClass);

        // Update button state
        if (self.currentElement.classList.contains(styleClass)) {
            button.classList.remove('btn-outline-primary');
            button.classList.add('btn-primary');
        } else {
            button.classList.remove('btn-primary');
            button.classList.add('btn-outline-primary');
        }
    },
    
    updateLinkHref: function(href) {
        if (this.currentElement) {
            this.currentElement.setAttribute('href', href);
        }
    },
    
    updateLinkTarget: function(openInNewTab) {
        if (this.currentElement) {
            this.currentElement.setAttribute('target', openInNewTab ? '_blank' : '_self');
        }
    },
    
    // Color definitions
    textColors: {
        primary: { class: 'text-primary', color: '#0d6efd' },
        secondary: { class: 'text-secondary', color: '#6c757d' },
        success: { class: 'text-success', color: '#198754' },
        danger: { class: 'text-danger', color: '#dc3545' },
        warning: { class: 'text-warning', color: '#ffc107' },
        info: { class: 'text-info', color: '#0dcaf0' },
        light: { class: 'text-light', color: '#f8f9fa' },
        dark: { class: 'text-dark', color: '#212529' }
    },
    
    bgColors: {
        primary: { class: 'bg-primary', color: '#0d6efd' },
        secondary: { class: 'bg-secondary', color: '#6c757d' },
        success: { class: 'bg-success', color: '#198754' },
        danger: { class: 'bg-danger', color: '#dc3545' },
        warning: { class: 'bg-warning', color: '#ffc107' },
        info: { class: 'bg-info', color: '#0dcaf0' },
        light: { class: 'bg-light', color: '#f8f9fa' },
        dark: { class: 'bg-dark', color: '#212529' }
    }
};