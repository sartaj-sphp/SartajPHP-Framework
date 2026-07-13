<?php
/**
 * AiInfo Gate - Artificial Intelligence Information Helper Gate
 * ============================================================
 * 
 * PURPOSE:
 * This gate serves as a structured interface for AI models to understand,
 * inspect, and interact with SartajPHP Framework projects. It provides
 * real-time introspection of database structures, code components, and
 * framework configuration.
 * 
 * WHY THIS GATE EXISTS:
 * - Enables AI models to understand your specific project structure
 * - Provides standardized JSON responses for machine consumption
 * - Allows AI to generate accurate code based on actual database schemas
 * - Bridges the gap between generic AI knowledge and your project specifics
 * 
 * HOW AI MODELS USE THIS GATE:
 * 1. AI sends command to execute this gate with specific event
 * 2. This gate returns structured data about your project
 * 3. AI analyzes the data and provides intelligent assistance
 * 4. AI can generate code that matches your exact project structure
 * 
 * COMMAND LINE USAGE:
 * php -f start.php -- --gate aiinfo --evt {event_name} --evtp {parameter}
 * 
 * WEB ACCESS (if enabled):
 * http://yourdomain.com/{basepath}/aiinfo-{event}-{parameter}.html
 * 
 * @package SartajPHP
 * @subpackage Gates
 * @author Your Name
 * @version 2.0.0
 */

class AiInfo extends \Sphp\tools\ConsoleGate {
    
    /**
     * ============================================================
     * LIFECYCLE HOOKS
     * ============================================================
     */
    
    /**
     * onstart() - Executes when gate is first loaded
     * 
     * PURPOSE:
     * - Validates execution environment
     * - Sets up security restrictions
     * - Initializes gate-specific settings
     * 
     * WHY THIS EXISTS:
     * The aiinfo gate provides sensitive project information. We restrict
     * it to CLI only by default to prevent unauthorized web access to
     * database schemas and internal structures.
     * 
     * TO ENABLE WEB ACCESS (NOT RECOMMENDED FOR PRODUCTION):
     * Comment out the restriction lines below and add authentication.
     * 
     * @return void
     */
    public function onstart() {
        // SECURITY: Restrict to command line only by default
        // AI models should call this via CLI for security
        if ($this->Client->mode != "CLI") {
            echo "SECURITY: This Gate can only be called from Command Line\n";
            echo "For AI assistance, use: php -f start.php -- --gate aiinfo --evt help\n";
            \SphpBase::engine()->exitMe();
        }
        
        // Optional: Add logging to track AI queries
        $this->logAiQuery($_SERVER['argv'] ?? []);
    }
    
    /**
     * Logs AI queries for debugging and improvement
     * 
     * @param array $argv Command line arguments
     * @return void
     */
    private function logAiQuery($argv) {
        $logFile = PROJ_PATH . "/cache/logs/ai_queries.log";
        $logEntry = [
            "timestamp" => date('Y-m-d H:i:s'),
            "command" => implode(" ", $argv),
            "user" => get_current_user()
        ];
        
        // Create log directory if it doesn't exist
        $logDir = dirname($logFile);
        if (!is_dir($logDir)) {
            mkdir($logDir, 0777, true);
        }
        
        file_put_contents($logFile, json_encode($logEntry) . "\n", FILE_APPEND);
    }
    
    /**
     * ============================================================
     * CORE RESPONSE METHODS
     * ============================================================
     */
    
    /**
     * Sends standardized JSON response for AI consumption
     * 
     * WHY JSON:
     * - Structured format that AI models parse easily
     * - Consistent schema enables automated processing
     * - Contains metadata for debugging and context
     * 
     * RESPONSE STRUCTURE:
     * {
     *   "gate": "aiinfo",           // Identifies source
     *   "timestamp": "2024-...",    // When response was generated
     *   "framework": "SartajPHP",   // Framework identifier
     *   "response_type": "info",     // Type of data (table_data, schema, code, error)
     *   "data": {...},               // The actual response content
     *   "metadata": {...}            // Context about the project
     * }
     * 
     * @param mixed $data The response data (array, string, object)
     * @param string $type Type identifier: intro, table_data, schema, code, error, success, validation, api_reference
     * @param array $metadata Additional contextual information
     * @return void
     */
    private function sendAiJsonResponse($data, $type = "info", $metadata = []) {
        // Build the complete response object
        $response = [
            "gate" => "aiinfo",
            "timestamp" => date('Y-m-d H:i:s'),
            "framework" => "SartajPHP",
            "response_type" => $type,
            "data" => $data,
            "metadata" => array_merge([
                "project_path" => PROJ_PATH,
                "php_version" => PHP_VERSION,
                "sartajphp_version" => SphpBase::sphp_api()->getSartajPHPVer(),
                "execution_time_ms" => round((microtime(true) - $_SERVER['REQUEST_TIME_FLOAT']) * 1000)
            ], $metadata)
        ];
        
        // Output with pretty print for human readability during debugging
        echo json_encode($response, JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES);
    }
    
