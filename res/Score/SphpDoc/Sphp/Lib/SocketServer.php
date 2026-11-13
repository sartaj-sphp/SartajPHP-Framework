<?php
namespace Sphp\Lib{
/**
* SocketServer
*
* A low-level WebSocket (RFC 6455) server implementation built on top of PHP's
* socket extension. It listens for incoming TCP connections, performs the
* WebSocket opening handshake, and then reads and writes WebSocket frames and
* messages to/from connected clients.
*
* The server keeps track of every connected client (socket, message buffer,
* ready state, last receive time, ping state, close status, IP address, frame
* and message state) and enforces limits on the total number of clients, the
* number of clients per IP v4 address, and the maximum frame and message
* payload sizes. Idle clients are pinged and eventually closed if they do not
* respond.
*
* Event handlers can be registered with bind() for the 'open', 'message' and
* 'close' events, and removed with unbind().
*/
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
/**
* Start the WebSocket server.
*
* Creates the listening socket, binds it to the given host and port, and
* enters the main accept/read loop. The loop keeps running until
* wsStopServer() is called.
*
* @param string $host The host address to bind the server socket to.
* @param int $port The port to listen for incoming client connections on.
* @return bool True when the server loop exits (wsStopServer() was called), false on socket errors.
*/
function wsStartServer($host, $port) {}
/**
* Stop the WebSocket server.
*
* Closes all client connections (sending a 'going away' close frame to
* clients whose handshake is complete), closes the listening socket and
* resets the server's state variables.
*
* @return bool True when the server was running and has been stopped, false when the server is not running.
*/
function wsStopServer() {}
/**
* Check all connected clients for idle timeouts.
*
* Clients that have not replied to a pending ping within
* self::WS_TIMEOUT_PONG seconds are closed and removed. Clients that have
* not sent any data within self::WS_TIMEOUT_RECV seconds are pinged (or
* removed if they are still connecting).
*
* @return void
*/
function wsCheckIdleClients() {}
/**
* Add a new client to the server.
*
* Increases the connected client counts (total and per IP), fetches the
* next client ID, stores the initial client data and registers the client
* socket for socket_select().
*
* @param resource $socket The client's socket resource.
* @param int $clientIP The client's IP v4 address as a signed long (from ip2long()).
* @return void
*/
function wsAddClient($socket, $clientIP) {}
/**
* Remove a client from the server.
*
* Fires any registered 'close' event handlers with the client's close
* status, closes the client's socket, decreases the connected client
* counts and removes the client's data from the server's arrays.
*
* @param int $clientID The ID of the client to remove.
* @return void
*/
function wsRemoveClient($clientID) {}
/**
* Fetch the next available client ID.
*
* Client IDs start at 1 because 0 is reserved for the listen socket.
*
* @return int The next available client ID.
*/
function wsGetNextClientId() {}
/**
* Fetch a client's socket resource.
*
* @param int $clientID The ID of the client.
* @return resource The client's socket resource.
*/
function wsGetClientSocket($clientID) {}
/**
* Process incoming data from a client.
*
* If the client's handshake is complete, the data is processed as
* WebSocket frame(s). If the handshake is not complete, the data is
* processed as the opening handshake, and the 'open' event handlers are
* fired when the handshake succeeds.
*
* @param int $clientID The ID of the client.
* @param string $buffer The received data (passed by reference).
* @param int $bufferLength The length of the received data.
* @return bool True when the data was processed successfully, false otherwise.
*/
function wsProcessClient($clientID, &$buffer, $bufferLength) {}
/**
* Build a client frame from the received data.
*
* Joins the received data onto the client's frame buffer and, once the
* frame's payload data length is known and all frame bytes have been
* received, processes the frame. Any extra bytes belonging to the next
* frame are processed recursively.
*
* @param int $clientID The ID of the client.
* @param string $buffer The received data (passed by reference).
* @param int $bufferLength The length of the received data.
* @return bool True when the data was processed successfully, false otherwise.
*/
function wsBuildClientFrame($clientID, &$buffer, $bufferLength) {}
/**
* Check and store the length of a client frame's payload data.
*
* Reads the payload length from the client's frame buffer (supporting the
* 7-bit, 16-bit and 64-bit length encodings) and validates it against the
* maximum frame and message payload sizes.
*
* @param int $clientID The ID of the client.
* @return bool True when the payload data length has been stored, false when it could not be fetched or the frame is too big.
*/
function wsCheckSizeClientFrame($clientID) {}
/**
* Process a complete client frame.
*
* Unmasks the frame's payload data and handles the frame according to its
* opcode and fin bit: final frames are processed as messages (or the last
* part of a fragmented message), non-final frames are accumulated in the
* message buffer.
*
* @param int $clientID The ID of the client.
* @return bool True when the frame was processed successfully, false otherwise.
*/
function wsProcessClientFrame($clientID) {}
/**
* Process a complete client message.
*
* Handles ping, pong, close and text/binary messages. Ping messages are
* answered with a pong, close messages trigger the close handshake and
* client removal, and text/binary messages are passed to the registered
* 'message' event handlers.
*
* @param int $clientID The ID of the client.
* @param int $opcode The message's opcode.
* @param string $data The message's payload data (passed by reference).
* @param int $dataLength The length of the message's payload data.
* @return bool True when the message was processed successfully, false for an unknown opcode.
*/
function wsProcessClientMessage($clientID, $opcode, &$data, $dataLength) {}
/**
* Process a client's opening handshake.
*
* Validates the HTTP upgrade request (method, version, Host,
* Sec-WebSocket-Key and Sec-WebSocket-Version headers) and sends the
* '101 Switching Protocols' response back to the client.
*
* @param int $clientID The ID of the client.
* @param string $buffer The received data (passed by reference).
* @return bool True when the handshake was completed successfully, false otherwise.
*/
function wsProcessClientHandshake($clientID, &$buffer) {}
/**
* Send a message to a client.
*
* Splits the message into frames of at most 4096 bytes of payload data
* (the first frame carries the given opcode, the rest are continuation
* frames) and sends each frame to the client.
*
* @param int $clientID The ID of the client.
* @param int $opcode The message's opcode (text or binary).
* @param string $message The message's payload data.
* @return bool True when the message was sent successfully (or the client is already closing/closed), false on send errors.
*/
function wsSendClientMessage($clientID, $opcode, $message) {}
/**
* Send a close frame to a client.
*
* Stores the close status on the client, sends a close frame with the
* given status (or no status) and sets the client's ready state to
* closing.
*
* @param int $clientID The ID of the client.
* @param int|false $status The close status to send, false for no status.
* @return bool True when the close frame was sent (or the client is already closing/closed), false on send errors.
*/
function wsSendClientClose($clientID, $status=false) {}
/**
* Close a client connection with a normal close status.
*
* @param int $clientID The ID of the client.
* @return bool True when the close frame was sent (or the client is already closing/closed), false on send errors.
*/
function wsClose($clientID) {}
/**
* Send a text or binary message to a client.
*
* @param int $clientID The ID of the client.
* @param string $message The message's payload data.
* @param bool $binary True to send a binary message, false to send a text message.
* @return bool True when the message was sent successfully (or the client is already closing/closed), false on send errors.
*/
function wsSend($clientID, $message, $binary=false) {}
/**
* Log a message to standard output with a timestamp.
*
* @param string $message The message to log.
* @return void
*/
function log( $message )
{}
/**
* Bind an event handler function to an event.
*
* Supported events are 'open', 'message' and 'close'.
*
* @param string $type The event name to bind the handler to.
* @param callable $func The handler function to call when the event fires.
* @return void
*/
function bind( $type, $func )
{}
/**
* Unbind event handler functions.
*
* Removes the handlers for the given event, or all handlers when no event
* is given.
*
* @param string $type The event name to unbind, empty string to unbind all events.
* @return void
*/
function unbind( $type='' )
{}
}
}