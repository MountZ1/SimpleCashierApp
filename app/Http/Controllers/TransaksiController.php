<?php

namespace App\Http\Controllers;

use App\Models\transaksi;
use PhpParser\Node\Stmt\TryCatch;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Date;
use App\Http\Requests\StoretransaksiRequest;
use App\Http\Requests\UpdatetransaksiRequest;
use App\Models\detail_transaksi;
use Carbon\Carbon;
use Illuminate\Support\Facades\Log;

class TransaksiController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('dashboard.order.index', [
            'orders' => transaksi::select('id', 'invoice', 'date', 'total', 'cashier')->get()
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('dashboard.order.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoretransaksiRequest $request)
    {
        // dd($request->all());
        $change = $request->pay_amount - $request->total;
        try{
            DB::beginTransaction();
            transaksi::create([
                'invoice' => $request->invoice,
                'date' => Carbon::now(),
                'total' => $request->total,
                'payment' => $request->payment,
                'pay_amount' => $request->pay_amount,
                'change' => $change,
                'cashier' => $request->cashier
            ]);

            foreach($request->order as $item){
                detail_transaksi::create([
                    'invoice' => $request->invoice,
                    'product_id' => $item['id'],
                    'qty' => $item['quantity'],
                ]);
            }

            DB::commit();

            return redirect('/dashboard/orders');
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error($e->getMessage());

            return redirect('/dashboard/orders');
        }
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $transaksi = transaksi::with('detailpembelian.Product')->find($id);
        $order = [
            'id' => $transaksi->id,
            'invoice' => $transaksi->invoice,
            'date' => $transaksi->date,
            'total' => $transaksi->total,
            'payment' => $transaksi->payment,
            'pay_amount' => $transaksi->pay_amount,
            'change' => $transaksi->change,
            'cashier' => $transaksi->cashier,
            'detail' => $transaksi->detailpembelian->map(function ($detail){
                return [
                    'id' => $detail->id,
                    'item' => $detail->product->pluck('merk'). ' ' . $detail->product->pluck('name'),
                    'price' => $detail->product->pluck('sell_price'),
                    'qty' => $detail->qty
                ];
            })
        ];
        return view('dashboard.order.update', [
            'order' => $transaksi,
        ]);
    }


    /**
     * Show the form for editing the specified resource.
     */
    public function edit(transaksi $transaksi)
    {
        dd($transaksi->id);
    //    return view('dashboard.order.update')->with("order", $transaksi);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdatetransaksiRequest $request, transaksi $transaksi)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(transaksi $transaksi)
    {
        //
    }
}
