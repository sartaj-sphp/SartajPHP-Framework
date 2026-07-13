#!/usr/bin/env php
<?php
/**
 * ReactPHP + SartajPHP Integration Server
 * Full-featured async web server with SartajPHP framework support
 * Install:-
 * composer require react/http react/event-loop react/socket sartajphp/sartajphp
 */

// Load Composer autoloader
require_once __DIR__ . '/vendor/autoload.php';

use React\Http\HttpServer;
use React\Http\Message\Response;
use React\Socket\SocketServer;
use Psr\Http\Message\ServerRequestInterface;
use React\Stream\ThroughStream;
use React\Promise\Promise;

// ==================== Configuration ====================
$config = [
    'document_root' => __DIR__ . '',
    'port' => 8080,
    'host' => '0.0.0.0',
    'enable_gzip' => false,
    'cache_control' => true,
    'max_file_size' => 10 * 1024 * 1024, // 10MB
    'index_files' => ['index.html', 'index.htm', 'index.php'],
    'log_requests' => true,
];

// Parse command line arguments
for ($i = 1; $i < $argc; $i++) {
    switch ($argv[$i]) {
        case '--port':
            $config['port'] = (int)$argv[++$i];
            break;
        case '--host':
            $config['host'] = $argv[++$i];
            break;
        case '--root':
            $config['document_root'] = $argv[++$i];
            break;
        case '--help':
            echo "Usage: php server.php [options]\n";
            echo "Options:\n";
            echo "  --port <port>     Port to listen on (default: 8080)\n";
            echo "  --host <host>     Host to bind to (default: 0.0.0.0)\n";
            echo "  --root <path>     Document root directory (default: current dir)\n";
            echo "  --help            Show this help message\n";
            exit(0);
    }
}

// ==================== SartajPHP Initialization ====================
// disable auto start
$secure = false;
$_SERVER["HTTP_HOST"] =  "localhost:" . $config["port"] ; 
$_SERVER["SERVER_SOFTWARE"] =  "ReactPHP" ; 
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
            $parts[$name] = [
                'name' => $filename,
                'type' => 'application/octet-stream',
                'tmp_name' => null,
                'error' => 0,
                'size' => strlen($value),
                'content' => $value
            ];
        } else {
            $parts[$name] = $value;
        }
    }
    
    return $parts;
}

function logRequest($method, $path, $status, $duration = null) {
    $timestamp = date('Y-m-d H:i:s');
    $durationStr = $duration ? sprintf("[%.2fms]", $duration * 1000) : "";
    echo "[$timestamp] $method $path - $status $durationStr\n";
}

// ==================== MIME Types ====================
$mimeTypes = [
    'html' => 'text/html; charset=utf-8',
    'htm' => 'text/html; charset=utf-8',
    'css' => 'text/css; charset=utf-8',
    'js' => 'application/javascript; charset=utf-8',
    'json' => 'application/json; charset=utf-8',
    'xml' => 'application/xml; charset=utf-8',
    'txt' => 'text/plain; charset=utf-8',
    
    // Images
    'png' => 'image/png',
    'jpg' => 'image/jpeg',
    'jpeg' => 'image/jpeg',
    'gif' => 'image/gif',
    'svg' => 'image/svg+xml',
    'ico' => 'image/x-icon',
    'webp' => 'image/webp',
    
    // Fonts
    'woff' => 'font/woff',
    'woff2' => 'font/woff2',
    'ttf' => 'font/ttf',
    'eot' => 'application/vnd.ms-fontobject',
    
    // Documents
    'pdf' => 'application/pdf',
    'doc' => 'application/msword',
    'docx' => 'application/vnd.openxmlformats-officedocument.wordprocessingml.document',
    'xls' => 'application/vnd.ms-excel',
    'xlsx' => 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet',
    
    // Archives
    'zip' => 'application/zip',
    'tar' => 'application/x-tar',
    'gz' => 'application/gzip',
    
    // Audio/Video
    'mp3' => 'audio/mpeg',
    'mp4' => 'video/mp4',
    'webm' => 'video/webm',
    'ogg' => 'audio/ogg',
];


