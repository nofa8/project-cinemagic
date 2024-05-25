<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use Illuminate\Http\Request;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\View\View;


class CustomerController extends Controller
{
    use AuthorizesRequests;
    public function __construct()
    {
        $this->authorizeResource(Customer::class);
    }

    public function index(): View
    {
        $allCourses = Customer::orderBy('type')->orderBy('name')->paginate(20)->withQueryString();

        return view('courses.index')->with('allCourses', $allCourses);
    }

    public function edit(Customer $customer): View
    {
        return view('customer.edit')
            ->with('customer', $customer);
    }
    
}