    /**
     * Sends simple text response (backward compatibility)
     * 
     * @param string $answer The answer text
     * @param string $type Content type: md, json, csv, text
     * @return void
     */
    private function sendToAiModel($answer, $type = "md") {
        $this->sendAiJsonResponse($answer, $type);
    }
    
    /**
     * Sends error response
     * 
     * @param string $errorMessage Optional custom error message
     * @return void
     */
    private function sendError($errorMessage = "Error In Project, So couldn't help") {
        $this->sendAiJsonResponse(["error" => $errorMessage], "error");
    }
    
    /**
     * ============================================================
     * PAGE HANDLERS (Web Access Points)
     * ============================================================
     */
    
    /**
     * page_new() - Default handler for web access
     * URL Pattern: /aiinfo.html or /aiinfo-new.html
     * 
     * PURPOSE:
     * Returns the complete framework introduction documentation.
     * This is the primary way AI models learn about SartajPHP.
     * 
     * WHAT IT RETURNS:
     * - YAML frontmatter (title, description, version, source)
     * - Complete framework documentation in markdown
     * - Framework capabilities and patterns
     * 
     * @return void
     */
    public function page_new() {
        // Disable default front file sending (we send raw data)
        $this->showNotFrontFile();
        
        // Path to the introduction documentation
        $introPath = $this->mypath . "/aidocs/intro.md";
        
        if (!file_exists($introPath)) {
            $this->sendError("Intro documentation not found at: " . $introPath);
            return;
        }
        
        $introContent = file_get_contents($introPath);
        
        // Parse YAML frontmatter from markdown file
        // Frontmatter format:
        // ---
        // title: Document Title
        // description: Description here
        // version: 1.0.0
        // ---
        // Rest of the content...
        $yamlData = [];
        $mainContent = $introContent;
        
        if (preg_match('/^---\n(.*?)\n---\n(.*)$/s', $introContent, $matches)) {
            // Parse YAML (simple line-by-line parsing)
            $lines = explode("\n", $matches[1]);
            foreach ($lines as $line) {
                $line = trim($line);
                if (empty($line)) continue;
                
                if (strpos($line, ':') !== false) {
                    list($key, $value) = explode(':', $line, 2);
                    $yamlData[trim($key)] = trim($value);
                }
            }
            $mainContent = $matches[2];
        }
        
        // Send structured response
        $this->sendAiJsonResponse([
            "title" => $yamlData['title'] ?? "SartajPHP Framework Documentation",
            "description" => $yamlData['description'] ?? "Complete framework guide",
            "version" => $yamlData['version'] ?? "1.0.0",
            "source" => $yamlData['source'] ?? "",
            "content" => $mainContent,
            "globs" => isset($yamlData['globs']) ? explode("\n", $yamlData['globs']) : []
        ], "intro");
    }
    
    /**
     * ============================================================
     * DATABASE INTROSPECTION EVENTS
     * ============================================================
     */
    
    /**
     * page_event_lastten() - Get last 10 rows from any table
     * 
     * COMMAND:
     * php -f start.php -- --gate aiinfo --evt lastten --evtp users
     * 
     * PURPOSE:
     * Allows AI to inspect actual data in your database tables.
     * This helps AI understand:
     * - What data formats look like (dates, strings, numbers)
     * - Sample values for generating realistic test data
     * - Table structure from actual rows
     * 
     * USE CASE:
     * When AI needs to generate a report or dashboard, it can first
     * inspect actual data to understand field types and formats.
     * 
     * @param string $evtp Table name (e.g., "users", "products", "orders")
     * @return void
     */
    public function page_event_lastten($evtp) {
        // Validate table name to prevent SQL injection
        $tableName = preg_replace('/[^a-zA-Z0-9_]/', '', $evtp);
        
        if (empty($tableName)) {
            $this->sendError("Invalid table name provided");
            return;
        }
        
        // Query last 10 rows
        $result = $this->dbEngine->executeQueryQuick(
            "SELECT * FROM `$tableName` ORDER BY id DESC LIMIT 10"
        );
        
        if ($this->dbEngine->is_rows($result)) {
            // Convert to CSV format for easy parsing by AI
            // CSV is preferred because:
            // 1. Easy for AI to parse
            // 2. Handles special characters well
            // 3. Maintains column structure
            $csvHandle = fopen('php://temp', 'r+');
            
            // Get column headers first
            $firstRow = $this->dbEngine->row_fetch_assoc($result);
            if ($firstRow) {
                fputcsv($csvHandle, array_keys($firstRow));
                fputcsv($csvHandle, array_values($firstRow));
            }
            
            // Fetch remaining rows
            while ($row = $this->dbEngine->row_fetch_assoc($result)) {
                fputcsv($csvHandle, array_values($row));
            }
            
            rewind($csvHandle);
            $csvString = stream_get_contents($csvHandle);
            fclose($csvHandle);
            
            $this->sendAiJsonResponse([
                "table" => $tableName,
                "row_count" => $this->dbEngine->num_rows($result),
                "data_csv" => $csvString,
                "columns" => array_keys($firstRow ?? [])
            ], "table_data");
            return;
        }
        
        if (getCheckErr()) {
            $this->sendError("Database error: " . $this->dbEngine->getLastError());
        } else {
            $this->sendAiJsonResponse([
                "table" => $tableName,
                "row_count" => 0,
                "message" => "Table is empty or doesn't exist"
            ], "table_data");
        }
    }
    
