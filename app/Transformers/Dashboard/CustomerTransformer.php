<?php
namespace App\Transformers\Dashboard;

use App\Models\Customer;
use League\Fractal\TransformerAbstract;

class CustomerTransformer extends TransformerAbstract
{
    public function transform(Customer $customer)
    {
        return [
            'id'    => $customer->id,
            'name'  => $customer->name,
            'color' => $customer->color,
        ];
    }
}