<?php

namespace App\Http\Controllers;

use App\Models\product;
use App\Http\Requests\StoreproductRequest;
use App\Http\Requests\UpdateproductRequest;
use App\Models\supplier;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // dd(product::all());
        // dd(product::with('supplier')->get());
        return view('dashboard.product.index', [
            'products' => product::all()
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('dashboard.product.create', [
            'suppliers' => supplier::all()
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreproductRequest $request)
    {
        $validate = $request->validate([
            'merk' => 'required',
            'company_id' => 'required',
            'code' => 'required',
            'name' => 'required',
            'buy_price' => 'required|numeric',
            'sell_price' => 'required|numeric',
            'stock' => 'required|numeric',
            'category' => 'required',
        ]);

        product::create($validate);
        return redirect('/dashboard/products')->with('success', 'Data product has been added');
    }

    /**
     * Display the specified resource.
     */
    public function show(product $product)
    {

    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(product $product)
    {
        return view('dashboard.product.update', [
            'product' => $product,
            'suppliers' => supplier::all()
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateproductRequest $request, product $product)
    {
        $validate = $request->validate([
            'merk' => 'required',
            'company_id' => 'required',
            'code' => 'required',
            'name' => 'required',
            'buy_price' => 'required|numeric',
            'sell_price' => 'required|numeric',
            'stock' => 'required|numeric',
            'category' => 'required',
        ]);

        $product->where('id', $product->id)->update($validate);
        return redirect('/dashboard/products')->with('success', 'Data product has been updated');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(product $product)
    {
        $product->destroy($product->id);
        return redirect('/dashboard/products')->with('success', 'Data product has been deleted');
    }

    public function take($code){
        $product = product::where('code', $code)->first();
        // $product = product::where('code')->get();
        return [
            'product' => $product
        ];
    }

    public function nameSuggestion($name){
        $product = product::where('name', 'like', '%'.$name.'%')->get();
        return [
            'product' => $product
        ];
    }
}
