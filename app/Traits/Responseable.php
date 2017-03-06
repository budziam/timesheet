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

    public function responseError($httpCode, $data = [])
    {
        return response($data, $httpCode);
    }
}