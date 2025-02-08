<?php

use App\Models\Internship;
use Maatwebsite\Excel\Row;
use App\Http\Middleware\IsAdmin;
use App\Http\Middleware\IsIntern;
use Illuminate\Support\Facades\Route;
use App\Http\Middleware\CanEditInterns;
use App\Http\Controllers\ProfileController;
use App\Http\Middleware\IsAlreadyRegistInternship;
use App\Http\Controllers\Admin\ManageUserController;
use App\Http\Controllers\Intern\AddReportWeekController;
use App\Http\Controllers\Intern\RegistInternController;
use App\Http\Controllers\Staff\ManageInternsController;

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
        Route::get('/magang-download-data-excel', [ManageInternsController::class, 'exportToExcel'])->name('export-excel');
        Route::get('/magang-download-data-pdf', [ManageInternsController::class, 'exportToPDF'])->name('export-pdf');
        Route::get('/magang-download-data-dompdf', [ManageInternsController::class, 'exportToPDFWithDOMPDF'])->name('export-dompdf');
        Route::get('magang/data/{Internship:id}', [ManageInternsController::class, 'exportDataToPDF'])->name('pdf-single-data');
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

            Route::resource('report-weeks', AddReportWeekController::class);
            Route::get('report-week/export-to-pdf', [AddReportWeekController::class, 'exportToPDF'])->name('report-to-pdf');
            Route::get('report-week/export-to-excel', [AddReportWeekController::class, 'exportToExcel'])->name('report-to-excel');
        });
    });
});

Route::get('/test', function(){
    return view('staff.manage-interns.pdf-single', ['data' => Internship::all()->first()]);
});

require __DIR__ . '/auth.php';
