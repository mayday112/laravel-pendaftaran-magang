<?php

use App\Http\Controllers\Admin\ManageUserController;
use App\Http\Controllers\Intern\RegistInternController;
use App\Http\Controllers\InternshipController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\Staff\ManageInternsController;
use App\Http\Middleware\CanEditInterns;
use App\Http\Middleware\IsAdmin;
use App\Http\Middleware\IsAlreadyRegistInternship;
use App\Http\Middleware\IsIntern;
use App\Http\Middleware\IsStaff;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Storage;

Route::get('/', function () {
    // return view('welcome');
    return redirect()->route('login');
});

Route::get('/dashboard', function () {
    return view('dashboard', ['type_menu' => 'dashboard']);
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    // admin
    Route::resource('manage-user', ManageUserController::class)->middleware([IsAdmin::class]);
    Route::post('/reset_password/{id}', [ManageUserController::class, 'resetPassword'])->name('reset-password')->middleware([IsAdmin::class]);
    // staff
    Route::middleware([CanEditInterns::class])->group(function () {
        Route::get('/magang', [ManageInternsController::class, 'index'])->name('manage-magang');
        Route::get('/magang/{Internship:id}', [ManageInternsController::class, 'edit'])->name('edit-magang');
        Route::put('/magang/{Internship:id}', [ManageInternsController::class, 'update'])->name('update-magang');
        Route::delete('/magang/{Internship:id}', [ManageInternsController::class, 'destroy'])->name('delete-magang');
        // Route::get('download-surat-pengantar/{namaFile}', [ManageInternsController::class, 'download'])->name('download-surat-pengantar');
    });
    //interns
    Route::middleware([IsIntern::class])->group(function () {

        Route::get('intern/daftar', [RegistInternController::class, 'create'])->name('intern-create-data');
        Route::post('intern/daftar', [RegistInternController::class, 'store'])->name('intern-store-data');

        Route::middleware([IsAlreadyRegistInternship::class])->group(function () {
            Route::get('/intern', [RegistInternController::class, 'index'])->name('intern');

            Route::get('intern/edit', [RegistInternController::class, 'edit'])->name('intern-edit-data');
            Route::post('intern/edit', [RegistInternController::class, 'update'])->name('intern-update-data');

            Route::get('intern/download-nilai/{Internship:nilai_magang}', [RegistInternController::class, 'download'])->name('intern-download-nilai');
        });
    });
});

require __DIR__ . '/auth.php';
