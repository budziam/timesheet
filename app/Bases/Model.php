<?php
namespace App\Bases;

use App\Traits\HelpfulMethods;
use Illuminate\Database\Eloquent\Model as BaseModel;

/**
 * @mixin \Eloquent
 */
abstract class Model extends BaseModel
{
    use HelpfulMethods;
}