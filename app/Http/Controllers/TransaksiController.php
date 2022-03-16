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
        
        $barang = cart::where('katalog_id',$id)->get();
        $barang->jumlah = $barang->jumlah+1;

        return response()->json(['status' => 'barang ditambahkan']);
    }

    public function kurangi_barang($id){
        $barang = cart::where('katalog_id',$id)->get();
        $barang->jumlah = $barang->jumlah-1;

        return response()->json(['status' => 'barang dikurangi']);
    }
    public function delete_barang_cart($id){
        $barang = cart::where('katalog_id',$id)->delete();

        return response()->json(['status' => 'barang dihapus'],200);
    }

    public function delete_cart()
    {
        $cart = cart::all()->delete();
        return response()->json(['status' => 'deleted'], 200);
    }


    public function show_cart(){
        $cart = cart::all();

        return response()->json($cart,200);
    }

    public function ke_checkout(){
        $checkout = new transaksi;
        $checkout->subtotal = 0;
        $total = $checkout->subtotal;
        $cart = cart::all();
        foreach ($cart as $cart){
            $order = new order;
            $order->transaksi_id = $checkout->id;
            $order->katalog_id = $cart->katalog_id;
            $order->jumlah = $cart->jumlah;
            $total = $total+($order->katalog->harga_barang*$order->jumlah);
        }
        $cart->delete();

        return response()->json(['data'=>$checkout]);
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
