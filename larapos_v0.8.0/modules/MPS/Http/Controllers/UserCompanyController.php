<?php

namespace Modules\MPS\Http\Controllers;

use Illuminate\Http\Request;
use Modules\MPS\Models\Customer;
use Modules\MPS\Models\Supplier;
use Illuminate\Routing\Controller;

class UserCompanyController extends Controller
{
    public function show()
    {
        $user = auth()->user();
        if ($user && $user->customer_id) {
            return response(Customer::select(['name', 'phone', 'company', 'address', 'extra_attributes', 'house_no', 'street_no', 'city', 'postal_code', 'email', 'state', 'country'])->find($user->customer_id));
        } elseif ($user && $user->supplier_id) {
            return response(Supplier::select(['name', 'phone', 'company', 'address', 'extra_attributes', 'house_no', 'street_no', 'city', 'postal_code', 'email', 'state', 'country'])->find($user->supplier_id));
        }
        return [];
    }

    public function update(Request $request)
    {
        $data = $request->validate([
            'name'             => 'required',
            'phone'            => 'nullable',
            'company'          => 'nullable',
            'address'          => 'nullable',
            'extra_attributes' => 'nullable',
            'house_no'         => 'nullable',
            'street_no'        => 'nullable',
            'city'             => 'nullable',
            'postal_code'      => 'nullable',
            'email'            => 'nullable|email',
            'state'            => session('require_country') == 1 ? 'required' : 'nullable',
            'country'          => session('require_country') == 1 ? 'required' : 'nullable',
        ]);

        $user = auth()->user();
        if ($user && $user->customer_id) {
            $user->customer()->update($data);
            return response(['success' => true]);
        } elseif ($user && $user->supplier_id) {
            $user->supplier()->update($data);
            return response(['success' => true]);
        }
        return response(['success' => false]);
    }
}