    /**
     * page_event_table_list() - Get complete database schema
     * 
     * COMMAND:
     * php -f start.php -- --gate aiinfo --evt table_list
     * 
     * PURPOSE:
     * Returns the entire database structure including:
     * - All table names
     * - Column definitions for each table
     * - Data types, constraints, keys
     * - Default values and nullability
     * 
     * WHY THIS IS CRITICAL FOR AI:
     * AI needs to know your exact schema to:
     * - Generate accurate models
     * - Create proper SQL queries
     * - Build forms with correct field types
     * - Implement validation rules
     * 
     * OUTPUT FORMAT EXAMPLE:
     * {
     *   "users": [
     *     {"Field": "id", "Type": "int(11)", "Key": "PRI", "Extra": "auto_increment"},
     *     {"Field": "email", "Type": "varchar(255)", "Key": "UNI", "Null": "NO"}
     *   ],
     *   "products": [...]
     * }
     * 
     * @param string $evtp Not used (kept for consistency)
     * @return void
     */
    public function page_event_table_list($evtp) {
        $this->dbEngine->connect();
        $schema = $this->getFullDatabaseSchema();
        $this->dbEngine->disconnect();
        
        $this->sendAiJsonResponse($schema, "database_schema");
    }
    /**
     * Get Table Structure
     * php -f start.php -- --gate aiinfo --evt table_schema --evtp table1
     * @param string $evtp Table name
     */
    public function page_event_table_schema($evtp) {
        $this->dbEngine->connect();
        $schema = $this->getTableSchema($evtp);
        $this->dbEngine->disconnect();
        
        $this->sendAiJsonResponse($schema, "table_schema");
    }
    /**
     * Get Import Table Data SQL as Insert Query. --where is optional
     * php -f start.php -- --gate aiinfo --evt table_sql --evtp table1 --where "WHERE id=1"
     * @param string $evtp Table name
     */
    public function page_event_table_sql($evtp) {
        $where = $this->consoleReadArgument("--where");
        $this->dbEngine->connect();
        $schema =  $this->dbEngine->getTableSQL($evtp,$where);
        $this->dbEngine->disconnect();
        echo $schema;
    }
    /**
     * Get Create Table SQL
     * php -f start.php -- --gate aiinfo --evt table_create_sql --evtp table1
     * @param string $evtp Table name
     */
    public function page_event_table_create_sql($evtp) {
        $this->dbEngine->connect();
        $schema =  $this->dbEngine->getCreateTableSQL($evtp);
        $this->dbEngine->disconnect();
        echo $schema;
    }
    /**
     * Get full database schema with all tables and columns
     * 
     * @return array Complete schema structure
     */
    private function getFullDatabaseSchema() {
        $schema = [];
        $tables = $this->dbEngine->getDbTables();
        
        if (count($tables) > 0 && is_array($tables)) {
            foreach ($tables as $table) {
                $schema[$table] = $this->getTableSchema($table);
            }
        }
        
        return $schema;
    }
    
    /**
     * Get schema for a single table
     * 
     * @param string $tableName Table name
     * @return array Column definitions
     */
    private function getTableSchema($tableName) {
        $columns = $this->dbEngine->getTableColumns($tableName);
        $schema = [];
        
        if (count($columns) > 0) {
            foreach ($columns as $column) {
                $schema[$column['Field']] = [
                    "type" => $column['Type'],
                    "null" => $column['Null'] === 'YES',
                    "key" => $column['Key'],
                    "default" => $column['Default'],
                    "extra" => $column['Extra']
                ];
            }
        }
        
        return $schema;
    }
    
    /**
     * ============================================================
     * CODE GENERATION EVENTS
     * ============================================================
     */
    
