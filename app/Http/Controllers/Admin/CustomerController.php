<?php

namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Address;
use Illuminate\Support\Facades\Hash;

class CustomerController extends Controller
{
    public function index(Request $request){
        $status = $request->status;

        $query = User::where('role_id', \Helper::getRoleId('customer'))->with('addresses')->get();

        return view('admin.customer.index', ['users' => $query]);
    }
}
