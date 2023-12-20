<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;
use App\Models\Kredit;
use App\Models\Rekening;
use App\Models\User;

class KreditController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $kredit = Kredit::get();

        if($kredit){
            return response([
                'message' => 'Tampil semua kredit',
                'data' => $kredit,
            ], 200);
        }
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $storeData = $request->all();

        $validate = Validator::make($storeData, [
            'nama' => 'required',
            'jumlah_uang' => 'required',
            'waktu_pengembalian' => 'required',
        ]);

        $user = User::where('id', Auth::user()->id)->with('rekening')->first();
            
        $user->rekening->saldo += $storeData['jumlah_uang'];
        $user->rekening->save();

        $storeData['id_user'] = $user->id;

        $kredit = Kredit::create($storeData);

        return response([
            'message' => 'Anda berhasil melakukan Kredit',
            'data' => $kredit,
        ], 200);
    }

    //request kredit
    public function kredit(Request $request, $id)
    {
        $request->all();
        $kredit = Kredit::find($id);

        if ($kredit) {
            if($request->status == 'Diterima'){
                $kredit->status = 'Diterima'; 
                $kredit->save();
                return response([
                    'message' => 'Status kredit berhasil diupdate',
                    'data' => $kredit,
                ], 200);
            } else{
                $kredit->status = 'Ditolak'; 
                $kredit->save();
                return response([
                    'message' => 'Status kredit berhasil diupdate',
                    'data' => $kredit,
                ], 200);
            }
            
        } else {
            return response(['error' => 'Kredit tidak ditemukan'], 400);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $kredit = Kredit::where('id_user', $id)->get();
        return response([
            'message' => 'Tampil kredit user',
            'data' => $kredit,
        ], 200);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
