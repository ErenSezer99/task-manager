<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class RegisterController extends Controller
{
    /**
     * Yeni controller instance'ı oluştur.
     */
    public function __construct()
    {
        $this->middleware('guest');
    }

    /**
     * Register sayfasını görüntüler.
     */
    public function showRegistrationForm()
    {
        return view('auth.register');
    }

    /**
     * Kullanıcıyı kaydeder ve giriş sayfasına yönlendirir.
     */
    public function register(Request $request)
    {
        // Gelen veriyi doğrula
        $request->validate([
            'name' => ['required', 'string', 'max:255', 'unique:users,name'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users,email'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
        ]);

        // Kullanıcıyı oluştur
        User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);

        // Başarı mesajıyla login sayfasına yönlendir
        return redirect()->route('login')->with('success', 'Kayıt işlemi başarılı. Lütfen giriş yapın.');
    }
}
