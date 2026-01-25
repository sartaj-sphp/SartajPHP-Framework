<?php

/**
 * Enhanced Captcha Control
 * 
 * @author SARTAJ
 * Usage in Front File:
 * <input type="text" runat="server" id="captchaInput" 
 *        path="controls/bundle/captcha/Captcha.php"  
 *        funsetMaxLen="6" 
 *        funsetRequired="true" 
 *        funsetForm="loginForm"
 *        funsetMsgName="Security Code">
 */

class Captcha extends \Sphp\comp\html\TextField {
    
    private $sessionKey = 'captcha_data';
    private $maxAttempts = 5;
    private $blockTime = 900;
    
    public function oninit() {
        parent::oninit();
        // Initialize captcha settings
        $this->setupSession();
        $this->addResources();
    }
    
    private function setupSession() {
        // Initialize session for captcha attempts
        if (!SphpBase::sphp_request()->isSession('captcha_attempts')) {
            SphpBase::sphp_request()->session('captcha_attempts', [
                'count' => 0,
                'blocked_until' => 0,
                'last_attempt' => 0
            ]);
        }
    }
    
    private function addResources() {
        // Add CSS styles
        $css = '
        .captcha-widget {
            margin: 15px 0;
            padding: 15px;
            background: #f8f9fa;
            border: 1px solid #e9ecef;
            border-radius: 6px;
        }
        
        .captcha-header {
            font-weight: 600;
            color: #343a40;
            margin-bottom: 12px;
            font-size: 14px;
        }
        
        .captcha-container {
            display: flex;
            align-items: flex-start;
            gap: 15px;
            margin-bottom: 15px;
        }
        
        .captcha-image-box {
            width: 160px;
            height: 60px;
            border: 1px solid #dee2e6;
            background: white;
            display: flex;
            align-items: center;
            justify-content: center;
            border-radius: 4px;
            overflow: hidden;
        }
        
        .captcha-btn {
            background: white;
            border: 1px solid #ced4da;
            border-radius: 4px;
            padding: 8px 12px;
            cursor: pointer;
            font-size: 13px;
            color: #495057;
            display: flex;
            align-items: center;
            gap: 6px;
            transition: all 0.2s;
            white-space: nowrap;
        }
        
        .captcha-btn:hover {
            background: #f8f9fa;
            border-color: #adb5bd;
        }
        
        .captcha-btn:disabled {
            opacity: 0.6;
            cursor: not-allowed;
        }
        
        .captcha-error {
            color: #dc3545;
            font-size: 13px;
            margin-top: 8px;
            padding: 8px;
            background: #f8d7da;
            border: 1px solid #f5c6cb;
            border-radius: 4px;
            display: none;
        }
        
        .captcha-help {
            font-size: 12px;
            color: #6c757d;
            margin-top: 8px;
        }
        ';
        
        addHeaderCSS($this->name . '_styles', $css);
    }
    
    public function oncreate($element) {
        $this->unsetEndTag();
        
        // Handle events if this is an event request
        if (SphpBase::page()->isevent && !$this->isBlocked()) {
            $this->handleEvents();
            return;
        }
        
        // Handle validation on form submission
        // Parent class handles required and other validations
        if ($this->issubmit) {
            $this->validateCaptcha();
        }
    }
    
    private function handleEvents() {
        $event = SphpBase::page()->getEvent();
        
        switch ($event) {
            case "captcha":
                $this->generateCaptchaImage();
                break;
                
            case "refresh_captcha":
                $this->refreshCaptcha();
                break;
        }
    }
    
    private function validateCaptcha() {
        // This handles validation on form submission
        if ($this->isBlocked()) {
            $this->setErrMsg("Too many failed attempts. Please try again in " . 
                            $this->getRemainingBlockTime() . " minutes.");
            return;
        }
        
        $userInput = strtoupper(trim($this->getValue()));
        $sessionData = SphpBase::sphp_request()->session($this->sessionKey);
        
        if (empty($sessionData)) {
            $this->setErrMsg("Security code session expired. Please refresh the code.");
            $this->logAttempt(false, 'session_expired');
            return;
        }
        
        $expected = $sessionData['value'] ?? '';
        
        if (empty($userInput)) {
            // Parent class handles empty validation with setErrMsg
            // We just log the attempt
            $this->logAttempt(false, 'empty_input');
        } elseif (!hash_equals(md5($userInput), md5($expected))) {
            $this->setErrMsg("Security code is incorrect! $userInput = $expected");
            $this->incrementAttempts();
            SphpBase::sphp_request()->session($this->sessionKey, null);
            $this->logAttempt(false, 'incorrect_code');
            
            // Add JavaScript to refresh captcha on next page load
            //addHeaderJSFunctionCode('ready', 'refresh_failed_' . $this->name, 'setTimeout(function(){ refreshSartajCaptcha("' . $this->name . '"); }, 500);');
        } else {
            // Success - clear attempts and session
            $this->resetAttempts();
            SphpBase::sphp_request()->session($this->sessionKey, null);
            $this->logAttempt(true, 'success');
        }
    }
    
