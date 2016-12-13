<?php
namespace App\Traits;

use App\Builders\ResponseBuilder;

trait Responseable
{
    public function response($status = 'ok', $data = [])
    {
        return new ResponseBuilder($status, $data);
    }

    public function responseError($httpCode, $status = 'error', $data = [])
    {
        return (new ResponseBuilder($status, $data))
            ->toResponse()
            ->setStatusCode($httpCode);
    }
}