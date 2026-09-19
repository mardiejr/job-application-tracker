<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\JobApplicationController;
use App\Http\Controllers\NoteController;
use App\Http\Controllers\ResumeController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\CompanyController;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', [DashboardController::class, 'index'])
    ->middleware(['auth', 'verified'])
    ->name('dashboard');

Route::middleware(['auth', 'verified'])->group(function () {
    Route::resource('applications', JobApplicationController::class);
    Route::post('/applications/{application}/notes', [NoteController::class, 'store'])->name('notes.store');
    Route::delete('/notes/{note}', [NoteController::class, 'destroy'])->name('notes.destroy');
    Route::get('/resumes', [ResumeController::class, 'index'])->name('resumes.index');
    Route::post('/resumes', [ResumeController::class, 'store'])->name('resumes.store');
    Route::delete('/resumes/{resume}', [ResumeController::class, 'destroy'])->name('resumes.destroy');
    Route::post('/notifications/{id}/read', function ($id) {
    $notification = auth()->user()->notifications()->findOrFail($id);
    $notification->markAsRead();

    return redirect()->route('applications.show', $notification->data['application_id']);
    })->name('notifications.read');

    Route::resource('companies', CompanyController::class)->except(['show']);
});

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