    /**
     * page_event_generateApp() - Generate complete CRUD application
     * 
     * COMMAND:
     * php -f start.php -- --gate aiinfo --evt generateApp --evtp products
     * 
     * PURPOSE:
     * Generates production-ready CRUD code including:
     * - Gate class with standard CRUD operations
     * - Edit form front file
     * - List view front file
     * - Database operations (create, read, update, delete)
     * 
     * WHY AI SHOULD USE THIS:
     * Instead of writing CRUD code from scratch, AI can:
     * 1. Call this method to get a base implementation
     * 2. Analyze the generated code structure
     * 3. Make custom modifications as needed
     * 4. Understand SartajPHP patterns by example
     * 
     * THE GENERATED CODE INCLUDES:
     * - Input fields for each column (based on data type)
     * - Form validation logic
     * - List view with sorting and filtering
     * - AJAX-enabled operations
     * - Proper security measures (CSRF, XSS protection)
     * 
     * @param string $dbtable Database table name to generate CRUD for
     * @return void
     */
    public function page_event_generateApp($dbtable) {
        // Validate table name
        $tableName = preg_replace('/[^a-zA-Z0-9_]/', '', $dbtable);
        
        if (empty($tableName)) {
            $this->sendError("Invalid table name for code generation");
            return;
        }
        
        $this->dbEngine->connect();
        
        // Check if table exists
        $tables = $this->dbEngine->getDbTables();
        if (!in_array($tableName, $tables)) {
            $this->sendError("Table '$tableName' does not exist in database");
            return;
        }
        
        // Include the code generator
        include_once(__DIR__ . "/GenAppFromDb.php");
        $generator = new GenAppFromDb($this->dbEngine);
        
        $gateName = strtolower($tableName);
        $fileBase = PROJ_PATH . "/apps/";
        
        // Define output files
        $files = [
            "edit_front" => $fileBase . "fronts/{$gateName}-edit.front",
            "list_front" => $fileBase . "fronts/{$gateName}-list.front",
            "gate_file" => $fileBase . ucfirst($gateName) . ".gate.php"
        ];
        
        $generatedCode = [];
        
        // Generate edit form
        $generatedCode['edit_front'] = [
            "path" => $files['edit_front'],
            "content" => $generator->getEditForm($tableName, $gateName)
        ];
        
        // Generate list view
        $generatedCode['list_front'] = [
            "path" => $files['list_front'],
            "content" => $generator->getShowForm($tableName, $gateName)
        ];
        
        // Generate gate class
        $generatedCode['gate_file'] = [
            "path" => $files['gate_file'],
            "content" => $generator->getGate($tableName, $gateName)
        ];
        
        $this->dbEngine->disconnect();
        
        // Return the generated code for AI to analyze or use
        $this->sendAiJsonResponse([
            "table" => $tableName,
            "gate_name" => $gateName,
            "generated_files" => $generatedCode,
            "instructions" => [
                "1. Copy these files to your project",
                "2. Register the gate in reg.php: registerGate('$gateName', '{$files['gate_file']}');",
                "3. Access at: http://yourdomain.com/{$gateName}-list.html",
                "4. Database table '{$tableName}' must exist"
            ]
        ], "code_generation");
    }
    
    /**
     * ============================================================
     * COMPONENT AND UI INTROSPECTION
     * ============================================================
     */
    
    /**
     * page_event_codeblocks_list() - Get all available UI code blocks
     * 
     * COMMAND:
     * php -f start.php -- --gate aiinfo --evt codeblocks_list
     * 
     * PURPOSE:
     * Returns all reusable UI components (code blocks) available in the project.
     * Code blocks are pre-designed UI patterns that can be used in Front Files.
     * 
     * WHAT ARE CODE BLOCKS?
     * HTML fragments that can be inserted using special attributes:
     * Example: <div sphp-cb-card="Title">Content here</div>
     * This wraps the content in a Bootstrap card layout.
     * 
     * WHY AI NEEDS THIS:
     * - To suggest appropriate UI patterns
     * - To generate Front Files using available components
     * - To maintain consistent UI across the application
     * 
     * @param string $evtp Not used
     * @return void
     */
    public function page_event_codeblocks_list($evtp) {
        $codeBlocksPath = \SphpBase::sphp_settings()->comp_uikit_path . "/sphpcodeblock.php";
        
        if (!file_exists($codeBlocksPath)) {
            $this->sendAiJsonResponse([
                "available" => false,
                "message" => "UI Kit not found or not installed"
            ], "codeblocks");
            return;
        }
        
        include_once($codeBlocksPath);
        
        if (class_exists('\SphpCodeBlock')) {
            $codeBlocks = \SphpCodeBlock::getCodeBlocks();
            
            $formattedBlocks = [];
            foreach ($codeBlocks as $blockName => $blockData) {
                $formattedBlocks[$blockName] = [
                    "name" => $blockName,
                    "description" => $blockData['description'] ?? "No description",
                    "example" => $blockData['example'] ?? "",
                    "attributes" => $blockData['attributes'] ?? []
                ];
            }
            
            $this->sendAiJsonResponse([
                "available" => true,
                "count" => count($formattedBlocks),
                "code_blocks" => $formattedBlocks,
                "usage_example" => "<div sphp-cb-BlockName=\"Parameter\">Content</div>"
            ], "codeblocks");
        } else {
            $this->sendAiJsonResponse([
                "available" => false,
                "message" => "SphpCodeBlock class not found"
            ], "codeblocks");
        }
    }
    
