<?php
namespace App\Http\Controllers\Dashboard;

use App\Bases\DashboardController;
use App\Models\Customer;

class CustomerController extends DashboardController
{
    protected function initPageInformation()
    {
        $this->breadcrumbBuilder->attachNewBreadcrumb(
            __('Customers'), route('dashboard.customers.index')
        );
        $this->navbarBuilder->setActive('customers');
    }

    public function index()
    {
        return view('dashboard.pages.customers.index');
    }

    public function edit(Customer $customer)
    {
        $this->breadcrumbBuilder
            ->attachNewBreadcrumb($customer->name, route('dashboard.customers.edit', $customer->getRouteKey()));

        return view('dashboard.pages.customers.edit', compact('customer'));
    }

    public function create()
    {
        $this->breadcrumbBuilder
            ->attachNewBreadcrumb(__('Create'), route('dashboard.customers.create'));

        return view('dashboard.pages.customers.create');
    }
}
