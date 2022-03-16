<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Saldo;
use App\User;
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
            'status' => 'Waiting',
            'type' => 'Isi Saldo'
        ];

        if($saldo = Saldo::create($params)) {
            $response = ['saldo' => $saldo];
            return $this->responseOk($response);
        } else {
            return $this->responseError('Fill in Balance Error', 500);
        }
    }

    // public function showall() {
    //     $data = Saldo::where('user_id', Auth::id())->get();
    //     return $this->responseOk($data);
    // }

    public function detail($id) {
        $data = Saldo::find($id);
        return $this->responseOk($data);
    }

    public function historydashboard() {
        // $data = Saldo::where('user_id', Auth::id())->get();
        $data = Saldo::select("*")
                            ->where([
                                ['user_id', Auth::id()],
                                ['status', "=", "Success"]
                            ])
                            ->get();
        return $this->responseOk($data);
        // return $this->responseOk($data);
    }

    public function transfer(Request $request) {
        // $data = Saldo::where(Auth::id('balance'))->get();
        $data = User::find($request->id)->get();
        return $this->responseOk($data);


    }

    public function coba() {
        $data = Saldo::select("*")
                            ->where([
                                ['user_id', Auth::id()],
                                ['status', "=", "Waiting"]
                            ])
                            ->get();
        return $this->responseOk($data);
        // dd($data);
    }

    public function accept(Request $request, $id) {
        $data = Saldo::find($id);
        // $data->update([
        //     'status' => 'Success'
        // ]);
        $type = $data->type;
        $nominal = $data->nominal;

        if($type == "Isi Saldo") {
            $user = $request->user();
            $balance = $user->balance;
            $total = $balance+$nominal;
            $user->update([
                'balance' => $total,
                'status' => 'Success',
            ]);
            return $this->responseOk($user);
        } else {
            return $this->responseError('Cant Add Balance', 400);
        }

        if($type == "Tarik Dana") {
            $user = $request->user();
            $balance = $user->balance;
            $hasil = $balance-$nominal;
            $user->update([
                'balance' => $hasil,
                'status' => 'Success'
            ]);
            return $this->responseOk($user);
        } else {
            return $this->responseError('Cant Withdraw Balance', 400);
        }



        // $status = $data->status;

        // if($status == "Success") {
            //     $user = $request->user();
            //     $balance = $user->balance;
            //     $total = $balance+$nominal;
            //     $user->update([
            //         'balance' => $total
            //     ]);
            //     return $this->responseOk($user);
            // } else {
            //     return $this->responseError('Cant Add Saldos',422);
            // }
        }

    public function cancel($id) {
        $data = Saldo::find($id);
        $data->update([
            'status' => 'Cancelled'
        ]);
            return $this->responseOk($data);
        }

    public function tarik(Request $request) {
        $user = $request->user();
        $saldo = $user->balance;

        $tarik = $user->balance;
        $hasil = $saldo-$tarik;

        if($data = Saldo::create([
            'user_id' => Auth::id(),
            'nominal' => $tarik,
            'status' => 'Waiting',
            'type' => 'Tarik Dana'
            ])) {
                return $this->responseOk($data);
            } else {
                return $this->responseError('Cancel Withdraw', 400);
                }


        }
    }

                // $request->status = "Success";        Ga kepakek
                // $nominal = $request->saldo('nominal');       Ga Kepakek
