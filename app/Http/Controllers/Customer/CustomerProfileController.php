<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules\Password;

class CustomerProfileController extends Controller
{
    public function edit()
    {
        $customer = Auth::guard('customer')->user();
        return view('customer.profile', compact('customer'));
    }

    /**
     * Update kontak (nama, no HP, email). Password TIDAK diubah di sini
     * — sengaja dipisah ke method updatePassword() demi keamanan
     * (ganti kontak dan ganti password idealnya 2 aksi terpisah).
     */
    public function update(Request $request)
    {
        $customer = Auth::guard('customer')->user();

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'phone' => 'required|string|max:20|unique:customers,phone,' . $customer->id,
            'email' => 'nullable|email',
        ], [
            'phone.unique' => 'Nomor HP ini sudah dipakai akun lain.',
        ]);

        $customer->update($validated);

        return back()->with('success', 'Data kontak berhasil diperbarui.');
    }

    /**
     * Ganti password — wajib masukkan password LAMA dulu untuk verifikasi,
     * biar orang yang kebetulan lihat sesi login terbuka (misal HP dipinjam)
     * nggak bisa asal ganti password tanpa tahu password aslinya.
     */
    public function updatePassword(Request $request)
    {
        $customer = Auth::guard('customer')->user();

        $validated = $request->validate([
            'current_password' => 'required',
            'password' => ['required', 'confirmed', Password::min(6)],
        ]);

        if (!Hash::check($validated['current_password'], $customer->password)) {
            return back()->withErrors(['current_password' => 'Password lama salah.']);
        }

        $customer->update(['password' => Hash::make($validated['password'])]);

        return back()->with('success', 'Password berhasil diganti.');
    }
}