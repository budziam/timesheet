<?php
namespace App\Traits;

use App\Builders\ResponseBuilder;

trait Responseable
{
    public function response($status = 'ok', $data = [])
    {
        return new ResponseBuilder($status, $data);
    }

    public function responseSuccess()
    {
        return $this->response();
    }

    public function responseError($httpCode, $status = 'error', $data = [])
    {
        return (new ResponseBuilder($status, $data))
            ->toResponse()
            ->setStatusCode($httpCode);
    }
}