    private function isBlocked() {
        $attempts = SphpBase::sphp_request()->session('captcha_attempts');
        
        if (!$attempts) {
            return false;
        }
        
        if ($attempts['blocked_until'] > time()) {
            return true;
        }
        
        if ($attempts['count'] >= $this->maxAttempts) {
            $attempts['blocked_until'] = time() + $this->blockTime;
            $attempts['count'] = 0;
            SphpBase::sphp_request()->session('captcha_attempts', $attempts);
            return true;
        }
        
        return false;
    }
    
    private function getRemainingBlockTime() {
        $attempts = SphpBase::sphp_request()->session('captcha_attempts');
        if ($attempts && $attempts['blocked_until'] > time()) {
            return ceil(($attempts['blocked_until'] - time()) / 60);
        }
        return 0;
    }
    
    private function incrementAttempts() {
        $attempts = SphpBase::sphp_request()->session('captcha_attempts');
        if ($attempts) {
            $attempts['count']++;
            $attempts['last_attempt'] = time();
            SphpBase::sphp_request()->session('captcha_attempts', $attempts);
        }
    }
    
    private function resetAttempts() {
        SphpBase::sphp_request()->session('captcha_attempts', [
            'count' => 0,
            'blocked_until' => 0,
            'last_attempt' => 0
        ]);
    }
    
    private function generateCaptchaImage() {
        include_once($this->mypath . "/cap.php");
        $captcha = new CaptchaSub();
        $imageData = $captcha->genImage();
        
        // Store captcha data in session
        $captchaData = [
            'id' => bin2hex(random_bytes(16)),
            'value' => $captcha->getGeneratedValue(),
            'timestamp' => time(),
            'ip' => SphpBase::sphp_request()->server('REMOTE_ADDR', 'unknown')
        ];
        SphpBase::sphp_request()->session($this->sessionKey, $captchaData);
        
        // Return image via AJAX to update the container
        SphpBase::JSServer()->addJSONHTMLBlock('captcha_image_' . $this->name, 
            '<img src="data:image/jpeg;base64,' . $imageData . '" width="160" height="60" alt="Security Code" />'
        );
    }
    
