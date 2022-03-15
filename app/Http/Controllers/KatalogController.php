<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\katalog;

class KatalogController extends Controller
{
    public function home ()
    {
        $katalog = katalog::all();

        return response()->json($katalog,200);
    }

    public function store (request $request)
    {
        $request->validate([
            'gambar_barang' => 'required|mimes:png,jpg,jpeg|max:2048',
            'nama_barang' => 'required|string',
            'harga_barang' => 'required|string'
        ]);

        $image  = $request->file('gambar_barang');
        $result = CloudinaryStorage::upload($image->getRealPath(), $image->getClientOriginalName()); 

        $barang = new katalog;

        $barang->gambar_barang = $result;
        $barang->nama_barang = $request->nama_barang;
        $barang->harga_barang = $request->harga_barang;
        $barang->save();
        

        return response()->json(
        ['nama barang' => $barang->nama_barang,
        'harga barang'=>$barang->harga_barang],200);
    }

    public function show_one ($id)
    {
        $barang = katalog::find($id);

        return response()->json($barang,200);
    }

    public function edit ($id,request $request)
    {
        $barang = katalog::find($id);

        // $request->validate([
        //     'gambar_barang' => 'required|mimes:png,jpg,jpeg|max:2048',
        //     'nama_barang' => 'required|string',
        //     'harga_barang' => 'required|string'
        // ]);

        $image  = $request->file('gambar_barang');
        $result = CloudinaryStorage::replace($barang->gambar_barang, $image->getRealPath(), $image->getClientOriginalName());

        $barang->update([
            'gambar_barang' =>$result,
            'nama_barang' =>$request->nama_barang,
            'harga_barang' =>$request->harga_barang,
        ]);
        // $barang->gambar_barang = $result;
        // $barang->nama_barang = $request->nama_barang;
        // $barang->harga_barang = $request->harga_barang;
        // $barang->save();

        return response()->json($barang,200);
    }

    public function delete ($id) {
        
        $barang = katalog::find($id);
        CloudinaryStorage::delete($barang->gambar_barang);
        $barang->destroy($id);



        return response()->json([
            "status" => "katalog barang telah dihapus"
        ],200);
    }
}
