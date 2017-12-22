<?php
namespace App\Datatables;

use App\Models\Customer;
use App\Repositories\CustomerRepository;
use Illuminate\Support\Collection;
use ModelShaper\Datatable\BaseDatatable;

class CustomerDatatable extends BaseDatatable
{
    /** @var CustomerRepository */
    protected $customerRepository;

    public function __construct(CustomerRepository $customerRepository)
    {
        $this->customerRepository = $customerRepository;
    }

    public function initBuilder()
    {
        $this->builder = Customer::query();
    }

    public function render() : Collection
    {
        return $this->builder
            ->get()
            ->map(function (Customer $customer) {
                return [
                    'id'   => [
                        'display' => $this->customerRepository->getLink($customer, '#' . $customer->id),
                        'raw'     => $customer->id,
                    ],
                    'name' => $customer->name,
                ];
            });
    }
}
