<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Saldo;

class BaseController extends Controller
{
    public function responseOk($result, $code = 200, $message = 'Success')
    {
        $response = [
            'code' => $code,
            'data' => $result,
            'message' => $message
        ];

        return response()->json($response, $code);
    }

    public function responseError($error, $code = 422, $errorDetails = [])
    {
        $response = [
            'code' => $code,
            'error' => $error
        ];

        if (!empty($errorDetails)) {
            $response['errorDetails'] = $errorDetails;
        }

        return response()->json($response, $code);
    }


    public function tambah(Request $request , $id) {
        $data = Saldo::find($id);
        $status = $data->status;
        $nominal = $data->nominal;
        if($status == "Success") {
            $user = $request->user();
            $balance = $user->balance;
            $total = $balance+$nominal;
            $user->update([
                'balance' => $total
            ]);
            return $this->responseOk($user);
        } else {
            return $this->responseError('Cant Add Balance',422);
        }
    }

    public function tarik(Request $request, $id) {
        $data = Saldo::find($id);
        $tarik = $data->nominal;
        $status = $data->status;

        $user = $request->user();
        $balance = $user->balance;

        if($status == "Success") {
            $hasil = $balance-$tarik;
            $user->update([
                'balance' => $hasil
            ]);
            return $this->responseOk($user);
        } else {
            return $this->responseError('Cant Withdraw Balance',422);
        }


    }
}