    private function refreshCaptcha() {
        include_once($this->mypath . "/cap.php");
        $captcha = new CaptchaSub();
        $imageData = $captcha->genImage();
        
        // Store new captcha data
        $captchaData = [
            'id' => bin2hex(random_bytes(16)),
            'value' => $captcha->getGeneratedValue(),
            'timestamp' => time(),
            'ip' => SphpBase::sphp_request()->server('REMOTE_ADDR', 'unknown')
        ];
        SphpBase::sphp_request()->session($this->sessionKey, $captchaData);
        
        // Update image container
        SphpBase::JSServer()->addJSONHTMLBlock('captcha_image_' . $this->name, 
            '<img src="data:image/jpeg;base64,' . $imageData . '" width="160" height="60" alt="Security Code" />'
        );
        
        // Clear input field and re-enable refresh button
        SphpBase::JSServer()->addJSONJSBlock('
            (function() {
                // Clear input field
                var inputField = document.getElementById("' . $this->name . '");
                if(inputField) {
                    inputField.value = "";
                }
                
                // Re-enable refresh button
                var refreshBtn = document.getElementById("refresh_btn_' . $this->name . '");
                if(refreshBtn) {
                    refreshBtn.disabled = false;
                    refreshBtn.innerHTML = \'<span>⟳</span><span>New Code</span>\';
                }
            })();
        ');
    }
    
    private function logAttempt($success, $type = '') {
        $logMessage = sprintf(
            "Captcha Attempt: %s | IP: %s | Success: %s | Type: %s",
            $this->name,
            SphpBase::sphp_request()->server('REMOTE_ADDR', 'unknown'),
            $success ? 'YES' : 'NO',
            $type
        );
        
        SphpBase::debug()->write_log($logMessage);
    }
    
    public function onrender() {
        SphpBase::JSServer()->getAJAX();
        $this->value = "";
        parent::onrender();
        // Configure input element attributes
        $this->element->setAttribute('autocomplete', 'off');
        $this->element->setAttribute('autocapitalize', 'off');
        $this->element->setAttribute('autocorrect', 'off');
        $this->element->setAttribute('spellcheck', 'false');
        $this->element->setAttribute('aria-label', 'Security verification code');
        $this->element->setAttribute('style', 'width: 200px; padding: 8px 12px; border: 1px solid #ced4da; border-radius: 4px;');
        
        // Add placeholder if not set
        if (!$this->element->getAttribute('placeholder')) {
            $this->element->setAttribute('placeholder', 'Enter code from image');
        }
        
        // Build the captcha widget HTML
        $widgetHtml = '
        <div class="captcha-widget" id="captcha_widget_' . $this->name . '">
            <div class="captcha-header">
                Security Verification
            </div>
            
            <div class="captcha-container">
                <div class="captcha-image-box" id="captcha_image_' . $this->name . '">
                    <span style="color: #6c757d; font-size: 12px;">Loading security code...</span>
                </div>
                
                <button type="button" id="refresh_btn_' . $this->name . '" 
                        class="captcha-btn"
                        onclick="refreshSartajCaptcha(\'' . $this->name . '\')">
                    <span>⟳</span>
                    <span>New Code</span>
                </button>
            </div>
            
            <div style="margin: 12px 0 8px 0;">
                <label for="' . $this->name . '" style="display: block; margin-bottom: 5px; font-size: 14px; color: #495057;">
                    Enter the code shown above:
                </label>
            </div>
            
            <!-- The input field will be inserted here by the framework -->
            
            <div class="captcha-error" id="captcha_error_' . $this->name . '"></div>
            
            <div class="captcha-help">
                Can\'t read the code? Click "New Code" for a different one.
            </div>
        </div>';
        
        $this->setPreTag($widgetHtml);
        
        // Add JavaScript functions
        $this->addJavaScriptFunctions();
    }
    
    private function addJavaScriptFunctions() {
        $jsFunctions = '
        // Captcha Utility Functions
        window.refreshSartajCaptcha = function(captchaName) {
            var refreshBtn = document.getElementById("refresh_btn_" + captchaName);
            var imageBox = document.getElementById("captcha_image_" + captchaName);
            
            if(refreshBtn && imageBox) {
                // Show loading state
                refreshBtn.disabled = true;
                refreshBtn.innerHTML = \'<span>⏳</span><span>Loading...</span>\';
                
                imageBox.innerHTML = \'<span style="color: #6c757d; font-size: 12px;">Loading new code...</span>\';
                
                // Make AJAX request using SartajPHP framework
                getURL("' . getEventURL('refresh_captcha', '', 'index2') . '", 
                       {captcha_name: captchaName}, 
                       false);
            }
        };
        
        window.showCaptchaError = function(captchaName, message) {
            var errorDiv = document.getElementById("captcha_error_" + captchaName);
            if(errorDiv) {
                errorDiv.innerHTML = \'<strong>Error:</strong> \' + message;
                errorDiv.style.display = "block";
                
                // Auto-hide after 10 seconds
                setTimeout(function() {
                    errorDiv.style.display = "none";
                }, 10000);
            }
        };
        
        // Initialize captcha on page load
        setTimeout(function() {
            // Load initial captcha image
            getURL("' . getEventURL('captcha', '', 'index2') . '", {}, false);
        }, 100);
        ';
        
        if(!$this->isBlocked()) addHeaderJSFunctionCode('ready', 'captcha_js_' . $this->name, $jsFunctions);
    }
    
    // Optional: Add configuration methods
    public function setMaxAttempts($attempts) {
        $this->maxAttempts = max(1, (int)$attempts);
        return $this;
    }
    
    public function setBlockTime($seconds) {
        $this->blockTime = max(60, (int)$seconds);
        return $this;
    }
}