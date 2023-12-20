<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\BayarListrik;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class BayarListrikController extends Controller
{
    public function index()
    {
        $pembayaran = BayarListrik::all();
        return response(
            [
                'message' => 'Get all pembayaran listrik success',
                'data' => $pembayaran,
            ],
            200
        );
    }

    public function show($id)
    {
        $pembayaran = BayarListrik::where('id_user', $id)->get();

        if (!$pembayaran) {
            return response(
                [
                    'message' => 'Pembayaran not found',
                    'data' => '',
                ],
                404
            );
        }

        return response([
            'message' => 'Get token listrik data success',
            'data' => $pembayaran,
        ], 200);
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'no_pelanggan' => 'required',
            'harga' => 'required|numeric',
        ]);

        if ($validator->fails()) {
            return response()->json(['error' => $validator->errors()], 400);
        }
        $user = User::where('id', Auth::user()->id)->with('rekening')->first();

        $user->rekening->saldo -= $request['harga'];
        $user->rekening->save();

        $request['id_user'] = $user->id;
        // Token will be generated if the payment is successful
        $token = $this->generateToken();
        $request->merge(['token' => $token]);

        $pembayaran = BayarListrik::create($request->all());

        return response([
            'message' => 'Pembayaran listrik berhasil',
            'data' => $pembayaran,
        ], 200);
    }

    public function destroy($id)
    {
        $pembayaran = BayarListrik::find($id);

        if (!$pembayaran) {
            return response()->json(['message' => 'Pembayaran not found'], 404);
        }

        $pembayaran->delete();

        return response([
            'message' => 'Delete pembayaran listrik success',
            'data' => $pembayaran,
        ], 200);
    }

    private function generateToken()
    {
        $token = '';
        for ($i = 0; $i < 20; $i++) {
            $token .= mt_rand(0, 9);
        }
        return $token;
    }
}
