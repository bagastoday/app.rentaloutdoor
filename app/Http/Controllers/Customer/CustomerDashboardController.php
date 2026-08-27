<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class CustomerDashboardController extends Controller
{
    /**
     * Riwayat sewa milik customer yang sedang login.
     * Sengaja dibuat sesimpel mungkin: 1 halaman, list invoice + status.
     */
    public function index()
    {
        $customer = Auth::guard('customer')->user();

        $rentals = $customer->rentals()
            ->with('details.item')
            ->latest()
            ->paginate(10);

        return view('customer.dashboard', compact('rentals'));
    }
}
