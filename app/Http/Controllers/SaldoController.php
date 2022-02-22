<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Saldo;
Use Illuminate\Support\Facades\Validator;

class SaldoController extends BaseController
{
    public function addSaldo(Request $request) {
        $validator = Validator::make($request->all(), [
            'nominal' => 'required|integer',
            'pict' => 'required|mimes:png,jpg,jpeg|max:2048'
        ]);

        if($validator->fails()) {
            return $this->responseError('Please Fill All Required Fields',422, $validator->errors());
        }

        $image = $request->file('pict');
        $result = CloudinaryStorage::upload($image->getRealPath(), $image->getClientOriginalName());

        $params = [
            'nominal' => $request->nominal,
            'pict' => $result,
            'transaksi' => 'Waiting'
        ];

        if($saldo = Saldo::create($params)) {
            $response = ['saldo' => $saldo];
            return $this->response($response);
        } else {
            return $this->responseError('Fill in Balance Error,400');
        }
    }
}
