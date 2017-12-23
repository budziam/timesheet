<?php
namespace App\Http\Controllers\Dashboard\Api;

use App\Bases\Controller;
use App\Datatables\CustomerDatatable;
use App\Http\Requests\Dashboard\CustomerDestroyRequest;
use App\Http\Requests\Dashboard\CustomerStoreUpdateRequest;
use App\Models\Customer;
use App\Transformers\Dashboard\CustomerTransformer;
use ModelShaper\Datatable\DatatableFormRequest;
use ModelShaper\Datatable\DatatableShaper;
use ModelShaper\Select2\Select2FormRequest;
use ModelShaper\Select2\Select2Shaper;

class CustomerController extends Controller
{
    public function datatable(DatatableFormRequest $request)
    {
        $shaper = new DatatableShaper(app(CustomerDatatable::class));

        return $shaper->shape($request);
    }

    public function select2(Select2FormRequest $request)
    {
        $shaper = new Select2Shaper(Customer::instance(), 'name');

        return $shaper->shape($request);
    }

    public function show(Customer $customer)
    {
        return fractal()
            ->item($customer, new CustomerTransformer())
            ->toArray();
    }

    public function store(CustomerStoreUpdateRequest $request)
    {
        $project = Customer::create($request->all());

        return fractal()
            ->item($project, new CustomerTransformer())
            ->toArray();
    }

    public function update(Customer $customer, CustomerStoreUpdateRequest $request)
    {
        $customer->update($request->all());

        return $this->responseSuccess();
    }

    public function destroy(Customer $customer, CustomerDestroyRequest $request)
    {
        $customer->delete();

        return $this->responseSuccess();
    }
}