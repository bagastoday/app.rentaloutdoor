<?php

use App\Http\Controllers\Admin\InventoryController;
use App\Http\Controllers\Admin\TransactionController;
use App\Http\Controllers\CatalogController;
use App\Http\Controllers\Customer\CustomerAuthController;
use App\Http\Controllers\Customer\CustomerDashboardController;
use App\Http\Controllers\Customer\CustomerForgotPasswordController;
use App\Http\Controllers\Customer\CustomerProfileController;
use App\Http\Controllers\MidtransWebhookController;
use App\Http\Controllers\PaymentSimulationController;
use App\Http\Controllers\RentalController;
use Illuminate\Support\Facades\Route;

// ================= PUBLIC / CUSTOMER =================
Route::get('/', [CatalogController::class, 'index'])->name('catalog.index');
Route::get('/produk/{item:slug}', [CatalogController::class, 'show'])->name('catalog.show');
Route::get('/produk/{item:slug}/cek-stok', [CatalogController::class, 'checkStock'])->name('catalog.checkStock');

Route::get('/checkout/{item:slug}', [RentalController::class, 'checkoutForm'])->name('checkout.form');
Route::post('/checkout', [RentalController::class, 'store'])->name('checkout.store');
Route::get('/transaksi/{rental:invoice_number}', [RentalController::class, 'show'])->name('rental.show');
Route::get('/checkout/{rental}/hasil', [RentalController::class, 'success'])->name('checkout.success');

// Webhook Midtrans (harus public, tanpa CSRF & tanpa auth)
Route::post('/webhook/midtrans', [MidtransWebhookController::class, 'handle'])->name('midtrans.webhook');

// KHUSUS TESTING LOKAL — simulasi pembayaran tanpa akun Midtrans asli
Route::post('/simulasi-bayar/{rental}/paid', [PaymentSimulationController::class, 'markPaid'])->name('payment.simulation.paid');
Route::post('/simulasi-bayar/{rental}/failed', [PaymentSimulationController::class, 'markFailed'])->name('payment.simulation.failed');

// ================= AKUN CUSTOMER (opsional, bukan wajib untuk checkout) =================
Route::middleware('guest:customer')->group(function () {
    Route::get('/daftar', [CustomerAuthController::class, 'showRegister'])->name('customer.register');
    Route::post('/daftar', [CustomerAuthController::class, 'register'])->name('customer.register.store');
    Route::get('/masuk', [CustomerAuthController::class, 'showLogin'])->name('customer.login');
    Route::post('/masuk', [CustomerAuthController::class, 'login'])->name('customer.login.store');

    // Lupa password (hanya jalan kalau customer punya email terdaftar)
    Route::get('/lupa-password', [CustomerForgotPasswordController::class, 'showRequestForm'])->name('customer.password.request');
    Route::post('/lupa-password', [CustomerForgotPasswordController::class, 'sendResetLink'])->name('customer.password.email');
    Route::get('/reset-password/{token}', [CustomerForgotPasswordController::class, 'showResetForm'])->name('customer.password.reset');
    Route::post('/reset-password', [CustomerForgotPasswordController::class, 'resetPassword'])->name('customer.password.update');
});

Route::middleware('auth:customer')->group(function () {
    Route::post('/keluar', [CustomerAuthController::class, 'logout'])->name('customer.logout');
    Route::get('/riwayat-sewa', [CustomerDashboardController::class, 'index'])->name('customer.dashboard');

    // Edit profil (kontak & password)
    Route::get('/profil', [CustomerProfileController::class, 'edit'])->name('customer.profile.edit');
    Route::put('/profil', [CustomerProfileController::class, 'update'])->name('customer.profile.update');
    Route::put('/profil/password', [CustomerProfileController::class, 'updatePassword'])->name('customer.profile.password');
});

// Alias supaya Breeze bisa redirect ke sini setelah login sukses
Route::get('/dashboard', function () {
    return redirect()->route('admin.dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

// ================= ADMIN DASHBOARD / POS =================
Route::middleware(['auth', 'verified'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/dashboard', function () {
        return view('admin.dashboard');
    })->name('dashboard');

    // Manajemen Inventory
    Route::get('/inventory', [InventoryController::class, 'index'])->name('inventory.index');
    Route::get('/inventory/create', [InventoryController::class, 'create'])->name('inventory.create');
    Route::post('/inventory', [InventoryController::class, 'store'])->name('inventory.store');
    Route::get('/inventory/{item}/edit', [InventoryController::class, 'edit'])->name('inventory.edit');
    Route::put('/inventory/{item}', [InventoryController::class, 'update'])->name('inventory.update');
    Route::delete('/inventory/{item}', [InventoryController::class, 'destroy'])->name('inventory.destroy');

    // Manajemen Transaksi (POS)
    Route::get('/transactions', [TransactionController::class, 'index'])->name('transactions.index');
    Route::get('/transactions/{rental}', [TransactionController::class, 'show'])->name('transactions.show');

    // Modul Serah-Terima (jaminan fisik KTP/SIM/STNK)
    Route::get('/transactions/{rental}/handover', [TransactionController::class, 'handoverForm'])->name('transactions.handover.form');
    Route::post('/transactions/{rental}/handover', [TransactionController::class, 'handoverStore'])->name('transactions.handover.store');

    // Modul Pengembalian (checklist kondisi + denda otomatis)
    Route::get('/transactions/{rental}/return', [TransactionController::class, 'returnForm'])->name('transactions.return.form');
    Route::post('/transactions/{rental}/return', [TransactionController::class, 'returnStore'])->name('transactions.return.store');
});

require __DIR__.'/auth.php'; // disediakan otomatis oleh Laravel Breeze