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
function wsStartServer($host, $port) {}
function wsStopServer() {}
function wsCheckIdleClients() {}
function wsAddClient($socket, $clientIP) {}
function wsRemoveClient($clientID) {}
function wsGetNextClientID() {}
function wsGetClientSocket($clientID) {}
function wsProcessClient($clientID, &$buffer, $bufferLength) {}
function wsBuildClientFrame($clientID, &$buffer, $bufferLength) {}
function wsCheckSizeClientFrame($clientID) {}
function wsProcessClientFrame($clientID) {}
function wsProcessClientMessage($clientID, $opcode, &$data, $dataLength) {}
function wsProcessClientHandshake($clientID, &$buffer) {}
function wsSendClientMessage($clientID, $opcode, $message) {}
function wsSendClientClose($clientID, $status=false) {}
function wsClose($clientID) {}
function wsSend($clientID, $message, $binary=false) {}
function log( $message )
{}
function bind( $type, $func )
{}
function unbind( $type='' )
{}
}
?>