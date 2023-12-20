<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use App\Mail\MailSend;
use App\Models\User;
use App\Models\Rekening;
use Laravel\Passport\HasApiTokens;

class AuthController extends Controller
{
    use HasApiTokens;
    public function register(Request $request)
    {
        $registrationData = $request->all();
        $str = Str::random(100);
        $rekening = Rekening::where('no_rek', $registrationData['no_rek'])->first();

        if(is_null($rekening)){
            return response(['message' => 'Nomor Rekening tidak ditemukan'], 400);
        }   

        $validate = Validator::make($registrationData, [
            'username' => 'required',
            'password' => 'required|min:5',
            'email' => 'required|email:rfc,dns|unique:users',
            'no_telp' => 'required|min:12',
        ]);

        if ($validate->fails()) {
            return response(['message' => $validate->errors()->first()], 400);
        }

        $registrationData['id_rekening'] = $rekening->id;
        $registrationData['password'] = bcrypt($request->password);
        $registrationData['verify_key'] = $str;

        $details = [
            'username' => $request->username,
            'website' => 'Bank',
            'datetime' => now(),
            'url' => request()->getHttpHost() . '/register/verify/' . $str
        ];

        Mail::to($request->email)->send(new MailSend($details));
        $user = User::create($registrationData);

        return response([
            'message' => 'Link verifikasi telah dikirim ke email anda. Silakan cek email anda untuk mengaktifkan akun.',
            'data' => $user,
        ], 200);
    }

    public function verify($verify_key)
    {
        $keyCheck = User::where('verify_key', $verify_key)->exists();

        if ($keyCheck) {
            $user = User::where('verify_key', $verify_key)
                ->update([
                    'active' => 1,
                    'email_verified_at' => date('Y-m-d H:i:s'),
                ]);

            return "Verifikasi berhasil. Akun anda sudah aktif.";
        } else {
            return "Keys tidak valid.";
        }
    }

    public function login(Request $request)
    {
        $loginData = $request->all();

        $validate = Validator::make($loginData, [
            'email' => 'required|email:rfc,dns',
            'password' => 'required|min:5',
        ]);
        if ($validate->fails()) {
            return response(['message' => $validate->errors()->first()], 400);
        }

        if (!Auth::attempt($loginData)) {
            return response(['message' => 'Email dan Password Invalid'], 401);
        }

        if(!Auth::user()->active){
            return response(['message' => 'Akun belum diverifikasi, harap cek Email'], 401);
        }
        $user = Auth::user();
        $token = $user->createToken('Authentication Token')->accessToken;

        return response([
            'message' => 'Authenticated',
            'data' => $user,
            'token_type' => 'Bearer',
            'access_token' => $token
        ]);
    }

    public function logout(Request $request)
    {
        $request->user()->token()->revoke();

        return response([
            'message' => 'Logged out'
        ]);
    }

    /**
     * Display a listing of the resource.
     */

    //tampil profile user
    public function index()
    {
        $user = User::where('id', Auth::user()->id)->get()->load('rekening');

        if ($user) {
            return response([
                'message' => 'Tampil profile user',
                'data' => $user,
            ], 200);
        }
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request, $id)
    {
        $user = User::find($id);

        if (!$user) {       
            return response(['error' => 'User not found'], 404);
        }

        $request->validate([
            'profile_picture' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);

        if($request->hasFile('profile_picture')){
            $uploadFolder = 'profile_picture';
            $image = $request->file('profile_picture');
            $image_uploaded_path = $image->store($uploadFolder, 'public');
            $uploadedImageResponse = basename($image_uploaded_path);

            Storage::disk('public')->delete('profile_picture/'.$user->profile_picture);

            $user->update(['profile_picture' => $uploadedImageResponse]);
        }

        $uploadFolder = 'profile_picture';
        $image = $request->file('profile_picture');
        $image_uploaded_path = $image->store($uploadFolder, 'public');
        $uploadedImageResponse = basename($image_uploaded_path);

        $user->update(['profile_picture' => $uploadedImageResponse]);

        return response([
            'message' => 'Berhasil menambahkan profile picture',
            'data' => $user,
        ], 200);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
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