    /**
     * page_event_component_prop_list() - Get component properties and methods
     * 
     * COMMAND:
     * php -f start.php -- --gate aiinfo --evt component_prop_list --evtp "component_id,<tag>"
     * 
     * PURPOSE:
     * Introspects a component and returns all available:
     * - Public methods (especially fu_* and fi_* methods)
     * - Properties
     * - Event handlers
     * - Available parameters
     * 
     * WHY THIS IS VITAL FOR AI:
     * Components are the building blocks of SartajPHP UI.
     * AI needs to know what methods each component has to:
     * - Generate correct component initialization code
     * - Suggest available event handlers
     * - Set properties properly
     * - Call methods correctly
     * 
     * @param string $evtp Comma-separated: "component_id,component_html_tag"
     * @return void
     */
    public function page_event_component_prop_list($evtp) {
        $parts = explode(",", $evtp);
        $componentId = trim($parts[0] ?? "");
        $componentHtml = trim($parts[1] ?? "");
        
        if (empty($componentId) || empty($componentHtml)) {
            $this->sendError("Invalid component parameters. Format: 'component_id,<tag>'");
            return;
        }
        
        // Create temporary component instance
        $tempFront = new FrontFile($componentHtml, true);
        $component = $tempFront->getComponentSafe($componentId);
        
        if ($component === null) {
            $this->sendError("Component '$componentId' not found in provided HTML");
            return;
        }
        
        // Get component methods using reflection
        $reflection = new \ReflectionClass($component);
        $className = $reflection->getName();
        $methods = [];
        
        // Define methods to exclude (internal framework methods)
        $excludedMethods = [
            '__construct', '__destruct', '__call', '__callStatic',
            '__get', '__set', '__isset', '__unset', '__sleep', '__wakeup',
            '__toString', '__invoke', '__set_state', '__clone', '__debugInfo',
            'onrender', 'onprerender', 'render', 'prerender', 'loadScript',
            'parseHTML', 'onjsrender', 'onprejsrender', 'oncreate',
            'oncompcreate', 'oninit', 'oncompinit', 'executePHPCode',
            'getDynamicContent', 'addDynamicFileLink', 'onaftercreate',
            'onappevent', 'renderLast', 'onchildevent', 'onholder', 'onparse',
            'setClassPath', 'init', 'helpPropList', 'setVersion', 'getVersion',
            'setMinVersionSphp', 'getMinVersionSphp', 'setMaxVersionSphp',
            'getMaxVersionSphp', 'setMinVersionPHP', 'getMinVersionPHP',
            'setMaxVersionPHP', 'getMaxVersionPHP'
        ];
        
        $excludedMap = array_flip($excludedMethods);
        
        foreach ($reflection->getMethods(\ReflectionMethod::IS_PUBLIC) as $method) {
            $methodName = $method->getName();
            
            // Only include fu_* and fi_* methods (user-defined component methods)
            if (substr($methodName, 0, 3) === "fu_" || substr($methodName, 0, 3) === "fi_") {
                if (!isset($excludedMap[$methodName])) {
                    $params = $this->getMethodParameters($method);
                    $methods[$methodName] = [
                        "type" => substr($methodName, 0, 2) === "fu" ? "function" : "filter",
                        "parameters" => $params,
                        "return_type" => (string)$method->getReturnType(),
                        "description" => $this->getMethodDescription($method)
                    ];
                }
            }
        }
        
        // Get component properties
        $properties = [];
        foreach ($reflection->getProperties(\ReflectionProperty::IS_PUBLIC) as $property) {
            $propName = $property->getName();
            if ($propName !== 'frtMain' && $propName !== 'dbEngine') {
                $properties[$propName] = [
                    "type" => $property->getType() ? (string)$property->getType() : "mixed",
                    "default" => $property->getDefaultValue() ?? null
                ];
            }
        }
        
        $this->sendAiJsonResponse([
            "component_id" => $componentId,
            "component_class" => $className,
            "component_type" => get_class($component),
            "available_methods" => $methods,
            "available_properties" => $properties,
            "method_call_example" => "use Fusion Method in Gate File and in PHP: \$this->frtMain->getComponent('{$componentId}')->fu_methodName(\$parameter); in Front File in Tag: <input id=\"txtname\" runat=\"server\" fur-methodName=\"parameter1,|parameter2\" > fu call by fur or fun and fi call by fui or fun"
        ], "component_info");
    }
    
