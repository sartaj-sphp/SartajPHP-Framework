<?php
/**
 * SartajPHP Universal Runner
 * Handles session management, request processing, and returns response data
 * Can be used with any PHP server (ReactPHP, FrankenPHP, Swoole, Amp, etc.)
 * 
 * @package SartajPHP
 * @version 2.0.0
 */
define("sphp_mannually_start_engine", true);
$phppath = $sharedpath . "/res";
include_once("{$phppath}/Score/{$libversion}/global/start.php");
$globalapp = startSartajPHPEngine();
if($globalapp != ""){
    require_once($globalapp);
    SphpBase::engine()->execute(true);
}

class SartajPhpRunner {
    
    /**
     * @var array Configuration settings
     */
    private $config;
    
    /**
     * @var SartajPHPSessionManager Session manager instance
     */
    private $sessionManager;
    
    /**
     * Constructor
     * 
     * @param string $host host with port which bind with URL
     * @param array $config Configuration options
     */
    public function __construct($config = []) {
        $this->config = array_merge([
            'session_path' => __DIR__ . '/storage/sessions',
            'session_lifetime' => 86400, // 24 hours
            'session_name' => 'SPHPID',
            'max_file_size' => 10 * 1024 * 1024, // 10MB
            'debug' => false,
            'upload_dir' => __DIR__ . '/storage/uploads',
        ], $config);
        
        // Create required directories
        $this->initializeDirectories();
        
        // Initialize session manager
        $this->sessionManager = new SartajPHPSessionManager(
            $this->config['session_path'],
            $this->config['session_lifetime'],
            $this->config['session_name']
        );

    }
    
    /**
     * Initialize required directories
     */
    private function initializeDirectories() {
        $dirs = [
            $this->config['session_path'],
            $this->config['upload_dir']
        ];
        
        foreach ($dirs as $dir) {
            if (!is_dir($dir)) {
                @mkdir($dir, 0755, true);
            }
        }
    }
    
    /**
     * Process request and return response
     * 
     * @param array $server Server variables (REQUEST_METHOD, REQUEST_URI, etc.)
     * @param array $get GET parameters
     * @param array $post POST parameters
     * @param array $files FILES array (standard PHP format)
     * @param array $cookies Cookies array
     * @return array Response array with keys: status, content, headers, cookies
     */
    public function process($server, $get = [], $post = [], $files = [], $cookies = []) {
        try {
            // Normalize server variables
            $serverVars = $this->normalizeServerVars($server);
            
            // Normalize files array
            $normalizedFiles = $this->normalizeFiles($files);
            
            // Process multipart form data if needed
            $processedPost = $this->processPostData($serverVars, $post, $normalizedFiles);
            $finalPost = $processedPost['post'];
            $finalFiles = $processedPost['files'];
            
            // Get session
            $sessionInfo = $this->sessionManager->getSession($cookies);
            $sessionId = $sessionInfo['id'];
            $session = $sessionInfo['data'];
            
            // Call SartajPHP engine
            $result = pushToSartajPHPEngine(
                $serverVars,
                $get,
                $finalPost,
                $finalFiles,
                $cookies,
                $session
            );
            
            // Extract response
            $statusCode = $result[0] ?? 200;
            $content = $result[1] ?? '';
            $headers = $result[2] ?? [];
            $responseCookies = $result[3] ?? [];
            $session = $result[4] ?? [];
            
            // Save session
            $saveResult = $this->sessionManager->saveSession($sessionId, $session);
            if ($saveResult['cookie']) {
                $responseCookies[$saveResult['cookie']['name']] = $saveResult['cookie'];
            }
            
            // Format cookies for response
            $formattedCookies = $this->formatCookiesForResponse($responseCookies);
            
            // Log if debugging
            if ($this->config['debug']) {
                $this->logRequest($serverVars, $statusCode);
            }
            
            return [
                'status' => $statusCode,
                'content' => $content,
                'headers' => $headers,
                'cookies' => $formattedCookies
            ];
            
        } catch (Exception $e) {
            $this->logError($e->getMessage());
            return $this->createErrorResponse(500, $e->getMessage());
        }
    }
    
    /**
     * Normalize server variables
     * 
     * @param array $server
     * @return array
     */
    private function normalizeServerVars($server) {
        $defaults = [
            'REQUEST_METHOD' => 'GET',
            'REQUEST_URI' => '/',
            'SCRIPT_NAME' => '/',
            'QUERY_STRING' => '',
            'SERVER_SOFTWARE' => 'SartajPHP-Runner',
            'SERVER_PROTOCOL' => 'HTTP/1.1',
            'HTTP_HOST' => 'localhost',
            'REMOTE_ADDR' => '127.0.0.1',
            'REQUEST_TIME' => time(),
            'REQUEST_TIME_FLOAT' => microtime(true),
            'CONTENT_TYPE' => '',
            'CONTENT_LENGTH' => '0',
        ];
        
        return array_merge($defaults, $server);
    }
    
