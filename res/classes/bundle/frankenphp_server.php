<?php
/**
 * FrankenPHP Worker Script for SartajPHP
 * Corrected version following FrankenPHP worker pattern
 */

// ==================== Configuration ====================
$config = [
    'document_root' => __DIR__,
    'index_files' => ['index.html', 'index.htm', 'index.gate', 'index.app', 'index.front'],
    'session_path' => __DIR__ . '/storage/sessions',
    'session_lifetime' => 86400,
    'max_file_size' => 10 * 1024 * 1024,
    'debug' => true,
];

// Create session directory
if (!is_dir($config['session_path'])) {
    mkdir($config['session_path'], 0755, true);
}

// ==================== SartajPHP Initialization ====================
// disable auto start
$secure = false;
$_SERVER["HTTP_HOST"] =  "localhost:8080" ; 
$_SERVER["SERVER_SOFTWARE"] =  "FrankenPHP" ; 
if($secure) $_SERVER["HTTPS"] = "on";
$sharedpath = "./vendor/sartajphp/sartajphp";
$respath = "./vendor/sartajphp/sartajphp/res";
$slibversion = "Slib";
$libversion = "Sphp";

require_once $sharedpath . '/res/classes/bundle/SartajPhpRunner.php';

// Create runner instance
$runner = new SartajPhpRunner([
    'session_path' => __DIR__ . '/storage/sessions',
    'debug' => true
]);

/**
 * Parse multipart form data
 */
function parseMultipart($body, $boundary) {
    $parts = [];
    $blocks = explode('--' . $boundary, $body);
    
    foreach ($blocks as $block) {
        if (trim($block) === '' || trim($block) === '--') continue;
        
        preg_match('/name="([^"]+)"/', $block, $nameMatch);
        $name = $nameMatch[1] ?? '';
        
        preg_match('/filename="([^"]+)"/', $block, $fileMatch);
        $filename = $fileMatch[1] ?? '';
        
        $value = substr($block, strpos($block, "\r\n\r\n") + 4);
        $value = rtrim($value, "\r\n--");
        
        if ($filename) {
            $tempFile = tempnam(sys_get_temp_dir(), 'sphp_');
            file_put_contents($tempFile, $value);
            
            $parts[$name] = [
                'name' => $filename,
                'type' => 'application/octet-stream',
                'tmp_name' => $tempFile,
                'error' => 0,
                'size' => strlen($value)
            ];
        } else {
            $parts[$name] = $value;
        }
    }
    
    return $parts;
}

/**
 * Get MIME type for static files
 */
function getMimeType($file) {
    $mimeTypes = [
        'html' => 'text/html; charset=utf-8',
        'htm' => 'text/html; charset=utf-8',
        'css' => 'text/css; charset=utf-8',
        'js' => 'application/javascript; charset=utf-8',
        'json' => 'application/json; charset=utf-8',
        'png' => 'image/png',
        'jpg' => 'image/jpeg',
        'jpeg' => 'image/jpeg',
        'gif' => 'image/gif',
        'svg' => 'image/svg+xml',
        'ico' => 'image/x-icon',
        'webp' => 'image/webp',
    ];
    
    $ext = strtolower(pathinfo($file, PATHINFO_EXTENSION));
    return $mimeTypes[$ext] ?? 'application/octet-stream';
}

/**
 * Main request handler for FrankenPHP
 * This function is called for each request
 */
