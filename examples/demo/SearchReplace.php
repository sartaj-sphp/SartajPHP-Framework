
<?php
/**
 * SearchReplace.php
 *
 * Global project Find & Replace.
 * Reads all replacements from camelcase_map.php.
 *
 * Replaces text everywhere, including:
 * PHP code, comments, strings, HTML and JavaScript.
 */

class SearchReplace
{
    private $root;
    private $map;

    private $backup = true;
    private $dryRun = true;

    // Folders to exclude (case-insensitive)
    private $skipFolders = [
        'vendor',
        'node_modules',
        '.git',
        '.svn',
        '.idea',
        '.vscode',
        'cache',
        'tmp',
        'temp',
        'logs',
        'backup',
        'backups'
    ];

    // Specific files to exclude
    private $skipFiles = [
        'camelcase_map.php'
    ];

    private $stats = [
        'files'        => 0,
        'skipped'      => 0,
        'modified'     => 0,
        'replacements' => 0,
        'errors'       => []
    ];

    public function __construct($root, $mapFile)
    {
        $this->root = rtrim($root, '/\\');

        if (!file_exists($mapFile)) {
            throw new RuntimeException(
                "Replacement map not found: " . $mapFile
            );
        }

        $this->map = require $mapFile;

        if (!is_array($this->map)) {
            throw new RuntimeException(
                "Invalid replacement map."
            );
        }

        $this->validateMap();
    }

    /**
     * Validate and sort replacement dictionary.
     */
    private function validateMap()
    {
        $valid = [];

        foreach ($this->map as $old => $new) {

            if (!is_string($old) || !is_string($new)) {
                continue;
            }

            if ($old === '' || $old === $new) {
                continue;
            }

            $valid[$old] = $new;
        }

        // Longest search words first
        uksort($valid, function ($a, $b) {
            return strlen($b) - strlen($a);
        });

        $this->map = $valid;
    }

    /**
     * Check whether a folder should be skipped.
     */
    private function shouldSkipFolder($folder)
    {
        return in_array(
            strtolower($folder),
            array_map('strtolower', $this->skipFolders),
            true
        );
    }

    /**
     * Check whether a file should be skipped.
     */
    private function shouldSkipFile($file)
    {
        return in_array(
            strtolower(basename($file)),
            array_map('strtolower', $this->skipFiles),
            true
        );
    }

    /**
     * Add folders to exclusion list.
     */
    public function addSkipFolders($folders)
    {
        if (!is_array($folders)) {
            $folders = explode(',', $folders);
        }

        foreach ($folders as $folder) {

            $folder = trim($folder, " \t\n\r\0\x0B/\\.");

            if ($folder !== '' && !$this->shouldSkipFolder($folder)) {
                $this->skipFolders[] = $folder;
            }
        }

        return $this;
    }

    /**
     * Add files to exclusion list.
     */
    public function addSkipFiles($files)
    {
        if (!is_array($files)) {
            $files = explode(',', $files);
        }

        foreach ($files as $file) {

            $file = trim($file);

            if ($file !== '') {
                $this->skipFiles[] = $file;
            }
        }

        return $this;
    }

    /**
     * Replace all dictionary entries in text.
     */
    private function replaceText($content)
    {
        $count = 0;

        $result = str_replace(
            array_keys($this->map),
            array_values($this->map),
            $content,
            $count
        );

        return [
            'content' => $result,
            'count'   => $count
        ];
    }

    /**
     * Process a single file.
     */
    private function processFile($file)
    {
        $this->stats['files']++;

        $content = file_get_contents($file);

        if ($content === false) {
            $this->stats['errors'][] = $file;
            return;
        }

        $result = $this->replaceText($content);

        if ($result['count'] === 0) {
            return;
        }

        $this->stats['replacements'] += $result['count'];

        if ($this->dryRun) {
            echo "[CHECK] " . $file .
                " (" . $result['count'] . " replacements)\n";

            return;
        }

        // Backup original file
        if ($this->backup) {

            $backupFile = $file . '.bak';

            if (!file_exists($backupFile)) {

                if (!copy($file, $backupFile)) {
                    $this->stats['errors'][] = $file;
                    return;
                }
            }
        }

        // Write modified content
        if (file_put_contents(
            $file,
            $result['content']
        ) === false) {

            $this->stats['errors'][] = $file;
            return;
        }

        $this->stats['modified']++;

        echo "[UPDATED] " . $file .
            " (" . $result['count'] . " replacements)\n";
    }

    /**
     * Scan and replace throughout the project.
     */
    public function run()
    {
        $directory = new RecursiveDirectoryIterator(
            $this->root,
            FilesystemIterator::SKIP_DOTS
        );

        // Filter directories before recursion.
        $filter = new RecursiveCallbackFilterIterator(
            $directory,
            function ($current, $key, $iterator) {

                if ($current->isDir()) {

                    if ($this->shouldSkipFolder(
                        $current->getFilename()
                    )) {
                        return false;
                    }
                }

                return true;
            }
        );

        $iterator = new RecursiveIteratorIterator($filter);

        foreach ($iterator as $file) {

            if (!$file->isFile()) {
                continue;
            }

            // PHP and Front files only
            if (!$this->checkExtension(
                $file->getExtension(),
                'php,front'
            )) {
                continue;
            }

            $path = $file->getPathname();

            // Skip backup files
            if (substr(strtolower($path), -4) === '.bak') {
                continue;
            }

            // Skip excluded files
            if ($this->shouldSkipFile($path)) {
                $this->stats['skipped']++;
                continue;
            }

            $this->processFile($path);
        }

        return $this->stats;
    }

    public function checkExtension($extcheck, $exts = 'php')
    {
        $v1 = explode(',', strtolower($exts));
        $extcheck = strtolower($extcheck);

        foreach ($v1 as $v) {
            if ($extcheck == trim($v)) {
                return true;
            }
        }

        return false;
    }

    public function setBackup($enabled)
    {
        $this->backup = (bool) $enabled;
        return $this;
    }

    public function setDryRun($enabled)
    {
        $this->dryRun = (bool) $enabled;
        return $this;
    }
}


// =====================================
// RUN
// =====================================

$root = __DIR__;

$replace = new SearchReplace(
    $root,
    $root . '/camelcase_map.php'
);

// Add additional excluded folders if required
$replace->addSkipFolders([
'vendor',
'vendor1',
    'node_modules',
    'cache',
    'public',
    'storage',
    'uploads',
    'dist',
    'build',
	'docs',
	'docs2'
]);

// Add additional excluded files if required
$replace->addSkipFiles([
    'camelcase_map.php',
    'SearchReplace.php'
]);

// Preview first
$replace->setDryRun(false);

// Backup original files
$replace->setBackup(false);

$result = $replace->run();

echo "\n========== RESULT ==========\n";

echo "Scanned files: " . $result['files'] . "\n";
echo "Skipped files: " . $result['skipped'] . "\n";
echo "Modified files: " . $result['modified'] . "\n";
echo "Total replacements: " . $result['replacements'] . "\n";

if (!empty($result['errors'])) {
    echo "\nErrors:\n";
    print_r($result['errors']);
}
