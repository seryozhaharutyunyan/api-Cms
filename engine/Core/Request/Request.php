<?php

namespace Engine\Core\Request;

use Engine\Core\Config\Config;
use Engine\Core\Database\Connection;
use Engine\Core\Database\QueryBuilder;
use Engine\Core\Response\Response;
use Engine\DI\DI;

abstract class Request
{
    use Validate;

    protected DI $di;
    protected array $get = [];
    protected array $post = [];
    protected array $patch = [];
    protected array $put = [];
    protected array $request = [];
    protected array $cookie = [];
    protected array $file = [];
    protected array $server = [];
    protected array $session = [];
    protected string $table;
    protected Connection $db;
    protected QueryBuilder $queryBuilder;
    protected ?int $id;
    protected Response $response;


    /**
     * Request Constructor
     */
    public function __construct(DI $di, int|null $id = null)
    {
        $this->di = $di;
        $this->response = $this->di->get('response');
        $this->cookie = $_COOKIE;
        $this->file = $_FILES;

        $this->queryBuilder = new QueryBuilder();
        $this->db = new Connection();

        $this->id = $id;

    }

    protected function initPutPatch(){
        $data=$this->decode();
        return !is_null($data) ? $data : json_decode(file_get_contents('php://input'), true);
    }

    protected function initPost(){
        $data=$this->decode();
        return !empty($_POST) ? $_POST : (!is_null($data)
        ? $data : json_decode(file_get_contents('php://input'), true));
    }

    /**
     * [
     *      "name"=>"required|unique|max:5"
     * ]
     * @return array
     */
    abstract protected function validate(): array;

    /**
     * @return array
     * @throws \Exception
     */
    public function init(): array
    {
        if(empty($this->table)){
            throw new \Exception("you didn't specify the main table to compare");
        }

        $data = match ($_SERVER['REQUEST_METHOD']) {
            'POST' => $this->post=$this->initPost(),
            'PATCH' => $this->patch=$this->initPutPatch(),
            'PUT' => $this->put=$this->initPutPatch(),
        };

        $errors = [];

        $validate = $this->validate();
        if (!empty($validate)) {
            foreach ($validate as $key => $value) {
                $validate[$key] = explode('|', $value);
            }
        } else {
            throw new \Exception("you didn't specify a validation condition");
        }

        if (!empty($data)) {
            foreach ($data as $key => $value) {
                foreach ($validate as $k => $item) {
                    if ($key === $k) {
                        foreach ($item as $v) {
                            if (preg_match('/.:./', $v)) {
                                $s = explode(':', $v);
                                if (preg_match('/.,./', $s[1])) {
                                    $s[1] = explode(',', $s[1]);
                                    $message = $this->{$s[0]}($value, $s[1][0], $s[1][1], $key);
                                } else {
                                    $message = $this->{$s[0]}($value, $s[1], $key);
                                }
                            } else {
                                if (($v === 'nullable' && empty($value))) {
                                    continue 2;
                                }
                                $message = $this->{$v}($value, $key);
                            }
                            if ($message !== true) {
                                $errors[$key] = $message;
                                continue 3;
                            }
                        }
                    }

                }
            }
        } else {
            $this->response->send(415, Config::item('data', 'messages'));
        }

        if (!empty($errors)) {
            $this->response->setData($errors)->send(415);
        }

        return $data;
    }

    /**
     * @return array|null
     */
    protected function decode(): ?array
    {
        $raw_data = file_get_contents('php://input');
        $boundary = substr($raw_data, 0, strpos($raw_data, "\r\n"));
        if(empty($boundary)){
            return null;
        }
        $parts = array_slice(explode($boundary, $raw_data), 1);
        $data = [];

        foreach ($parts as $part) {

            if ($part == "--\r\n") break;

            $part = ltrim($part, "\r\n");
            [$raw_headers, $body] = explode("\r\n\r\n", $part, 2);

            $raw_headers = explode("\r\n", $raw_headers);
            $headers = [];
            foreach ($raw_headers as $header) {
                [$name, $value] = explode(':', $header);
                $headers[strtolower($name)] = ltrim($value, ' ');
            }

            if (isset($headers['content-disposition'])) {
                $filename = null;
                preg_match(
                    '/^(.+); *name="([^"]+)"(; *filename="([^"]+)")?/',
                    $headers['content-disposition'],
                    $matches
                );
                [, $type, $name] = $matches;
                isset($matches[4]) and $filename = $matches[4];

                if ($name == 'userfile') {
                    file_put_contents($filename, $body);
                } else {
                    $data[$name] = substr($body, 0, strlen($body) - 2);
                }
            }
        }
        return $data;
    }
}