    /**
     * Helper: Get method parameters as array
     * 
     * @param \ReflectionMethod $method Reflection method object
     * @return array Parameters information
     */
    private function getMethodParameters($method) {
        $params = [];
        foreach ($method->getParameters() as $param) {
            $params[] = [
                "name" => $param->getName(),
                "type" => $param->getType() ? (string)$param->getType() : "mixed",
                "optional" => $param->isOptional(),
                "default" => $param->isOptional() ? $param->getDefaultValue() : null
            ];
        }
        return $params;
    }
    
    /**
     * Helper: Get method description from docblock
     * 
     * @param \ReflectionMethod $method Reflection method object
     * @return string Description or empty string
     */
    private function getMethodDescription($method) {
        $docComment = $method->getDocComment();
        if ($docComment) {
            preg_match('/@description\s+(.+)/', $docComment, $matches);
            if (isset($matches[1])) {
                return trim($matches[1]);
            }
            
            // Try to get first line of docblock
            $lines = explode("\n", $docComment);
            foreach ($lines as $line) {
                $line = trim($line, " *\t\n\r\0\x0B");
                if (!empty($line) && $line[0] !== '@') {
                    return $line;
                }
            }
        }
        return "";
    }
    
    /**
     * ============================================================
     * FRAMEWORK STRUCTURE INTROSPECTION
     * ============================================================
     */
    
    /**
     * page_event_framework_structure() - Get complete project structure
     * 
     * COMMAND:
     * php -f start.php -- --gate aiinfo --evt framework_structure
     * 
     * PURPOSE:
     * Returns a comprehensive view of your entire SartajPHP project:
     * - All registered gates and their locations
     * - All front files and their paths
     * - Component libraries available
     * - Current configuration settings
     * 
     * WHY AI NEEDS THIS:
     * To understand the project's architecture without scanning files manually.
     * This enables AI to:
     * - Suggest where to add new code
     * - Understand existing patterns
     * - Maintain consistency with project structure
     * 
     * @param string $evtp Not used
     * @return void
     */
    public function page_event_framework_structure($evtp) {
        $structure = [
            "project" => [
                "path" => PROJ_PATH,
                "name" => basename(PROJ_PATH),
                "php_version" => PHP_VERSION
            ],
            "gates" => $this->scanGates(),
            "front_files" => $this->scanFrontFiles(),
            "components" => $this->scanComponents(),
            "configuration" => $this->getConfiguration(),
            "directory_structure" => $this->getProjectStructure()
        ];
        
        $this->sendAiJsonResponse($structure, "framework_structure");
    }
    
    /**
     * Scan and return all registered gates
     * 
     * @return array List of gates with their details
     */
    private function scanGates() {
        $gates = [];
        $regFile = PROJ_PATH . "/reg.php";
        
        if (file_exists($regFile)) {
            // Parse reg.php to find registered gates
            // This is simplified - you may need to parse actual registration calls
            //$content = file_get_contents($regFile);
            //preg_match_all("/registerGate\s*\(\s*['\"]([^'\"]+)['\"]\s*,\s*['\"]([^'\"]+)['\"]/", $content, $matches);
            $argates = SphpBase::sphp_api()->getRegisteredGates();
                foreach ($argates as $gate=>$val) {
                    $gates[] = [
                        "name" => $gate,
                        "path" => $val[0],
                        "exists" => file_exists($val[0])
                    ];
                }
            }
        
        return $gates;
    }
    
    /**
     * Scan for all front files in the project
     * 
     * @return array List of front files
     */
    private function scanFrontFiles() {
        $frontFiles = [];
        $frontDir = PROJ_PATH . "/apps/fronts/";
        
        if (is_dir($frontDir)) {
            $files = glob($frontDir . "*.front");
            foreach ($files as $file) {
                $frontFiles[] = [
                    "name" => basename($file),
                    "path" => $file,
                    "size" => filesize($file),
                    "modified" => date("Y-m-d H:i:s", filemtime($file))
                ];
            }
        }
        
        return $frontFiles;
    }
    