$handler = function() use ($config, $runner) {
    try {
        // Reset superglobals for each request (FrankenPHP resets them)
        $method = $_SERVER['REQUEST_METHOD'] ?? 'GET';
        $requestUri = $_SERVER['REQUEST_URI'] ?? '/';
        $path = parse_url($requestUri, PHP_URL_PATH);
        $queryString = parse_url($requestUri, PHP_URL_QUERY) ?? '';
        
        // Security: Prevent directory traversal
        $path = '/' . ltrim(preg_replace('/\.\.+/', '', $path), '/');
        
        // Default to index.gate for root
        if ($path === '/' || $path === '') {
            $path = '/index.gate';
        }
        
        $extension = strtolower(pathinfo($path, PATHINFO_EXTENSION));
        $sartajExtensions = ['gate', 'app', 'front', 'html', 'php'];
        
        // Check for static file
        $filePath = $config['document_root'] . $path;
        $isStaticFile = !in_array($extension, $sartajExtensions) && file_exists($filePath) && !is_dir($filePath);
        
        if ($isStaticFile) {
            // Serve static file
            $realFilePath = realpath($filePath);
            $realDocumentRoot = realpath($config['document_root']);
            
            if ($realFilePath && strpos($realFilePath, $realDocumentRoot) === 0) {
                $mimeType = getMimeType($realFilePath);
                $fileSize = filesize($realFilePath);
                
                header("Content-Type: $mimeType");
                header("Content-Length: $fileSize");
                header("Cache-Control: public, max-age=3600");
                
                readfile($realFilePath);
                return;
            }
        }
        
        // Process SartajPHP request
        // Parse GET
        $get = $_GET;
        
        // Parse POST
        $post = [];
        $files = [];
        $contentType = $_SERVER['CONTENT_TYPE'] ?? '';
        
        if ($method === 'POST' || $method === 'PUT' || $method === 'PATCH') {
            $body = file_get_contents('php://input');
            
            if (strpos($contentType, 'application/x-www-form-urlencoded') !== false) {
                parse_str($body, $post);
                $_POST = $post;
            } elseif (strpos($contentType, 'multipart/form-data') !== false) {
                if (preg_match('/boundary=(.+)$/', $contentType, $matches)) {
                    $boundary = $matches[1];
                    $parsed = parseMultipart($body, $boundary);
                    foreach ($parsed as $key => $value) {
                        if (is_array($value) && isset($value['tmp_name'])) {
                            $files[$key] = $value;
                            $_FILES[$key] = $value;
                        } else {
                            $post[$key] = $value;
                            $_POST[$key] = $value;
                        }
                    }
                }
            } elseif (strpos($contentType, 'application/json') !== false) {
                $post = json_decode($body, true) ?: [];
                $_POST = $post;
            }
        }
        
        // Parse cookies
        $cookies = [];
        $cookieHeader = $_SERVER['HTTP_COOKIE'] ?? '';
        if ($cookieHeader) {
            $cookiePairs = explode(';', $cookieHeader);
            foreach ($cookiePairs as $pair) {
                $pair = trim($pair);
                if (strpos($pair, '=') !== false) {
                    list($name, $value) = explode('=', $pair, 2);
                    $cookies[$name] = urldecode($value);
                    $_COOKIE[$name] = urldecode($value);
                }
            }
        }
        
        
        // Build server vars for SartajPHP
        $serverVars = [
            'REQUEST_METHOD' => $method,
            'REQUEST_URI' => $path,
            'SCRIPT_NAME' => $path,
            'SCRIPT_FILENAME' => $config['document_root'] . $path,
            'PATH_INFO' => $path,
            'QUERY_STRING' => $queryString,
            'SERVER_SOFTWARE' => $_SERVER['SERVER_SOFTWARE'] ?? 'FrankenPHP',
            'SERVER_PROTOCOL' => $_SERVER['SERVER_PROTOCOL'] ?? 'HTTP/1.1',
            'HTTP_HOST' => $_SERVER['HTTP_HOST'] ?? 'localhost',
            'HTTP_USER_AGENT' => $_SERVER['HTTP_USER_AGENT'] ?? '',
            'HTTP_ACCEPT' => $_SERVER['HTTP_ACCEPT'] ?? '',
            'HTTP_ACCEPT_ENCODING' => $_SERVER['HTTP_ACCEPT_ENCODING'] ?? '',
            'HTTP_ACCEPT_LANGUAGE' => $_SERVER['HTTP_ACCEPT_LANGUAGE'] ?? '',
            'HTTP_CONNECTION' => $_SERVER['HTTP_CONNECTION'] ?? '',
            'REMOTE_ADDR' => $_SERVER['REMOTE_ADDR'] ?? '127.0.0.1',
            'REMOTE_PORT' => $_SERVER['REMOTE_PORT'] ?? '80',
            'REQUEST_TIME' => time(),
            'REQUEST_TIME_FLOAT' => microtime(true),
            'HTTP_X_REQUESTED_WITH' => $_SERVER['HTTP_X_REQUESTED_WITH'] ?? '',
            'HTTP_SOAPACTION' => $_SERVER['HTTP_SOAPACTION'] ?? '',
        ];
        
        // Merge with existing $_SERVER
        foreach ($serverVars as $key => $value) {
            $_SERVER[$key] = $value;
        }
        
        // Call SartajPHP engine
		$result = $runner->process($serverVars, $get, $post, $files, $cookies);

		// Extract response
		$statusCode = $result["status"];
		$content = $result["content"] ?? '';
		$headers = $result["headers"] ?? [];
		$responseCookies = $result["cookies"] ?? []; // Array of cookies to set
        
        
        // Send status code
        http_response_code($statusCode);
        
        // Send headers
        foreach ($headers as $name => $value) {
            if (is_array($value)) {
                foreach ($value as $v) {
                    header("$name: $v");
                }
            } else {
                header("$name: $value");
            }
        }
                
        // Send content
        echo $content;
        
        // Cleanup temporary files
        if (!empty($files)) {
            foreach ($files as $file) {
                if (isset($file['tmp_name']) && file_exists($file['tmp_name'])) {
                    unlink($file['tmp_name']);
                }
            }
        }
        
    } catch (Exception $e) {
        http_response_code(500);
        if ($config['debug']) {
            echo "<h1>Error</h1><pre>" . htmlspecialchars($e->getMessage()) . "\n\n" . htmlspecialchars($e->getTraceAsString()) . "</pre>";
        } else {
            echo "<h1>500 Internal Server Error</h1><p>An error occurred while processing your request.</p>";
        }
    }
};

// ==================== FrankenPHP Worker Loop ====================
// This is the critical part - the worker loop that keeps the script alive
$maxRequests = (int)($_SERVER['MAX_REQUESTS'] ?? 1000); // Process up to 1000 requests then restart

for ($nbRequests = 0; !$maxRequests || $nbRequests < $maxRequests; ++$nbRequests) {
    // Wait for and handle a request
    $keepRunning = frankenphp_handle_request($handler);
    
    // Optional: Clean up after each request
    // Force garbage collection
    gc_collect_cycles();
    
    // Check if we should continue
    if (!$keepRunning) {
        break;
    }
}

// Optional: Cleanup before worker exits