    /**
     * Normalize files array from various formats
     * 
     * @param array $files
     * @return array
     */
    private function normalizeFiles($files) {
        $normalized = [];
        
        foreach ($files as $key => $file) {
            // Handle ReactPHP style files (with content)
            if (isset($file['content']) && !isset($file['tmp_name'])) {
                $tempFile = tempnam($this->config['upload_dir'], 'sphp_');
                file_put_contents($tempFile, $file['content']);
                
                $normalized[$key] = [
                    'name' => $file['name'] ?? 'unknown',
                    'type' => $file['type'] ?? 'application/octet-stream',
                    'tmp_name' => $tempFile,
                    'error' => 0,
                    'size' => $file['size'] ?? strlen($file['content'])
                ];
                continue;
            }
            
            // Handle standard PHP files array
            if (isset($file['tmp_name'])) {
                if (is_array($file['tmp_name'])) {
                    // Multiple files with same name
                    for ($i = 0; $i < count($file['tmp_name']); $i++) {
                        if ($file['error'][$i] === UPLOAD_ERR_OK) {
                            $normalized[$key][$i] = [
                                'name' => $file['name'][$i],
                                'type' => $file['type'][$i],
                                'tmp_name' => $file['tmp_name'][$i],
                                'error' => $file['error'][$i],
                                'size' => $file['size'][$i]
                            ];
                        }
                    }
                } else {
                    // Single file
                    if ($file['error'] === UPLOAD_ERR_OK) {
                        $normalized[$key] = $file;
                    }
                }
            }
        }
        
        return $normalized;
    }
    
    /**
     * Process POST data including multipart form data
     * 
     * @param array $serverVars
     * @param array $post
     * @param array $files
     * @return array
     */
    private function processPostData($serverVars, $post, $files) {
        $method = $serverVars['REQUEST_METHOD'] ?? 'GET';
        $contentType = $serverVars['CONTENT_TYPE'] ?? '';
        
        // Only process for POST, PUT, PATCH
        if (!in_array($method, ['POST', 'PUT', 'PATCH'])) {
            return ['post' => $post, 'files' => $files];
        }
        
        // If we already have processed files, return as is
        if (!empty($files)) {
            return ['post' => $post, 'files' => $files];
        }
        
        // If content type is multipart but no files processed, we need to parse raw body
        if (strpos($contentType, 'multipart/form-data') !== false && empty($files)) {
            // Note: In some environments, raw body needs to be read from php://input
            // This should be handled by the caller before calling process()
            return ['post' => $post, 'files' => []];
        }
        
        return ['post' => $post, 'files' => $files];
    }
    
    /**
     * Format cookies for response
     * Converts internal cookie format to standard array format
     * 
     * @param array $cookies
     * @return array
     */
    private function formatCookiesForResponse($cookies) {
        $formatted = [];
        
        foreach ($cookies as $name => $data) {
			$formatted[$name] = [
				'value' => $data[0] ?? '',
				'expire' => $data[1] ?? 0,
				'path' => $data[2] ?? '/',
				'domain' => $data[3] ?? '',
				'secure' => $data[4] ?? false,
				'httponly' => $data[5] ?? true,
				'samesite' => $data[6] ?? ''
			];
        }
        
        return $formatted;
    }
    
    /**
     * Create error response
     * 
     * @param int $code
     * @param string $message
     * @return array
     */
    private function createErrorResponse($code, $message) {
        $errorPages = [
            400 => 'Bad Request',
            403 => 'Forbidden',
            404 => 'Not Found',
            413 => 'Payload Too Large',
            500 => 'Internal Server Error',
        ];
        
        $statusText = $errorPages[$code] ?? 'Error';
        $html = sprintf(
            '<!DOCTYPE html>
            <html>
            <head><title>%d %s</title></head>
            <body>
                <h1>%d %s</h1>
                <p>%s</p>
                <hr>
                <small>SartajPHP Runner</small>
            </body>
            </html>',
            $code,
            $statusText,
            $code,
            $statusText,
            htmlspecialchars($message)
        );
        
        return [
            'status' => $code,
            'content' => $html,
            'headers' => ['Content-Type' => 'text/html; charset=utf-8'],
            'cookies' => []
        ];
    }
    
    /**
     * Log request
     * 
     * @param array $serverVars
     * @param int $statusCode
     */
    private function logRequest($serverVars, $statusCode) {
        $method = $serverVars['REQUEST_METHOD'] ?? 'GET';
        $uri = $serverVars['REQUEST_URI'] ?? '/';
        $duration = microtime(true) - ($serverVars['REQUEST_TIME_FLOAT'] ?? microtime(true));
        
        $logEntry = sprintf(
            "[%s] %s %s - %d (%.2fms)\n",
            date('Y-m-d H:i:s'),
            $method,
            $uri,
            $statusCode,
            $duration * 1000
        );
        
        echo $logEntry;
    }
    
