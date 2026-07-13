<?php
class JQueryUIDialogDecorator {
    private $name;
    private $styler;
    private $theme;
    private $customStyles = [];
    
    public function __construct($name, $styler = 1, $theme = 'default') {
        $this->name = $name;
        $this->styler = $styler;
        $this->theme = $theme;
        $this->setDialogTheme();
    }
    
    private function setDialogTheme() {
        switch($this->styler) {
            case 1: // Bootstrap 5 Theme
                $this->bootstrap5Theme();
                break;
            case 2: // Dark Theme
                $this->darkTheme();
                break;
            case 3: // Minimal Theme
                $this->minimalTheme();
                break;
            case 4: // Custom Theme
                $this->customTheme();
                break;
            default: // Default Theme
                $this->defaultTheme();
                break;
        }
    }
    
    private function bootstrap5Theme() {
        // Match Bootstrap card styling
        addHeaderCSS($this->name, '
            .ui-dialog {
                padding: 0 !important;
                border-radius: 0.5rem !important;
                box-shadow: 0 0.5rem 1rem rgba(0,0,0,0.15) !important;
                border: none !important;
            }
            .ui-dialog .ui-dialog-titlebar {
                background: linear-gradient(135deg, #667eea 0%, #764ba2 100%) !important;
                color: white !important;
                border-radius: 0.5rem 0.5rem 0 0 !important;
                padding: 1rem 1.5rem !important;
                border: none !important;
                font-weight: 600 !important;
            }
            .ui-dialog .ui-dialog-title {
                font-size: 1.1rem !important;
                margin: 0 !important;
            }
            .ui-dialog .ui-dialog-titlebar-close {
                background: rgba(255,255,255,0.2) !important;
                border-radius: 50% !important;
                border: none !important;
                top: 50% !important;
                transform: translateY(-50%) !important;
                right: 1rem !important;
            }
            .ui-dialog .ui-dialog-titlebar-close:hover {
                background: rgba(255,255,255,0.3) !important;
            }
            .ui-dialog .ui-dialog-content {
                padding: 0 !important;
                background: #f8f9fa !important;
            }
            .ui-dialog .ui-dialog-buttonpane {
                background: white !important;
                border-top: 1px solid #dee2e6 !important;
                padding: 1rem 1.5rem !important;
                border-radius: 0 0 0.5rem 0.5rem !important;
            }
        ');
    }
    
    private function darkTheme() {
        addHeaderCSS($this->name, '
            .ui-dialog {
                background: #1a1a2e !important;
                border-radius: 12px !important;
                box-shadow: 0 10px 40px rgba(0,0,0,0.5) !important;
                border: 1px solid #16213e !important;
            }
            .ui-dialog .ui-dialog-titlebar {
                background: #0f3460 !important;
                color: #e94560 !important;
                border-radius: 12px 12px 0 0 !important;
                padding: 1rem 1.5rem !important;
                border-bottom: 2px solid #e94560 !important;
            }
            .ui-dialog .ui-dialog-title {
                font-weight: bold !important;
                letter-spacing: 1px !important;
            }
            .ui-dialog .ui-dialog-content {
                background: #1a1a2e !important;
                color: #eee !important;
            }
            .ui-dialog .ui-dialog-buttonpane {
                background: #0f3460 !important;
                border-top: 1px solid #16213e !important;
            }
            .ui-dialog .ui-dialog-titlebar-close {
                background: #e94560 !important;
                border-radius: 50% !important;
            }
            .ui-dialog .ui-dialog-titlebar-close .ui-icon {
                background-color: white !important;
            }
        ');
    }
    
    private function minimalTheme() {
        addHeaderCSS($this->name, '
            .ui-dialog {
                border: 1px solid #e0e0e0 !important;
                border-radius: 0 !important;
                box-shadow: none !important;
            }
            .ui-dialog .ui-dialog-titlebar {
                background: white !important;
                color: #333 !important;
                border: none !important;
                border-bottom: 2px solid #007bff !important;
                padding: 1rem 1.5rem !important;
                font-weight: 500 !important;
            }
            .ui-dialog .ui-dialog-content {
                background: white !important;
            }
            .ui-dialog .ui-dialog-buttonpane {
                background: white !important;
                border-top: 1px solid #e0e0e0 !important;
            }
            .ui-dialog .ui-dialog-titlebar-close {
                background: transparent !important;
                border: none !important;
            }
        ');
    }
    
    private function customTheme() {
        // Allow dynamic style overrides
        $style = $this->getCustomStyle();
        addHeaderCSS($this->name, $style);
    }
    
    private function defaultTheme() {
        addHeaderCSS($this->name, '
            .ui-dialog-titlebar {
                background: linear-gradient(135deg, #667eea 0%, #764ba2 100%) !important;
                color: white !important;
            }
        ');
    }
    
    public function setCustomStyle($selector, $properties) {
        $this->customStyles[$selector] = $properties;
    }
    
    private function getCustomStyle() {
        $css = '';
        foreach($this->customStyles as $selector => $properties) {
            $css .= "$selector { $properties } ";
        }
        return $css;
    }
    
    public function addResizableHandles() {
        addHeaderCSS($this->name . 'resize', '
            .ui-resizable-handle {
                background: #667eea !important;
            }
            .ui-resizable-se {
                background: #667eea !important;
                border-radius: 0 0 8px 0 !important;
            }
        ');
    }
    
    public function animateDialog() {
        addHeaderCSS($this->name. 'animate', '
            .ui-dialog {
                animation: slideIn 0.3s ease-out !important;
            }
            @keyframes slideIn {
                from {
                    opacity: 0;
                    transform: translateY(-30px);
                }
                to {
                    opacity: 1;
                    transform: translateY(0);
                }
            }
        ');
    }
}
