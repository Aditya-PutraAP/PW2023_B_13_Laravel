<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use App\Models\Rekening;

class RekeningController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $rekening = Rekening::where('nama', '!=', 'Admin')->get();
        return response([
            'message' => 'Success',
            'data' => $rekening,
        ], 200);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $storeData = $request->all();

        $validate = Validator::make($storeData, [
            'nama' => 'required',
            'nik' => 'required',
            'alamat' => 'required',
            'tempat_lahir' => 'required',
            'tgl_lahir' => 'required',
            'jenis_kelamin' => 'required',
            'saldo' => 'required',
        ]);

        if ($validate->fails()) {
            return response(['message'=> $validate->errors()],400);
        }

        $storeData['no_rek'] = now()->format('Ymd') . Rekening::count() + 1;
        $rekening = Rekening::create($storeData);
        return response([
            'message' => 'Content Added Successfully',
            'data' => $rekening,
        ],200);
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $rekening = Rekening::find($id);

        if (is_null($rekening)) {
            return response(['message' => 'Rekening tidak ditemukan'], 404);
        }

        return response([
            'message' => 'Success',
            'data' => $rekening,
        ], 200);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $updateData = $request->all();

        $validate = Validator::make($updateData, [
            'nama' => 'required',
            'nik' => 'required',
            'alamat' => 'required',
            'tempat_lahir' => 'required',
            'tgl_lahir' => 'required',
            'jenis_kelamin' => 'required',
        ]);

        if ($validate->fails()) {
            return response(['message' => $validate->errors()], 400);
        }

        $rekening = Rekening::find($id);

        if (is_null($rekening)) {
            return response(['message' => 'Rekening tidak ditemukan'], 404);
        }

        $rekening->update($updateData);

        return response([
            'message' => 'Berhasil update data Rekening',
            'data' => $rekening,
        ], 200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $rekening = Rekening::find($id);

        if (is_null($rekening)) {
            return response(['message' => 'Rekening tidak ditemukan'], 404);
        }

        $rekening->delete();

        return response([
            'message' => 'Berhasil hapus data Rekening',
        ], 200);
    }
}