    /**
     * Log error
     * 
     * @param string $error
     */
    private function logError($error) {
        if ($this->config['debug']) {
            $logEntry = sprintf(
                "[%s] ERROR: %s\n",
                date('Y-m-d H:i:s'),
                $error
            );
            echo $logEntry;
        }
    }
    
    /**
     * Get session manager instance
     * 
     * @return SartajPHPSessionManager
     */
    public function getSessionManager() {
        return $this->sessionManager;
    }
    
    /**
     * Clean up temporary files
     * Should be called after response is sent
     * 
     * @param array $files
     */
    public function cleanup($files) {
        foreach ($files as $file) {
            if (isset($file['tmp_name']) && file_exists($file['tmp_name'])) {
                $tempFile = $file['tmp_name'];
                // Only delete files in our upload directory
                if (strpos($tempFile, $this->config['upload_dir']) === 0) {
                    @unlink($tempFile);
                }
            }
        }
    }
}

/**
 * SartajPHP Session Manager
 */
class SartajPHPSessionManager {
    private $sessionName;
    private $sessionPath;
    private $sessionLifetime;
    
    /**
     * Constructor
     * 
     * @param string $sessionPath
     * @param int $sessionLifetime
     * @param string $sessionName
     */
    public function __construct($sessionPath = null, $sessionLifetime = 86400, $sessionName = null) {
        $this->sessionName = $sessionName ?? $this->getDefaultSessionName();
        $this->sessionPath = $sessionPath ?: sys_get_temp_dir();
        $this->sessionLifetime = $sessionLifetime;
        
        if (!is_dir($this->sessionPath)) {
            mkdir($this->sessionPath, 0755, true);
        }
    }
    
    /**
     * Get default session name from SartajPHP if available
     * 
     * @return string
     */
    private function getDefaultSessionName() {
        try {
            if (class_exists('SphpBase') && method_exists(SphpBase::sphp_settings(), 'getSession_name')) {
                return SphpBase::sphp_settings()->getSession_name();
            }
        } catch (Exception $e) {
            // Ignore
        }
        return 'SPHPID';
    }
    
    /**
     * Get session data from cookies
     * 
     * @param array $cookies
     * @return array
     */
    public function getSession($cookies) {
        $sessionId = $cookies[$this->sessionName] ?? null;
        $session = [];
        
        if ($sessionId && preg_match('/^[a-f0-9]{64}$/', $sessionId)) {
            $sessionFile = $this->getSessionFile($sessionId);
            if (file_exists($sessionFile)) {
                $content = file_get_contents($sessionFile);
                if ($content !== false) {
                    $session = unserialize($content) ?: [];
                }
            }
        }
        
        return ['id' => $sessionId, 'data' => $session];
    }
    
    /**
     * Save session data and return cookie if new session created
     * 
     * @param string|null $sessionId
     * @param array $sessionData
     * @return array
     */
    public function saveSession($sessionId, $sessionData) {
        $cookie = null;
        
        if (!empty($sessionData)) {
            if ($sessionId === null) {
                // Generate new session ID
                $sessionId = $this->generateSessionId();
                $cookie = $this->createSessionCookie($sessionId);
            }
            
            // Save session data
            $sessionFile = $this->getSessionFile($sessionId);
            file_put_contents($sessionFile, serialize($sessionData), LOCK_EX);
            
        } elseif ($sessionId !== null && empty($sessionData)) {
            // Clean up empty session
            $sessionFile = $this->getSessionFile($sessionId);
            if (file_exists($sessionFile)) {
                unlink($sessionFile);
            }
        }
        
        return [
            'session_id' => $sessionId,
            'cookie' => $cookie
        ];
    }
    
    /**
     * Generate secure session ID
     * 
     * @return string
     */
    private function generateSessionId() {
        return bin2hex(random_bytes(32));
    }
    
    /**
     * Create session cookie data
     * 
     * @param string $sessionId
     * @return array
     */
    private function createSessionCookie($sessionId) {
        return [
            'name' => $this->sessionName,
            'value' => $sessionId,
            'expire' => time() + $this->sessionLifetime,
            'path' => '/',
            'domain' => '',
            'secure' => false,
            'httponly' => true,
            'samesite' => 'Lax'
        ];
    }
    
    /**
     * Get session file path
     * 
     * @param string $sessionId
     * @return string
     */
    private function getSessionFile($sessionId) {
        return $this->sessionPath . '/sphp_session_' . $sessionId;
    }
    
    /**
     * Delete a session
     * 
     * @param string $sessionId
     * @return bool
     */
    public function deleteSession($sessionId) {
        $sessionFile = $this->getSessionFile($sessionId);
        if (file_exists($sessionFile)) {
            return unlink($sessionFile);
        }
        return false;
    }
    
    /**
     * Get session name
     * 
     * @return string
     */
    public function getSessionName() {
        return $this->sessionName;
    }
    
    /**
     * Get session lifetime
     * 
     * @return int
     */
    public function getSessionLifetime() {
        return $this->sessionLifetime;
    }
}