<?php
namespace Sphp\Lib{
/**
* Description of FileIO
*
* @author SARTAJ
*
* FileIo is a static utility class that provides common file system
* operations such as checking file existence, creating, copying, writing,
* appending and reading files, retrieving file extension and file name,
* checking whether a source file has changed relative to a destination,
* checking file expiration based on a TTL, and opening a file in binary
* read mode.
*/
class FileIo {
/**
* Checks whether the given path exists and is a regular file (not a directory).
*
* @param string $filePath Path of the file to check.
* @return bool True if the file exists and is not a directory, otherwise false.
*/
public static function fileExists($filePath){}
/**
* Creates a new empty file at the given path.
*
* @param string $filePath Path of the file to create.
* @return void
*/
public static function fileCreate($filePath){}
/**
* Copies a file from source to destination, optionally overwriting an
* existing destination file.
*
* @param string $src Source file path.
* @param string $dst Destination file path.
* @param bool $overwrite Whether to overwrite the destination if it exists.
* @return bool True if the copy succeeded, otherwise false.
*/
public static function fileCopy($src,$dst,$overwrite=false){}
/**
* Copies the source file to the destination only if the destination does not
* exist or the source is newer than the destination.
*
* @param string $src Source file path.
* @param string $dst Destination file path.
* @return void
*/
public static function fileCopyChanges($src,$dst){}
/**
* Determines whether the source file has changed relative to the destination
* file (destination missing or source newer).
*
* @param string $src Source file path.
* @param string $dst Destination file path.
* @return bool True if the source changed relative to the destination, otherwise false.
*/
public static function isSrcFileChange($src,$dst){}
/**
* Writes the given data to a file, overwriting any existing content.
*
* @param string $fileURL Path of the file to write.
* @param string $data Data to write to the file.
* @return bool True if the write succeeded, otherwise false.
*/
public static function fileWrite($fileURL,$data){}
/**
* Appends the given data to a file.
*
* @param string $fileURL Path of the file to append to.
* @param string $data Data to append to the file.
* @return bool True if the append succeeded, otherwise false.
*/
public static function fileAppend($fileURL,$data){}
/**
* Reads the entire contents of a file into a string.
*
* @param string $fileURL Path of the file to read.
* @return string The contents of the file.
*/
public static function fileRead($fileURL){}
/**
* Returns the file extension (text after the last dot) of the given file path.
*
* @param string $fileURL Path of the file.
* @return string The file extension.
*/
public static function getFileExtentionName($fileURL){}
/**
* Returns the base name (file name without directory path) of the given file path.
*
* @param string $fileURL Path of the file.
* @return string The file name.
*/
public static function getFileName($fileURL){}
/**
* Checks whether a file is expired based on its last modification time and a
* time-to-live (TTL) value.
*
* @param string $filename Path of the file to check.
* @param int $ttl Time-to-live in seconds; -1 means the file never expires.
* @return bool True if the file is expired, otherwise false.
*/
public function isFileExpired($filename,$ttl=0){}
/**
* Opens a file in binary read mode and returns the file handle.
*
* @param string $filepath Path of the file to open.
* @return resource|false The file handle on success, false on failure.
*/
public function openFileBytes($filepath){}
}
}