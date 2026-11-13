<?php
namespace Sphp\Lib{
/**
* Stream
*
* Utility class for streaming media files over HTTP. It handles sending the
* correct Content-Type header based on the file extension, parsing HTTP
* Range requests for partial content, and writing the file to the output
* buffer in chunks with optional speed limiting.
*/
class Stream{
/**
* isNothing
*
* Checks whether a given string value is considered "empty" (not set, empty
* string, false, or a single dash).
*
* @param mixed $string The value to test.
* @return bool True if the value is considered nothing, false otherwise.
*/
/**
* sendContentType
*
* Sends the Content-Type HTTP header for the given file extension. If an
* explicit content type is provided it is used; otherwise the type is
* looked up from a built-in map of known media extensions.
*
* @param string $ext The file extension (without leading dot).
* @param string $contentType Optional explicit Content-Type value.
* @return void
*/
public function sendContentType($ext,$contentType="") {}
/**
* getContentRange
*
* Parses the HTTP Range request header (if present) and determines the byte
* range to serve.
*
* @param int $size The total size of the file in bytes.
* @return array|false An array [from, to] with the start and end byte
*                     offsets, or false if no valid range was requested.
*/
/**
* sendMedia
*
* Sends a media file to the client. It determines the file extension,
* ensures the name includes the extension, stops any previous output,
* sends the Content-Type header when resampling, and then streams the
* file.
*
* @param string $path The path to the media file.
* @param string $name The name to use for the file in the response.
* @param bool $resample Whether the file is being resampled.
* @param int $buffersize Buffer size used for speed limiting.
* @param bool $limit Whether to apply a speed limit.
* @param int $chunktime Seconds to sleep between chunks when limited.
* @return void
*/
public function sendMedia($path, $name,$resample=false,$buffersize=100,$limit=false,$chunktime=5) {}
/**
* streamFile
*
* Streams a file to the client, honoring HTTP Range requests for partial
* content. It sends the appropriate HTTP headers (content length, range,
* disposition, caching) and then writes the file to the output in chunks,
* optionally sleeping between chunks to limit the transfer speed.
*
* @param string $path The path to the file to stream.
* @param string $name The file name to use in the Content-Disposition header.
* @param int $buffersize Buffer size used for speed limiting.
* @param bool $limit Whether to apply a speed limit.
* @param int $chunktime Seconds to sleep between chunks when limited.
* @return void
*/
public function streamFile($path,$name,$buffersize=100,$limit=false,$chunktime=5) {}
}
}