<?php
namespace App\Builders;

use Illuminate\Contracts\Support\Arrayable;
use Illuminate\Contracts\Support\Jsonable;
use JsonSerializable;

class ResponseBuilder implements Arrayable, Jsonable, JsonSerializable
{
    /**
     * @var array
     */
    protected $response;

    public function __construct($status = '', $data = [])
    {
        $this->response = compact('status');

        if (!empty($data)) {
            $this->response['data'] = $data;
        }
    }

    /**
     * @return \Illuminate\Support\Collection
     */
    public function get()
    {
        return collect($this->response);
    }

    public function withStatus($status)
    {
        $this->response['status'] = $status;

        return $this;
    }

    public function withData($data)
    {
        $this->response['data'] = $data;

        return $this;
    }

    public function withAction($action, $data = null)
    {
        $this->response['action'] = [
            'type' => $action,
        ];

        if (!is_null($data)) {
            $this->response['action']['data'] = $data;
        }

        return $this;
    }

    public function withActionRedirect($url)
    {
        return $this->withAction('redirect', compact('url'));
    }

    public function toArray()
    {
        return $this->get()->toArray();
    }

    public function toJson($options = 0)
    {
        return $this->get()->toJson($options);
    }

    public function jsonSerialize()
    {
        return $this->get()->jsonSerialize();
    }

    public function toResponse()
    {
        return response($this->response);
    }
}