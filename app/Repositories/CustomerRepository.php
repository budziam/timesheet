<?php
namespace App\Repositories;

use App\Models\Customer;

class CustomerRepository
{
    public function getLink(Customer $customer, string $title = null) : string
    {
        $title = $title ?? $customer->name;

        return link_to_route('dashboard.customers.edit', $title, $customer->getRouteKey());
    }
}