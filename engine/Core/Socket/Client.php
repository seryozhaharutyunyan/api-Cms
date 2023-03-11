<?php

namespace Engine\Core\Socket;

abstract class Client
{
    use DecodeEncode;
    public abstract function onOpen(array $connects);

    public abstract function onClose(array $connects);

    public abstract function onMessage(array $connects, mixed $data);

    public abstract function onError(string $error, string $message='');

    public abstract function onPing($connect, string $msg);

    public abstract function onPong($connect, string $msg);
}