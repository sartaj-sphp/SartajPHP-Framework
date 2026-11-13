<?php
namespace Sphp\Lib{
/**
* Description of DIR
*
* @author SARTAJ
*
* Utility class for directory and file operations. Provides helpers to check
* and create directories (including recursive creation), copy directories
* (optionally only changed files), search for files by name, count
* subdirectories and files, recursively walk a directory tree invoking a
* callback, resolve parent directory paths and names, and recursively delete
* a directory tree. Supports ignore lists for folders, files and file
* extensions, with an optional "reverse" mode that inverts the ignore logic.
*/
class Dir {
public $arr = Array();
/**
* Checks whether the given path exists and is a directory.
*
* @param string $dirPath Path to check.
* @return bool True if the path exists and is a directory, otherwise false.
*/
public static function directoryExists($dirPath){}
/**
* Creates a single directory with 0775 permissions if it does not exist yet.
*
* @param string $dirPath Path of the directory to create.
* @return bool True if the directory was created, otherwise false.
*/
public static function directoryCreate($dirPath){}
/**
* Recursively creates a directory path, creating all missing parent
* directories first.
*
* @param string $dirPath Full path of the directory to create.
* @return bool True if the directory was created, otherwise false.
*/
public function directoriesCreate($dirPath){}
/**
* Checks whether a folder name is present in the ignore list.
*
* @param string $folder Folder name to check.
* @param array $ignoreFolder List of folder names to ignore.
* @return bool True if the folder is in the ignore list, otherwise false.
*/
public function isIgnoreFolder($folder,$ignoreFolder=array()) {}
/**
* Checks whether a file name is present in the ignore list.
*
* @param string $file File name to check.
* @param array $ignoreFile List of file names to ignore.
* @return bool True if the file is in the ignore list, otherwise false.
*/
public function isIgnoreFile($file,$ignoreFile=array()) {}
/**
* Checks whether a file extension is present in the ignore list.
*
* @param string $extention File extension to check.
* @param array $ignoreFileExtentions List of file extensions to ignore.
* @return bool True if the extension is in the ignore list, otherwise false.
*/
public function isIgnoreFileExtention($extention,$ignoreFileExtentions=array()) {}
/**
* Checks whether a folder name is NOT in the given list (an empty list
* means nothing is excluded).
*
* @param string $folder Folder name to check.
* @param array $lstFolder List of folder names to keep.
* @return bool True if the list is empty or the folder is in the list, otherwise false.
*/
public function isNotIgnoreFolder($folder,$lstFolder=array()) {}
/**
* Recursively copies a directory tree from source to destination, applying
* folder, file and extension ignore rules (optionally inverted via $rev).
* Copies that succeed are recorded in the $arr property.
*
* @param string $src Source directory path.
* @param string $dst Destination directory path.
* @param string $fixdst Optional fixed destination path for files.
* @param bool $rev If true, inverts the ignore logic.
* @param array $ignext List of file extensions to ignore.
* @param array $ignfiles List of file names to ignore.
* @param array $ignfolders List of folder names to ignore.
* @return bool True when the copy operation has been processed.
*/
public function directoryCopy($src,$dst,$fixdst="",$rev=false,$ignext=array(),$ignfiles=array(),$ignfolders=array()){}
/**
* Recursively copies only changed files (missing or newer in the source)
* from source to destination, applying folder, file and extension ignore
* rules (optionally inverted via $rev).
*
* @param string $src Source directory path.
* @param string $dst Destination directory path.
* @param bool $rev If true, inverts the ignore logic.
* @param array $ignext List of file extensions to ignore.
* @param array $ignfiles List of file names to ignore.
* @param array $ignfolders List of folder names to ignore.
* @return bool False if the source does not exist, otherwise true.
*/
public function directoryCopyChanges($src,$dst,$rev=false,$ignext=array(),$ignfiles=array(),$ignfolders=array()){}
/**
* Recursively searches a directory tree for files whose names contain the
* given search string, applying folder, file and extension ignore rules
* (optionally inverted via $rev).
*
* @param string $path Directory path to search in.
* @param string $search Search string to match against file names.
* @param bool $rev If true, inverts the ignore logic.
* @param array $ignext List of file extensions to ignore.
* @param array $ignfiles List of file names to ignore.
* @param array $ignfolders List of folder names to ignore.
* @return array Array of [directory, fileName] pairs for matching files.
*/
public function directorySearch($path,$search,$rev=false,$ignext=array(),$ignfiles=array(),$ignfolders=array())
{}
/**
* Lists the subdirectory names directly inside the given directory, sorted
* alphabetically.
*
* @param string $src Directory path to inspect.
* @return array Sorted array of subdirectory names.
*/
public function directoryCount($src)
{}
/**
* Lists the file names directly inside the given directory, sorted
* alphabetically.
*
* @param string $src Directory path to inspect.
* @return array Sorted array of file names.
*/
public function fileCount($src)
{}
/**
* Recursively walks a directory tree and invokes the given callback for
* every file found.
*
* @param string $projectUrl Base project URL/path.
* @param string $subpath Sub path relative to the project URL.
* @param callable|null $callback Callback invoked with (subpath, fileName) for each file.
* @return void
*/
public function RecursiveSearch($projectUrl,$subpath,$callback=null){}
/**
* Returns the parent directory path of the given path, preserving the
* original slash style (backslashes or forward slashes).
*
* @param string $path Path to resolve the parent of.
* @return string Parent directory path with a trailing slash.
*/
public function getParentDirectory($path) {}
/**
* Returns the name of the parent directory of the given path.
*
* @param string $path Path to resolve the parent directory name of.
* @return string Name of the parent directory.
*/
public function getParentDirectoryName($path) {}
/**
* Recursively deletes a directory and all of its contents.
*
* @param string $dirname Directory path to delete.
* @return bool False if the directory handle could not be opened, otherwise true.
*/
public function directoryDelete($dirname) {}
}
}