<?php

namespace Modules\MPS\Http\Controllers;

use Illuminate\Http\Request;
use Modules\MPS\Models\User;
use Modules\MPS\Models\Supplier;
use Modules\MPS\Http\Requests\SupplierRequest;
use Modules\MPS\Http\Requests\SupplierUserRequest;

class SupplierController extends Controller
{
    public function addUser(SupplierUserRequest $request)
    {
        $user = User::create($request->validated());
        $user->assignRole('supplier');
        return response()->json(['success' => true, 'user' => $user]);
    }

    public function create()
    {
        return extra_attributes('supplier');
    }

    public function deleteUser(User $user)
    {
        return response()->json(['success' => $user->del()]);
    }

    public function destroy(Supplier $supplier)
    {
        return response(['success' => $supplier->del()]);
    }

    public function destroyMany(Request $request)
    {
        $count = $failed = 0;
        foreach (Supplier::whereIn('id', $request->ids)->get() as $supplier) {
            $supplier->del() ? $count++ : $failed++;
        }
        return response(['success' => !!$count, 'count' => $count, 'failed' => $failed]);
    }

    public function index(Request $request)
    {
        $suppliers = Supplier::query()->with('journal');
        if ($request->due_limit) {
            $suppliers->whereHas('journal', fn ($q) => $q->whereRaw('balance >= (suppliers.due_limit * (?/100))', $request->only('due_limit')));
        }
        return response()->json($suppliers->table(Supplier::$searchable));
    }

    public function show(Supplier $supplier)
    {
        $supplier->attributes = extra_attributes('supplier');
        return $supplier;
    }

    public function store(SupplierRequest $request)
    {
        $supplier = Supplier::create($request->validated());
        return response(['success' => !!$supplier, 'data' => $supplier]);
    }

    public function update(SupplierRequest $request, Supplier $supplier)
    {
        $updated = $supplier->update($request->validated());
        return response(['success' => $updated, 'data' => $supplier->refresh()]);
    }

    public function updateUser(SupplierUserRequest $request, User $user)
    {
        $user->update($request->validated());
        return response()->json(['success' => true, 'user' => $user->refresh()]);
    }

    public function users($supplier_id)
    {
        return User::ofSupplier($supplier_id)->get();
    }
}
