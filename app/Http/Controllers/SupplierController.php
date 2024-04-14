<?php

namespace App\Http\Controllers;

use App\Models\supplier;
use App\Http\Requests\StoresupplierRequest;
use App\Http\Requests\UpdatesupplierRequest;
use Illuminate\Http\RedirectResponse;

class SupplierController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('dashboard.supplier.index', [
            'suppliers' => supplier::all()
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('dashboard.supplier.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoresupplierRequest $request): RedirectResponse
    {
        $data = $request->validate([
            'company_name' => 'required',
            'email' => 'required',
            'phone' => 'required|numeric',
            'address' => 'required',
        ]);

        supplier::create($data);

        return redirect('/dashboard/suppliers')->with('success', 'Data supplier berhasil ditambahkan');
    }

    /**
     * Display the specified resource.
     */
    public function show(supplier $supplier)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(supplier $supplier)
    {
        return view('dashboard.supplier.update', [
            'supplier' => $supplier
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdatesupplierRequest $request, supplier $supplier)
    {
        $validate = $request->validate([
            'company_name' => 'required',
            'email' => 'required',
            'phone' => 'required|numeric',
            'address' => 'required',
        ]);
        supplier::where('id', $supplier->id)->update($validate);

        return redirect('dashboard/suppliers')->with('success', 'Data supplier has been updated');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(supplier $supplier)
    {
        supplier::destroy($supplier->id);
        return redirect('dashboard/suppliers')->with('success', 'Data has been deleted');
    }
}
