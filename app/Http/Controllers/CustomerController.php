<?php

namespace App\Http\Controllers;

use App\Http\Requests\ListCustomerRequest;
use App\Http\Resources\CustomerCollection;
use App\Services\Interfaces\CustomerServiceInterface;
use Illuminate\Http\Request;

class CustomerController extends Controller
{
    private $customerService;

    public function __construct(CustomerServiceInterface $customerService)
    {
        $this->customerService = $customerService;
    }

    public function list(ListCustomerRequest $request)
    {
        $requestOptions = $request->validated();
        return new CustomerCollection($this->customerService->list($requestOptions));
    }
}
