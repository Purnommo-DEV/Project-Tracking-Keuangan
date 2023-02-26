<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;
use RealRashid\SweetAlert\Facades\Alert;
use Illuminate\Support\Facades\Validator;

class AuthController extends Controller
{
    public function index()
    {
        return view('Auth.login');
    }

    public function cek_login(Request $request)
    {
        $request->validate([

            'email' => 'required|email',
            'password' => 'required',
        ]);
        if(Auth::attempt($request->only('email','password'))){
            return redirect()->route('DaftarKegiatan');
        }else{
            Alert::error('Gagal Login, <br> <small>Cek kembali Email dan Password Anda</small>');
            return redirect()->route('Login');
        }
    }

    public function ubah_password(Request $request){
        $validator = Validator::make($request->all(), [
            'passwordlama' =>[
                'required', function($attribute, $value, $fail){
                    if(!Hash::check($value, Auth::user()->password)){
                        return $fail(__('Password anda tidak cocok'));
                    }
                },
                'min:3','max:30',
            ],
            'password'=>'required|min:8|max:30',
            'konfirmasipasswordbaru'=>'required|same:password'
            ],
            [
                'passwordlama.required'=> 'Wajib diisi', // custom message
                'passwordlama.min'=> 'Minimal 8 Karakter', // custom message
                'passwordlama.max'=> 'Maksimal 30 Karakter', // custom message
                
                'password.required'=> 'Wajib diisi', // custom message
                'password.min'=> 'Minimal 8 Karakter', // custom message
                'password.max'=> 'Maksimal 30 Karakter', // custom message

                'konfirmasipasswordbaru.required'=> 'Wajib diisi', // custom message
                'konfirmasipasswordbaru.same'=> 'Konfirmasi password tidak tepat' // custom message

            ]);

        if(!$validator->passes()){
            return response()->json([
                'status'=>0,
                'error'=>$validator->errors()->toArray()
            ]);
        }else{
            $updated = User::find(Auth::user()->id)
                ->update([
                    'password'=>Hash::make($request->password)
            ]);
            
            if(!$updated){
                return response()->json([
                    'status'=>0,
                    'msg'=>'Terjadi kesalahan, Gagal mengupdate password'
                ]);
            }else{
                return response()->json([
                    'status'=>1,
                    'msg'=>'Berhasil mengupdate password'
                ]);
            }
        }
    }


    public function logout()
    {
        Session::flush();
        Auth::logout();

        return redirect()->route('Login');
    }
}
