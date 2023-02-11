<?php

namespace Engine\Core\Request;

class Request
{
    public array $get=[];
    public array $post=[];
    public array $request=[];
    public array $cookie=[];
    public array $file=[];
    public array $server=[];
    public array $session=[];


    /**
     * Request Constructor
     */
    public function __construct() {
        $this->get     = $_GET;
        $this->post    = $_POST;
        $this->request = $_REQUEST;
        $this->cookie  = $_COOKIE;
        $this->file    = $_FILES;
        $this->server  = $_SERVER;
        $this->session  = $_SESSION;
    }

}