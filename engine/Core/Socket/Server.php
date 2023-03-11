<?php

namespace Engine\Core\Socket;

use Engine\Helper\Log;

class Server
{
    protected object $client;

    public function __construct($client)
    {
        $this->client = $client;
    }

    /**
     * @return void
     */
    public function run(): void
    {
        if(file_exists(ROOT_DIR.DS.$_ENV['sslCertificate'])){
            $context = stream_context_create();

            stream_context_set_option($context, 'ssl', 'local_cert', $_ENV['sslCertificate']);
            stream_context_set_option($context, 'ssl', 'crypto_method', STREAM_CRYPTO_METHOD_TLS_SERVER);
            stream_context_set_option($context, 'ssl', 'allow_self_signed', true);
            stream_context_set_option($context, 'ssl', 'verify_peer', false);
            stream_context_set_option($context, 'ssl', 'verify_peer_name', false);
            $socket = stream_socket_server("tcp://" . $_ENV['socketHost'] . ":" . $_ENV['socketPort'], $error_code, $error_message,
                STREAM_SERVER_BIND|STREAM_SERVER_LISTEN, $context);
        }else{
            $socket = stream_socket_server("tcp://" . $_ENV['socketHost'] . ":" . $_ENV['socketPort'], $error_code, $error_message);
        }

        if (!$socket) {
            Log::set("$error_message ($error_code)", 'socket');
        }

        $connects = [];

        while (true) {
            $read = $connects;
            $read[] = $socket;

            $write = $except = null;

            if (!stream_select($read, $write, $except, null)) {
                Log::set('Error stream_select in argument $read not resource', 'socket');
                break;
            }

            if (in_array($socket, $read)) {
                if (($connect = stream_socket_accept($socket, -1)) && $this->handshake($connect)) {
                    $this->client->onOpen($connects);
                    $connects[] = $connect;
                }
                unset($read[array_search($socket, $read)]);
            }

            foreach ($read as $connect) {
                $data = fread($connect, 100000);

                if (!$data) {
                    fclose($connect);
                    unset($connects[array_search($connect, $connects)]);
                    $this->client->onClose($connects);
                    continue;
                }

                $this->client->onMessage($read, $data);
            }

        }

        fclose($socket);
    }

    /**
     * @param $connect
     * @return bool|array
     */
    public function handshake($connect): bool|array
    {
        $info = array();

        $line = fgets($connect);
        $header = explode(' ', $line);
        $info['method'] = $header[0];
        $info['uri'] = $header[1];

        while ($line = rtrim(fgets($connect))) {
            if (preg_match('/\A(\S+): (.*)\z/', $line, $matches)) {
                $info[$matches[1]] = $matches[2];
            } else {
                break;
            }
        }

        $address = explode(':', stream_socket_get_name($connect, true));
        $info['ip'] = $address[0];
        $info['port'] = $address[1];

        if (empty($info['Sec-WebSocket-Key'])) {
            return false;
        }

        $SecWebSocketAccept = base64_encode(pack('H*', sha1($info['Sec-WebSocket-Key'] . '258EAFA5-E914-47DA-95CA-C5AB0DC85B11')));
        $upgrade = "HTTP/1.1 101 Web Socket Protocol Handshake\r\n" .
            "Upgrade: websocket\r\n" .
            "Connection: Upgrade\r\n" .
            "Sec-WebSocket-Accept:$SecWebSocketAccept\r\n\r\n";
        fwrite($connect, $upgrade);

        return $info;
    }
}