<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Saldo;
Use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;

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
            'user_id' => Auth::id(),
            'nominal' => $request->nominal,
            'pict' => $result,
            'status' => 'Waiting'
        ];

        if($saldo = Saldo::create($params)) {
            $response = ['saldo' => $saldo];
            return $this->responseOk($response);
        } else {
            return $this->responseError('Fill in Balance Error,400');
        }
    }

    public function showall() {
        $data = Saldo::where('user_id', Auth::id())->get();
        return $this->responseOk($data);
    }

    public function detail($id) {
        $data = Saldo::find($id);
        return $this->responseOk($data);
    }

    public function historydashboard() {
        $data = Saldo::where('user_id', Auth::id())->get();
        return $this->responseOk($data);
    }
}
