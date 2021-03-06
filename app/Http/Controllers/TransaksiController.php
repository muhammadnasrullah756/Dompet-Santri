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
    // public function tambahkan_barang($id, request $request)
    // {
    //     $transaksi = new transaksi;

    //     $subtotal =0;

    //     foreach ($request->jumlah as $key=>$insert)
    //     {
    //         $barang = katalog::find($id);
    //         $saverecord=[
    //             'transaksi_id' => $transaksi->id,
    //             'katalog_id' => $barang->id,
    //             'jumlah' => $request->jumlah[$key]
    //         ];
    //         DB::table('orders')->insert($saverecord);

    //         $subtotal = $subtotal+($barang->harga_barang*$request->jumlah[$key]);
    //     }

     
    //     $transaksi->subtotal = $subtotal;
    //     $transaksi->status = 'belum dibayar';
    //     $transaksi->save();
    //     // $record=[
    //     //     'subtotal' => $subtotal,
    //     //     'status' => 'belum dibayar'
    //     // ];
    //     // DB::table('transaksis')->insert($record);
        
    //     return response()->json([
    //         'status' => 'success',
    //         'data' =>$transaksi
    //     ],200);
    // }

    // public function buat_cart()
    // {
    //     $cart = new cart;

    //     return response()->json(['status'=>'Cart sudah dibuat'],200);
    // }

    public function add_barang ($id)
    {
        $barang = katalog::find($id);
        $cart = new cart;
        $cart->katalog_id = $barang->id;
        $cart->jumlah = 1;
        $cart->save();

        return response()->json(['barang' => $cart],200);
    }

    
    public function tambahkan_barang($id) {
        
        $barang = cart::where('katalog_id',$id)->first();
        $barang->jumlah = $barang->jumlah+1;
        $barang->save();

        return response()->json(['status' => 'barang ditambahkan']);
    }

    public function kurangi_barang($id){
        $barang = cart::where('katalog_id',$id)->first();
        $barang->jumlah = $barang->jumlah-1;
        $barang->save();

        return response()->json(['status' => 'barang dikurangi']);
    }
    public function delete_barang_cart($id){
        $barang = cart::where('katalog_id',$id);
        $barang->delete();

        return response()->json(['status' => 'barang dihapus dari keranjang'],200);
    }

    public function delete_cart()
    {
        $cart = cart::truncate();
       
        return response()->json(['status' => 'deleted'], 200);
    }


    public function show_cart(){
        $cart = cart::all();

        return response()->json($cart,200);
    }

    public function ke_checkout(){
        $checkout = new transaksi;
        
        $checkout->subtotal = 0;
        $checkout->status = 'belum dibayar';
        $total = $checkout->subtotal;
        $checkout->save();
        $cart = cart::all();
        foreach ($cart as $cart){
            $order = new order;
            $id_transaksi = transaksi::latest()->first()->id;
            $order->transaksi_id = $id_transaksi;
            $order->katalog_id = $cart->katalog_id;
            $id_barang = $order->katalog_id;
            $order->jumlah = $cart->jumlah;
            
            $jumlah_barang = $order->jumlah;
            $harga = katalog::where('id',$id_barang)->first();
            $harga_barang = $harga->harga_barang;
            $total = $total+($harga_barang*$jumlah_barang);
            $checkout->subtotal = $total;
            $order->save();
        }
        
        $checkout->update();
        $cart->delete();

        return response()->json([$checkout]);
    }

    public function get_transaksi_data(){
        $trasaksi = transaksi::all();

        return response()->json(['data' => $trasaksi],200);
    }

    public function show_transaksi($id)
    {
        $data = transaksi::find($id);
        $order = order::where('transaksi_id',$id)->get();

        return response()->json(
            ['data transaksi' => $data,
            'data barang' => $order],200);
    }

    public function delete_transaksi($id)
    {
        $data = transaksi::find($id);
        $data->delete();

        return response()->json(
            [   'id' => $id,
                'status' => 'transaksi telah dihapus'],200);
    }

    public function data_order(){
        $data = order::all();

        return response()->json(['data' =>$data],200);
    }
}