// ==================== Create HTTP Server ====================
$http = new HttpServer(function (ServerRequestInterface $request) use ($config, $mimeTypes, $runner) {
    $startTime = microtime(true);
    $method = $request->getMethod();
    $path = urldecode($request->getUri()->getPath());
    $queryString = $request->getUri()->getQuery();
    
    // Security: Prevent directory traversal
    $path = preg_replace('/\.\.+/', '', $path);
    $path = str_replace(['\\', "\0"], '', $path);
    
    // Normalize path (prevent double slashes)
    $path = '/' . ltrim($path, '/');
	if($path == "/" || $path == "") $path = "/index.gate";
    
    // ==================== Process SartajPHP Requests ====================
    $extension = strtolower(pathinfo($path, PATHINFO_EXTENSION));
    $sartajExtensions = ['gate', 'app', 'front', 'html', 'php'];
    
    if (in_array($extension, $sartajExtensions)) {
        try {
            // Build $_SERVER array for SartajPHP
            $serverVars = [
                'REQUEST_METHOD' => $method,
                'REQUEST_URI' => $path,
                'SCRIPT_NAME' => $path,
                'PATH_INFO' => $path,
                'QUERY_STRING' => $queryString,
                'SERVER_SOFTWARE' => 'ReactPHP',
                'SERVER_PROTOCOL' => 'HTTP/1.1',
                'HTTP_HOST' => $request->getUri()->getHost(),
                'HTTP_USER_AGENT' => $request->getHeaderLine('User-Agent'),
                'HTTP_ACCEPT' => $request->getHeaderLine('Accept'),
                'HTTP_ACCEPT_ENCODING' => $request->getHeaderLine('Accept-Encoding'),
                'HTTP_ACCEPT_LANGUAGE' => $request->getHeaderLine('Accept-Language'),
                'HTTP_CONNECTION' => $request->getHeaderLine('Connection'),
                'REMOTE_ADDR' => $request->getServerParams()['REMOTE_ADDR'] ?? '127.0.0.1',
                'REMOTE_PORT' => $request->getServerParams()['REMOTE_PORT'] ?? '80',
                'REQUEST_TIME' => time(),
                'REQUEST_TIME_FLOAT' => microtime(true),
				'HTTP_X_REQUESTED_WITH' => $request->getHeaderLine('HTTP_X_REQUESTED_WITH'), // work AJAX type
				'HTTP_SOAPACTION' => $request->getHeaderLine('HTTP_SOAPACTION'), // work for SOAP Type
            ];
            
            // Parse GET parameters
            $get = $request->getQueryParams();
            
            // Parse POST parameters
            $post = [];
            $files = [];
            $contentType = $request->getHeaderLine('Content-Type');
            
            if ($method === 'POST' || $method === 'PUT') {
                $body = (string)$request->getBody();
                
                if (strpos($contentType, 'application/x-www-form-urlencoded') !== false) {
                    parse_str($body, $post);
                } elseif (strpos($contentType, 'multipart/form-data') !== false) {
                    if (preg_match('/boundary=(.+)$/', $contentType, $matches)) {
                        $boundary = $matches[1];
                        $parsed = parseMultipart($body, $boundary);
                        foreach ($parsed as $key => $value) {
                            if (is_array($value) && isset($value['content'])) {
                                $files[$key] = $value;
                            } else {
                                $post[$key] = $value;
                            }
                        }
                    }
                } elseif (strpos($contentType, 'application/json') !== false) {
                    $post = json_decode($body, true) ?: [];
                }
            }
            
            // Parse cookies
            $cookieHeader = $request->getHeaderLine('Cookie');
            $cookies = [];
            if ($cookieHeader) {
                $cookiePairs = explode(';', $cookieHeader);
                foreach ($cookiePairs as $pair) {
                    $pair = trim($pair);
                    if (strpos($pair, '=') !== false) {
                        list($name, $value) = explode('=', $pair, 2);
                        $cookies[$name] = urldecode($value);
                    }
                }
            }
            
            $result = $runner->process($serverVars, $get, $post, $files, $cookies);

            // Extract response
			$statusCode = $result["status"];
            $content = $result["content"] ?? '';
            $headers = $result["headers"] ?? [];
            $responseCookies = $result["cookies"] ?? []; // Array of cookies to set
			            
            logRequest($method, $path, $statusCode, microtime(true) - $startTime);
            
            return new Response($statusCode, $headers, $content);
            
        } catch (Exception $e) {
            logRequest($method, $path, 500, microtime(true) - $startTime);
            return errorResponse(500, "SartajPHP Error: " . $e->getMessage());
        }
    }
    
    // ==================== Process Static Files ====================
    // Default to index.html for root path
    if ($path === '/' || $path === '') {
        foreach ($config['index_files'] as $indexFile) {
            $indexPath = $config['document_root'] . '/' . $indexFile;
            if (file_exists($indexPath) && !is_dir($indexPath)) {
                $filePath = $indexPath;
                $path = '/' . $indexFile;
                break;
            }
        }
        if (!isset($filePath)) {
            logRequest($method, $path, 404, microtime(true) - $startTime);
            return errorResponse(404, "No index file found");
        }
    } else {
        $filePath = $config['document_root'] . $path;
    }
    
    // Security: Check if file is within document root
    $realFilePath = realpath($filePath);
    $realDocumentRoot = realpath($config['document_root']);
    
    if ($realFilePath === false || strpos($realFilePath, $realDocumentRoot) !== 0) {
        logRequest($method, $path, 403, microtime(true) - $startTime);
        return errorResponse(403, "Access denied");
    }
    
    // Check if it's a directory
    if (is_dir($realFilePath)) {
        foreach ($config['index_files'] as $indexFile) {
            $indexPath = $realFilePath . '/' . $indexFile;
            if (file_exists($indexPath)) {
                $realFilePath = $indexPath;
                break;
            }
        }
        if (is_dir($realFilePath)) {
            logRequest($method, $path, 404, microtime(true) - $startTime);
            return errorResponse(404, "Directory listing denied");
        }
    }
    
    // Check if file exists
    if (!file_exists($realFilePath)) {
        logRequest($method, $path, 404, microtime(true) - $startTime);
        return errorResponse(404, "File not found");
    }
    
    // Check file size
    $fileSize = filesize($realFilePath);
    if ($fileSize > $config['max_file_size']) {
        logRequest($method, $path, 413, microtime(true) - $startTime);
        return errorResponse(413, "File too large");
    }
    
    // Get MIME type
    $ext = strtolower(pathinfo($realFilePath, PATHINFO_EXTENSION));
    $mimeType = $mimeTypes[$ext] ?? 'application/octet-stream';
    
    // Build headers
    $headers = ['Content-Type' => $mimeType];
    
    if ($config['cache_control']) {
        $headers['Cache-Control'] = 'public, max-age=3600';
        $headers['Last-Modified'] = gmdate('D, d M Y H:i:s', filemtime($realFilePath)) . ' GMT';
    }
    
    // Read file
    $content = file_get_contents($realFilePath);
    if ($content === false) {
        logRequest($method, $path, 500, microtime(true) - $startTime);
        return errorResponse(500, "Error reading file");
    }
    
    // Optional GZIP compression
    if ($config['enable_gzip'] && in_array($ext, ['html', 'css', 'js', 'json', 'xml', 'txt'])) {
        $acceptEncoding = $request->getHeaderLine('Accept-Encoding');
        if (strpos($acceptEncoding, 'gzip') !== false) {
            $content = gzencode($content, 6);
            $headers['Content-Encoding'] = 'gzip';
            $headers['Vary'] = 'Accept-Encoding';
        }
    }
    
    $headers['Content-Length'] = strlen($content);
    
    logRequest($method, $path, 200, microtime(true) - $startTime);
    
    return new Response(200, $headers, $content);
});

// ==================== Create Socket Server ====================
$socket = new SocketServer("{$config['host']}:{$config['port']}");
$http->listen($socket);

// ==================== Display Server Info ====================
echo "\n" . str_repeat("=", 60) . "\n";
echo "🚀 ReactPHP + SartajPHP Server Started\n";
echo str_repeat("=", 60) . "\n";
echo "📍 Host:     http://{$config['host']}:{$config['port']}\n";
echo "📁 Root:     " . realpath($config['document_root']) . "\n";
echo "⚡ Status:   Running\n";
echo "🔄 Press Ctrl+C to stop\n";
echo str_repeat("=", 60) . "\n\n";

// ==================== Graceful Shutdown ====================
$loop = React\EventLoop\Loop::get();
// Keep the server running
$loop->run();
