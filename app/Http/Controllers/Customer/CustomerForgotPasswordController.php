<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use App\Models\Customer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Str;
use Illuminate\Validation\Rules;

class CustomerForgotPasswordController extends Controller
{
    /**
     * CATATAN PENTING: fitur ini HANYA berfungsi untuk customer yang mengisi
     * email saat registrasi (email bersifat opsional di form daftar).
     * Kalau customer tidak punya email terdaftar, admin harus reset manual
     * lewat `php artisan tinker`.
     */
    public function showRequestForm()
    {
        return view('customer.auth.forgot-password');
    }

    public function sendResetLink(Request $request)
    {
        $request->validate(['email' => 'required|email']);

        $customer = Customer::where('email', $request->email)->first();

        if (!$customer) {
            // Sengaja tidak bilang "email tidak ditemukan" secara eksplisit,
            // supaya orang lain tidak bisa dipakai untuk mengecek email mana
            // saja yang terdaftar di sistem (privacy/security best practice).
            return back()->with('success', 'Kalau email tersebut terdaftar, link reset password sudah kami kirim.');
        }

        $status = Password::broker('customers')->sendResetLink(['email' => $request->email]);

        return back()->with('success', 'Kalau email tersebut terdaftar, link reset password sudah kami kirim.');
    }

    public function showResetForm(Request $request, string $token)
    {
        return view('customer.auth.reset-password', [
            'token' => $token,
            'email' => $request->email,
        ]);
    }

    public function resetPassword(Request $request)
    {
        $validated = $request->validate([
            'token' => 'required',
            'email' => 'required|email',
            'password' => ['required', 'confirmed', Rules\Password::min(6)],
        ]);

        $status = Password::broker('customers')->reset(
            $validated,
            function (Customer $customer, string $password) {
                $customer->update([
                    'password' => Hash::make($password),
                    'remember_token' => Str::random(60),
                ]);
            }
        );

        if ($status === Password::PASSWORD_RESET) {
            return redirect()->route('customer.login')->with('success', 'Password berhasil direset. Silakan masuk dengan password baru.');
        }

        return back()->withErrors(['email' => 'Link reset tidak valid atau sudah kedaluwarsa.']);
    }
}