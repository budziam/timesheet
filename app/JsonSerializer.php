<?php
namespace App;

use Spatie\Fractalistic\ArraySerializer;

class JsonSerializer extends ArraySerializer
{
    public function null()
    {
        return null;
    }
}