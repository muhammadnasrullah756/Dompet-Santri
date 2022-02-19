<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class BalanceController extends Controller
{
    public function show_withdrawal(request $request)
    {
        $user = $request->user();

        return response()->json([
            'nama' => $user->name,
            'balance' => $user->balance
        ],200);
    }
    public function withdraw (request $request)
    {
        $user = $request->user();
        $balance = $user->balance;
        $withdraw = $request->tarik;
        
        $sisa = $balance-$withdraw;
        $balance = $sisa;
        $user->save();

        return response()->json([
            'status' => 'success',
            'Sisa saldo' => $balance
        ]);
        
    }
}
