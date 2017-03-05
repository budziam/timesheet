<?php
namespace App\Traits;

use App\Builders\ResponseBuilder;

trait Responseable
{
    public function response($status, $data = [])
    {
        return new ResponseBuilder($status, $data);
    }

    public function responseSuccess($data = [], $httpCode = 200)
    {
        return response($data, $httpCode);
    }

    public function responseError($httpCode, $status = 'error', $data = [])
    {
        return $this->response($status, $data)
            ->toResponse()
            ->setStatusCode($httpCode);
    }
}