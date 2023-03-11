<?php

namespace App\SocketClient;

use Engine\Core\Socket\Client;

class MainClient extends Client
{

    public function onOpen(array $connects)
    {
        echo "open\n";
        foreach ($connects as $connect){
            stream_socket_sendto($connect, $this->encode('Привет'));
        }
    }

    public function onClose(array $connects)
    {
        // TODO: Implement onClose() method.
    }

    public function onMessage(array $connects, mixed $data)
    {
        // TODO: Implement onMessage() method.
    }

    public function onError(string $error, string $message = '')
    {
        // TODO: Implement onError() method.
    }

    public function onPing($connect, string $msg)
    {
        // TODO: Implement onPing() method.
    }

    public function onPong($connect, string $msg)
    {
        // TODO: Implement onPong() method.
    }
}