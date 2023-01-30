<?php
class SocketServer
{
const WS_MAX_CLIENTS = 100;
const WS_MAX_CLIENTS_PER_IP = 15;
const WS_TIMEOUT_RECV = 10;
const WS_TIMEOUT_PONG = 5;
const WS_MAX_FRAME_PAYLOAD_RECV = 100000;
const WS_MAX_MESSAGE_PAYLOAD_RECV = 500000;
const WS_FIN =  128;
const WS_MASK = 128;
const WS_OPCODE_CONTINUATION = 0;
const WS_OPCODE_TEXT =         1;
const WS_OPCODE_BINARY =       2;
const WS_OPCODE_CLOSE =        8;
const WS_OPCODE_PING =         9;
const WS_OPCODE_PONG =         10;
const WS_PAYLOAD_LENGTH_16 = 126;
const WS_PAYLOAD_LENGTH_63 = 127;
const WS_READY_STATE_CONNECTING = 0;
const WS_READY_STATE_OPEN =       1;
const WS_READY_STATE_CLOSING =    2;
const WS_READY_STATE_CLOSED =     3;
const WS_STATUS_NORMAL_CLOSE =             1000;
const WS_STATUS_GONE_AWAY =                1001;
const WS_STATUS_PROTOCOL_ERROR =           1002;
const WS_STATUS_UNSUPPORTED_MESSAGE_TYPE = 1003;
const WS_STATUS_MESSAGE_TOO_BIG =          1004;
const WS_STATUS_TIMEOUT = 3000;
public $wsClients       = array();
public $wsClientsExt       = array();
public $wsRead          = array();
public $wsClientCount   = 0;
public $wsClientIPCount = array();
public $wsOnEvents      = array();
function wsStartServer($host, $port) {
if (isset($this->wsRead[0])) return false;
if (!$this->wsRead[0] = socket_create(AF_INET, SOCK_STREAM, SOL_TCP)) {
return false;
}
if (!socket_set_option($this->wsRead[0], SOL_SOCKET, SO_REUSEADDR, 1)) {
socket_close($this->wsRead[0]);
return false;
}
if (!socket_bind($this->wsRead[0], $host, $port)) {
socket_close($this->wsRead[0]);
return false;
}
if (!socket_listen($this->wsRead[0], 10)) {
socket_close($this->wsRead[0]);
return false;
}
$write = array();
$except = array();
$nextPingCheck = time() + 1;
while (isset($this->wsRead[0])) {
$changed = $this->wsRead;
$result = socket_select($changed, $write, $except, 1);
if ($result === false) {
socket_close($this->wsRead[0]);
return false;
}
elseif ($result > 0) {
foreach ($changed as $clientID => $socket) {
if ($clientID != 0) {
$buffer = '';
$bytes = @socket_recv($socket, $buffer, 4096, 0);
if ($bytes === false) {
$this->wsSendClientClose($clientID, self::WS_STATUS_PROTOCOL_ERROR);
}
elseif ($bytes > 0) {
if (!$this->wsProcessClient($clientID, $buffer, $bytes)) {
$this->wsSendClientClose($clientID, self::WS_STATUS_PROTOCOL_ERROR);
}
}
else {
$this->wsRemoveClient($clientID);
}
}
else {
$client = socket_accept($this->wsRead[0]);
if ($client !== false) {
$clientIP = '';
$result = socket_getpeername($client, $clientIP);
$clientIP = ip2long($clientIP);
if ($result !== false && $this->wsClientCount < self::WS_MAX_CLIENTS && (!isset($this->wsClientIPCount[$clientIP]) || $this->wsClientIPCount[$clientIP] < self::WS_MAX_CLIENTS_PER_IP)) {
$this->wsAddClient($client, $clientIP);
}
else {
socket_close($client);
}
}
}
}
}
if (time() >= $nextPingCheck) {
$this->wsCheckIdleClients();
$nextPingCheck = time() + 1;
}
}
return true; 	}
function wsStopServer() {
if (!isset($this->wsRead[0])) return false;
foreach ($this->wsClients as $clientID => $client) {
if ($client[2] != self::WS_READY_STATE_CONNECTING) {
$this->wsSendClientClose($clientID, self::WS_STATUS_GONE_AWAY);
}
socket_close($client[0]);
}
socket_close($this->wsRead[0]);
$this->wsRead          = array();
$this->wsClients       = array();
$this->wsClientsExt       = array();
$this->wsClientCount   = 0;
$this->wsClientIPCount = array();
return true;
}
function wsCheckIdleClients() {
$time = time();
foreach ($this->wsClients as $clientID => $client) {
if ($client[2] != self::WS_READY_STATE_CLOSED) {
if ($client[4] !== false) {
if ($time >= $client[4] + self::WS_TIMEOUT_PONG) {
$this->wsSendClientClose($clientID, self::WS_STATUS_TIMEOUT);
$this->wsRemoveClient($clientID);
}
}
elseif ($time >= $client[3] + self::WS_TIMEOUT_RECV) {
if ($client[2] != self::WS_READY_STATE_CONNECTING) {
$this->wsClients[$clientID][4] = time();
$this->wsSendClientMessage($clientID, self::WS_OPCODE_PING, '');
}
else {
$this->wsRemoveClient($clientID);
}
}
}
}
}
function wsAddClient($socket, $clientIP) {
$this->wsClientCount++;
if (isset($this->wsClientIPCount[$clientIP])) {
$this->wsClientIPCount[$clientIP]++;
}
else {
$this->wsClientIPCount[$clientIP] = 1;
}
$clientID = $this->wsGetNextClientID();
$this->wsClients[$clientID] = array($socket, '', self::WS_READY_STATE_CONNECTING, time(), false, 0, $clientIP, false, 0, '', 0, 0);
$this->wsRead[$clientID] = $socket;
}
function wsRemoveClient($clientID) {
$closeStatus = $this->wsClients[$clientID][5];
if ( array_key_exists('close', $this->wsOnEvents) )
foreach ( $this->wsOnEvents['close'] as $func )
$func($clientID, $closeStatus);
$socket = $this->wsClients[$clientID][0];
socket_close($socket);
$clientIP = $this->wsClients[$clientID][6];
if ($this->wsClientIPCount[$clientIP] > 1) {
$this->wsClientIPCount[$clientIP]--;
}
else {
unset($this->wsClientIPCount[$clientIP]);
}
$this->wsClientCount--;
unset($this->wsRead[$clientID], $this->wsClients[$clientID]);
}
function wsGetNextClientID() {
$i = 1; 		while (isset($this->wsRead[$i])) $i++;
return $i;
}
function wsGetClientSocket($clientID) {
return $this->wsClients[$clientID][0];
}
function wsProcessClient($clientID, &$buffer, $bufferLength) {
if ($this->wsClients[$clientID][2] == self::WS_READY_STATE_OPEN) {
$result = $this->wsBuildClientFrame($clientID, $buffer, $bufferLength);
}
elseif ($this->wsClients[$clientID][2] == self::WS_READY_STATE_CONNECTING) {
$result = $this->wsProcessClientHandshake($clientID, $buffer);
if ($result) {
$this->wsClients[$clientID][2] = self::WS_READY_STATE_OPEN;
if ( array_key_exists('open', $this->wsOnEvents) )
foreach ( $this->wsOnEvents['open'] as $func )
$func($clientID);
}
}
else {
$result = false;
}
return $result;
}
function wsBuildClientFrame($clientID, &$buffer, $bufferLength) {
$this->wsClients[$clientID][8] += $bufferLength;
$this->wsClients[$clientID][9] .= $buffer;
if ($this->wsClients[$clientID][7] !== false || $this->wsCheckSizeClientFrame($clientID) == true) {
$headerLength = ($this->wsClients[$clientID][7] <= 125 ? 0 : ($this->wsClients[$clientID][7] <= 65535 ? 2 : 8)) + 6;
$frameLength = $this->wsClients[$clientID][7] + $headerLength;
if ($this->wsClients[$clientID][8] >= $frameLength) {
$nextFrameBytesLength = $this->wsClients[$clientID][8] - $frameLength;
if ($nextFrameBytesLength > 0) {
$this->wsClients[$clientID][8] -= $nextFrameBytesLength;
$nextFrameBytes = substr($this->wsClients[$clientID][9], $frameLength);
$this->wsClients[$clientID][9] = substr($this->wsClients[$clientID][9], 0, $frameLength);
}
$result = $this->wsProcessClientFrame($clientID);
if (isset($this->wsClients[$clientID])) {
$this->wsClients[$clientID][7] = false;
$this->wsClients[$clientID][8] = 0;
$this->wsClients[$clientID][9] = '';
}
if ($nextFrameBytesLength <= 0 || !$result) return $result;
return $this->wsBuildClientFrame($clientID, $nextFrameBytes, $nextFrameBytesLength);
}
}
return true;
}
function wsCheckSizeClientFrame($clientID) {
if ($this->wsClients[$clientID][8] > 1) {
$payloadLength = ord(substr($this->wsClients[$clientID][9], 1, 1)) & 127;
if ($payloadLength <= 125) {
$this->wsClients[$clientID][7] = $payloadLength;
}
elseif ($payloadLength == 126) {
if (substr($this->wsClients[$clientID][9], 3, 1) !== false) {
$payloadLengthExtended = substr($this->wsClients[$clientID][9], 2, 2);
$array = unpack('na', $payloadLengthExtended);
$this->wsClients[$clientID][7] = $array['a'];
}
}
else {
if (substr($this->wsClients[$clientID][9], 9, 1) !== false) {
$payloadLengthExtended = substr($this->wsClients[$clientID][9], 2, 8);
$payloadLengthExtended32_1 = substr($payloadLengthExtended, 0, 4);
$array = unpack('Na', $payloadLengthExtended32_1);
if ($array['a'] != 0 || ord(substr($payloadLengthExtended, 4, 1)) & 128) {
$this->wsSendClientClose($clientID, self::WS_STATUS_MESSAGE_TOO_BIG);
return false;
}
$payloadLengthExtended32_2 = substr($payloadLengthExtended, 4, 4);
$array = unpack('Na', $payloadLengthExtended32_2);
if ($array['a'] > 2147479538) {
$this->wsSendClientClose($clientID, self::WS_STATUS_MESSAGE_TOO_BIG);
return false;
}
$this->wsClients[$clientID][7] = $array['a'];
}
}
if ($this->wsClients[$clientID][7] !== false) {
if ($this->wsClients[$clientID][7] > self::WS_MAX_FRAME_PAYLOAD_RECV) {
$this->wsClients[$clientID][7] = false;
$this->wsSendClientClose($clientID, self::WS_STATUS_MESSAGE_TOO_BIG);
return false;
}
$controlFrame = (ord(substr($this->wsClients[$clientID][9], 0, 1)) & 8) == 8;
if (!$controlFrame) {
$newMessagePayloadLength = $this->wsClients[$clientID][11] + $this->wsClients[$clientID][7];
if ($newMessagePayloadLength > self::WS_MAX_MESSAGE_PAYLOAD_RECV || $newMessagePayloadLength > 2147483647) {
$this->wsSendClientClose($clientID, self::WS_STATUS_MESSAGE_TOO_BIG);
return false;
}
}
return true;
}
}
return false;
}
function wsProcessClientFrame($clientID) {
$this->wsClients[$clientID][3] = time();
$buffer = &$this->wsClients[$clientID][9];
if (substr($buffer, 5, 1) === false) return false;
$octet0 = ord(substr($buffer, 0, 1));
$octet1 = ord(substr($buffer, 1, 1));
$fin = $octet0 & self::WS_FIN;
$opcode = $octet0 & 15;
$mask = $octet1 & self::WS_MASK;
if (!$mask) return false; 
$seek = $this->wsClients[$clientID][7] <= 125 ? 2 : ($this->wsClients[$clientID][7] <= 65535 ? 4 : 10);
$maskKey = substr($buffer, $seek, 4);
$array = unpack('Na', $maskKey);
$maskKey = $array['a'];
$maskKey = array(
$maskKey >> 24,
($maskKey >> 16) & 255,
($maskKey >> 8) & 255,
$maskKey & 255
);
$seek += 4;
if (substr($buffer, $seek, 1) !== false) {
$data = str_split(substr($buffer, $seek));
foreach ($data as $key => $byte) {
$data[$key] = chr(ord($byte) ^ ($maskKey[$key % 4]));
}
$data = implode('', $data);
}
else {
$data = '';
}
if ($opcode != self::WS_OPCODE_CONTINUATION && $this->wsClients[$clientID][11] > 0) {
$this->wsClients[$clientID][11] = 0;
$this->wsClients[$clientID][1] = '';
}
if ($fin == self::WS_FIN) {
if ($opcode != self::WS_OPCODE_CONTINUATION) {
return $this->wsProcessClientMessage($clientID, $opcode, $data, $this->wsClients[$clientID][7]);
}
else {
$this->wsClients[$clientID][11] += $this->wsClients[$clientID][7];
$this->wsClients[$clientID][1] .= $data;
$result = $this->wsProcessClientMessage($clientID, $this->wsClients[$clientID][10], $this->wsClients[$clientID][1], $this->wsClients[$clientID][11]);
if (isset($this->wsClients[$clientID])) {
$this->wsClients[$clientID][1] = '';
$this->wsClients[$clientID][10] = 0;
$this->wsClients[$clientID][11] = 0;
}
return $result;
}
}
else {
if ($opcode & 8) return false;
$this->wsClients[$clientID][11] += $this->wsClients[$clientID][7];
$this->wsClients[$clientID][1] .= $data;
if ($opcode != self::WS_OPCODE_CONTINUATION) {
$this->wsClients[$clientID][10] = $opcode;
}
}
return true;
}
function wsProcessClientMessage($clientID, $opcode, &$data, $dataLength) {
if ($opcode == self::WS_OPCODE_PING) {
return $this->wsSendClientMessage($clientID, self::WS_OPCODE_PONG, $data);
}
elseif ($opcode == self::WS_OPCODE_PONG) {
if ($this->wsClients[$clientID][4] !== false) {
$this->wsClients[$clientID][4] = false;
}
}
elseif ($opcode == self::WS_OPCODE_CLOSE) {
if (substr($data, 1, 1) !== false) {
$array = unpack('na', substr($data, 0, 2));
$status = $array['a'];
}
else {
$status = false;
}
if ($this->wsClients[$clientID][2] == self::WS_READY_STATE_CLOSING) {
$this->wsClients[$clientID][2] = self::WS_READY_STATE_CLOSED;
}
else {
$this->wsSendClientClose($clientID, self::WS_STATUS_NORMAL_CLOSE);
}
$this->wsRemoveClient($clientID);
}
elseif ($opcode == self::WS_OPCODE_TEXT || $opcode == self::WS_OPCODE_BINARY) {
if ( array_key_exists('message', $this->wsOnEvents) )
foreach ( $this->wsOnEvents['message'] as $func )
$func($clientID, $data, $dataLength, $opcode == self::WS_OPCODE_BINARY);
}
else {
return false;
}
return true;
}
function wsProcessClientHandshake($clientID, &$buffer) {
$sep = strpos($buffer, "\r\n\r\n");
if (!$sep) return false;
$headers = explode("\r\n", substr($buffer, 0, $sep));
$headersCount = sizeof($headers); 		if ($headersCount < 1) return false;
$request = &$headers[0];
$requestParts = explode(' ', $request);
$requestPartsSize = sizeof($requestParts);
if ($requestPartsSize < 3) return false;
if (strtoupper($requestParts[0]) != 'GET') return false;
$httpPart = &$requestParts[$requestPartsSize - 1];
$httpParts = explode('/', $httpPart);
if (!isset($httpParts[1]) || (float) $httpParts[1] < 1.1) return false;
$headersKeyed = array();
for ($i=1; $i<$headersCount; $i++) {
$parts = explode(':', $headers[$i]);
if (!isset($parts[1])) return false;
$headersKeyed[trim($parts[0])] = trim($parts[1]);
}
if (!isset($headersKeyed['Host'])) return false;
if (!isset($headersKeyed['Sec-WebSocket-Key'])) return false;
$key = $headersKeyed['Sec-WebSocket-Key'];
if (strlen(base64_decode($key)) != 16) return false;
if (!isset($headersKeyed['Sec-WebSocket-Version']) || (int) $headersKeyed['Sec-WebSocket-Version'] < 7) return false; 
$hash = base64_encode(sha1($key.'258EAFA5-E914-47DA-95CA-C5AB0DC85B11', true));
$headers = array(
'HTTP/1.1 101 Switching Protocols',
'Upgrade: websocket',
'Connection: Upgrade',
'Sec-WebSocket-Accept: '.$hash
);
$headers = implode("\r\n", $headers)."\r\n\r\n";
$socket = $this->wsClients[$clientID][0];
$left = strlen($headers);
do {
$sent = @socket_send($socket, $headers, $left, 0);
if ($sent === false) return false;
$left -= $sent;
if ($sent > 0) $headers = substr($headers, $sent);
}
while ($left > 0);
return true;
}
function wsSendClientMessage($clientID, $opcode, $message) {
if ($this->wsClients[$clientID][2] == self::WS_READY_STATE_CLOSING || $this->wsClients[$clientID][2] == self::WS_READY_STATE_CLOSED) return true;
$messageLength = strlen($message);
$bufferSize = 4096;
$frameCount = ceil($messageLength / $bufferSize);
if ($frameCount == 0) $frameCount = 1;
$maxFrame = $frameCount - 1;
$lastFrameBufferLength = ($messageLength % $bufferSize) != 0 ? ($messageLength % $bufferSize) : ($messageLength != 0 ? $bufferSize : 0);
for ($i=0; $i<$frameCount; $i++) {
$fin = $i != $maxFrame ? 0 : self::WS_FIN;
$opcode = $i != 0 ? self::WS_OPCODE_CONTINUATION : $opcode;
$bufferLength = $i != $maxFrame ? $bufferSize : $lastFrameBufferLength;
if ($bufferLength <= 125) {
$payloadLength = $bufferLength;
$payloadLengthExtended = '';
$payloadLengthExtendedLength = 0;
}
elseif ($bufferLength <= 65535) {
$payloadLength = self::WS_PAYLOAD_LENGTH_16;
$payloadLengthExtended = pack('n', $bufferLength);
$payloadLengthExtendedLength = 2;
}
else {
$payloadLength = self::WS_PAYLOAD_LENGTH_63;
$payloadLengthExtended = pack('xxxxN', $bufferLength); 				$payloadLengthExtendedLength = 8;
}
$buffer = pack('n', (($fin | $opcode) << 8) | $payloadLength) . $payloadLengthExtended . substr($message, $i*$bufferSize, $bufferLength);
$socket = $this->wsClients[$clientID][0];
$left = 2 + $payloadLengthExtendedLength + $bufferLength;
do {
$sent = @socket_send($socket, $buffer, $left, 0);
if ($sent === false) return false;
$left -= $sent;
if ($sent > 0) $buffer = substr($buffer, $sent);
}
while ($left > 0);
}
return true;
}
function wsSendClientClose($clientID, $status=false) {
if ($this->wsClients[$clientID][2] == self::WS_READY_STATE_CLOSING || $this->wsClients[$clientID][2] == self::WS_READY_STATE_CLOSED) return true;
$this->wsClients[$clientID][5] = $status;
$status = $status !== false ? pack('n', $status) : '';
$this->wsSendClientMessage($clientID, self::WS_OPCODE_CLOSE, $status);
$this->wsClients[$clientID][2] = self::WS_READY_STATE_CLOSING;
}
function wsClose($clientID) {
return $this->wsSendClientClose($clientID, self::WS_STATUS_NORMAL_CLOSE);
}
function wsSend($clientID, $message, $binary=false) {
return $this->wsSendClientMessage($clientID, $binary ? self::WS_OPCODE_BINARY : self::WS_OPCODE_TEXT, $message);
}
function log( $message )
{
echo date('Y-m-d H:i:s: ') . $message . "\n";
}
function bind( $type, $func )
{
if ( !isset($this->wsOnEvents[$type]) )
$this->wsOnEvents[$type] = array();
$this->wsOnEvents[$type][] = $func;
}
function unbind( $type='' )
{
if ( $type ) unset($this->wsOnEvents[$type]);
else $this->wsOnEvents = array();
}
}
?>