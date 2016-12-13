<?php
namespace App\Bases;

use App\Traits\HelpfulMethods;
use Illuminate\Database\Eloquent\Model;

/**
 * @mixin \Eloquent
 */
abstract class BaseModel extends Model
{
    use HelpfulMethods;
}