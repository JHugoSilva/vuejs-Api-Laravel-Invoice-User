<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class CustomerController extends Controller
{

    public function index() {

        $customers = Customer::latest()->get();

        return response()->json([
            'customers' => $customers
        ], Response::HTTP_OK);
    }
}