    /**
     * Scan for available components
     * 
     * @return array List of components
     */
    private function scanComponents() {
        $components = [];
        $compPath = \SphpBase::sphp_settings()->comp_path ?? PROJ_PATH . "/components/";
        
        if (is_dir($compPath)) {
            $files = glob($compPath . "*.comp.php");
            foreach ($files as $file) {
                $components[] = [
                    "name" => basename($file, ".comp.php"),
                    "path" => $file,
                    "class" => basename($file, ".comp.php") . "Comp"
                ];
            }
        }
        
        return $components;
    }
    
    /**
     * Get current configuration settings
     * 
     * @return array Configuration values
     */
    private function getConfiguration() {
        global $masterf,$mebmasterf;
        $settings = SphpBase::sphp_settings();
        return [
            "basepath" => $settings->getBase_path(),
            "debug_mode" => $settings->getDebug_mode() ?? 0,
            "master_file" => $masterf ?? "",
            "member_master" => $mebmasterf ?? "",
            "timezone" => date_default_timezone_get(),
            "db_configured" => !empty($settings->getDb())
        ];
    }
    
    /**
     * Get project directory structure (limited depth)
     * 
     * @param string $dir Starting directory
     * @param int $depth Current depth
     * @return array Directory structure
     */
    private function getProjectStructure($dir = null, $depth = 0) {
        if ($depth > 2) return ["..."]; // Limit depth
        
        $dir = $dir ?? PROJ_PATH;
        $structure = [];
        
        $items = scandir($dir);
        foreach ($items as $item) {
            if ($item[0] === '.') continue; // Skip hidden files
            
            $fullPath = $dir . "/" . $item;
            
            if (is_dir($fullPath)) {
                $structure[$item] = $this->getProjectStructure($fullPath, $depth + 1);
            } elseif (in_array(pathinfo($item, PATHINFO_EXTENSION), ['gate.php', 'front', 'app', 'php'])) {
                $structure[] = $item;
            }
        }
        
        return $structure;
    }
    
    /**
     * ============================================================
     * CODE VALIDATION AND ANALYSIS
     * ============================================================
     */
    
    /**
     * page_event_validate_code() - Validate and analyze PHP code
     * 
     * COMMAND:
     * php -f start.php -- --gate aiinfo --evt validate_code --evtp "base64_encoded_code"
     * 
     * PURPOSE:
     * Performs comprehensive code validation:
     * - Syntax checking
     * - SartajPHP pattern compliance
     * - Security best practices
     * - Performance recommendations
     * 
     * WHY AI SHOULD USE THIS:
     * Before generating code, AI can validate that:
     * - Code follows SartajPHP conventions
     * - No security vulnerabilities
     * - Uses correct APIs (no superglobals)
     * - Proper error handling
     * 
     * @param string $base64Code Base64 encoded PHP code
     * @return void
     */
    public function page_event_validate_code($base64Code) {
        $code = base64_decode($base64Code);
        
        if (empty($code)) {
            $this->sendError("No code provided or invalid base64 encoding");
            return;
        }
        
        $errors = [];
        $warnings = [];
        $suggestions = [];
        
        // 1. Syntax check using PHP linter
        $tempFile = tempnam(sys_get_temp_dir(), 'sartaj_val_');
        file_put_contents($tempFile, '<?php ' . $code);
        
        exec("php -l " . escapeshellarg($tempFile) . " 2>&1", $output, $returnCode);
        if ($returnCode !== 0) {
            $errors['syntax'] = implode("\n", $output);
        }
        
        // 2. Check for superglobal usage (security violation in SartajPHP)
        $superglobals = ['$_POST', '$_GET', '$_REQUEST', '$_SESSION', '$_COOKIE', '$_FILES', '$_SERVER'];
        foreach ($superglobals as $superglobal) {
            if (strpos($code, $superglobal) !== false) {
                $errors['superglobals'][] = "Use \$this->Client->" . strtolower(trim($superglobal, '$_')) . "() instead of $superglobal";
            }
        }
        
        // 3. Check for proper SartajPHP patterns
        if (strpos($code, 'class ') !== false && strpos($code, 'extends') === false) {
            if (strpos($code, 'Gate') !== false) {
                $warnings['missing_extends'] = "Gate classes should extend BasicGate, NativeGate, or ConsoleGate";
            }
        }
        
        // 4. Check for SQL injection vulnerabilities
        if (preg_match('/\$this->dbEngine->executeQueryQuick\s*\(\s*["\']SELECT.*?\$/', $code)) {
            $warnings['sql_injection'] = "Variable interpolation in SQL query - use prepared statements";
            $suggestions[] = "Use \$this->dbEngine->executeQuery('SELECT * FROM users WHERE id = ?', [\$id])";
        }
        
        // 5. Check front file patterns (no PHP tags)
        if (strpos($code, '<?php') !== false && (strpos($code, '.front') !== false || strpos($tempFile, '.front') !== false)) {
            $errors['front_file_php'] = "Front files cannot contain PHP tags (<?php)";
        }
        
        unlink($tempFile);
        
        $this->sendAiJsonResponse([
            "valid" => empty($errors),
            "errors" => $errors,
            "warnings" => $warnings,
            "suggestions" => $suggestions,
            "code_length" => strlen($code),
            "line_count" => substr_count($code, "\n") + 1
        ], "validation");
    }
    
