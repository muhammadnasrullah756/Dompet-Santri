<?php

namespace App\Http\Controllers;

use App\cart;
use App\order;
use App\katalog;
use App\transaksi;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;


class TransaksiController extends Controller
{
    public function tambahkan_barang($id, request $request)
    {
        $transaksi = new transaksi;

        $subtotal =0;

        foreach ($request->jumlah as $key=>$insert)
        {
            $barang = katalog::find($id);
            $saverecord=[
                'transaksi_id' => $transaksi->id,
                'katalog_id' => $barang->id,
                'jumlah' => $request->jumlah[$key]
            ];
            DB::table('orders')->insert($saverecord);

            $subtotal = $subtotal+($barang->harga_barang*$request->jumlah[$key]);
        }

     
        $transaksi->subtotal = $subtotal;
        $transaksi->status = 'belum dibayar';
        $transaksi->save();
        // $record=[
        //     'subtotal' => $subtotal,
        //     'status' => 'belum dibayar'
        // ];
        // DB::table('transaksis')->insert($record);
        
        return response()->json([
            'status' => 'success',
            'data' =>$transaksi
        ],200);
    }

    public function get_transaksi_data(){
        $trasaksi = transaksi::all();

        return response()->json(['data' => $trasaksi],200);
    }

    public function show_transaksi($id)
    {
        $data = transaksi::find($id);

        return response()->json(['data' => $data],200);
    }
}