    /**
     * ============================================================
     * HELP AND DOCUMENTATION
     * ============================================================
     */
    
    /**
     * page_event_help() - Display available commands
     * 
     * COMMAND:
     * php -f start.php -- --gate aiinfo --evt help
     * 
     * PURPOSE:
     * Shows all available events and their usage.
     * Acts as a self-documentation endpoint for AI models.
     * 
     * @param string $evtp Optional specific command to get help for
     * @return void
     */
    public function page_event_help($evtp = "") {
        $commands = [
            "new" => [
                "description" => "Get complete framework introduction and documentation",
                "params" => "none",
                "example" => "php -f start.php -- --gate aiinfo --evt new"
            ],
            "lastten" => [
                "description" => "Get last 10 rows from any database table",
                "params" => "table_name",
                "example" => "php -f start.php -- --gate aiinfo --evt lastten --evtp users"
            ],
            "table_list" => [
                "description" => "Get complete database schema with all tables and columns",
                "params" => "none",
                "example" => "php -f start.php -- --gate aiinfo --evt table_list"
            ],
            "generateApp" => [
                "description" => "Generate complete CRUD application from database table",
                "params" => "table_name",
                "example" => "php -f start.php -- --gate aiinfo --evt generateApp --evtp products"
            ],
            "codeblocks_list" => [
                "description" => "List all available UI code blocks",
                "params" => "none",
                "example" => "php -f start.php -- --gate aiinfo --evt codeblocks_list"
            ],
            "component_prop_list" => [
                "description" => "Get component properties and methods",
                "params" => "component_id,component_html",
                "example" => "php -f start.php -- --gate aiinfo --evt component_prop_list --evtp \"myInput,<input id='myInput' type='text'>\""
            ],
            "framework_structure" => [
                "description" => "Get complete project structure overview",
                "params" => "none",
                "example" => "php -f start.php -- --gate aiinfo --evt framework_structure"
            ],
            "validate_code" => [
                "description" => "Validate PHP code for syntax and SartajPHP patterns",
                "params" => "base64_encoded_code",
                "example" => "php -f start.php -- --gate aiinfo --evt validate_code --evtp \"PD9waHAgLy8gY29kZSBoZXJl\""
            ],
            "help" => [
                "description" => "Show this help message",
                "params" => "optional_command_name",
                "example" => "php -f start.php -- --gate aiinfo --evt help --evtp generateApp"
            ]
        ];
        
        if (!empty($evtp) && isset($commands[$evtp])) {
            $this->sendAiJsonResponse([
                "command" => $evtp,
                "details" => $commands[$evtp]
            ], "help");
        } else {
            $this->sendAiJsonResponse([
                "available_commands" => $commands,
                "total_commands" => count($commands),
                "base_command" => "php -f start.php -- --gate aiinfo --evt {command} --evtp {parameter}",
                "response_format" => "All responses are JSON with 'data' containing the results"
            ], "help");
        }
    }
}

/**
 * ============================================================
 * SUMMARY FOR AI MODELS
 * ============================================================
 * 
 * HOW TO USE THIS GATE:
 * 
 * 1. DISCOVERY PHASE:
 *    - First call: --evt help (to see all capabilities)
 *    - Then call: --evt framework_structure (to understand project)
 *    - Then call: --evt table_list (to understand database)
 * 
 * 2. CODE GENERATION PHASE:
 *    - Call --evt generateApp --evtp {table} to get base CRUD
 *    - Call --evt component_prop_list to understand components
 *    - Call --evt codeblocks_list for UI patterns
 * 
 * 3. VALIDATION PHASE:
 *    - Call --evt validate_code to check generated code
 * 
 * 4. CONTINUOUS LEARNING:
 *    - The more you use this gate, the better you understand
 *      the specific project structure and patterns
 * 
 * RESPONSE TYPES:
 * - intro: Framework documentation
 * - table_data: Database query results
 * - database_schema: Complete table structures
 * - code_generation: Generated application code
 * - codeblocks: UI component library info
 * - component_info: Component introspection
 * - framework_structure: Project overview
 * - validation: Code analysis results
 * - help: Command documentation
 * - error: Error messages
 * 
 * SECURITY NOTES:
 * - This gate is restricted to CLI only by default
 * - Never expose this gate on production web servers
 * - All responses include project structure - keep secure
 * 
 * @version 2.0.0
 * @date 2024
 */
