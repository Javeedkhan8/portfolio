<?php

use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\EducationController;
use App\Http\Controllers\Admin\ExperienceController;
use App\Http\Controllers\Admin\ProfileController;
use App\Http\Controllers\Admin\ProjectController;
use App\Http\Controllers\Admin\SkillController;
use App\Http\Controllers\EmailSenderController;
use App\Http\Controllers\PortfolioController;
use App\Http\Controllers\ProfileController as AccountProfileController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| assigned to the "web" middleware group. Make something great!
|
*/

/*
|--------------------------------------------------------------------------
| Public Portfolio
|--------------------------------------------------------------------------
*/
Route::get('/', [PortfolioController::class, 'index'])->name('portfolio.index');
Route::get('/portfolio', [PortfolioController::class, 'index'])->name('portfolio');

Route::get('/employee', function () {
    return view('pages.employee.index');
});

Route::get('/email-sender', [EmailSenderController::class, 'index'])
    ->middleware(['auth', 'verified'])
    ->name('email-sender');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [AccountProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [AccountProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [AccountProfileController::class, 'destroy'])->name('profile.destroy');

    Route::get('/send', [EmailSenderController::class, 'index'])->name('email-sender.index');
    Route::post('/send', [EmailSenderController::class, 'send'])->name('email-sender.send');
});

/*
|--------------------------------------------------------------------------
| Portfolio Control Panel (/admin)
|--------------------------------------------------------------------------
*/
Route::prefix('admin')
    ->name('admin.')
    ->middleware(['auth', 'verified', 'admin'])
    ->group(function () {
        Route::get('/', [DashboardController::class, 'index'])->name('dashboard');

        Route::get('profile', [ProfileController::class, 'edit'])->name('profile.edit');
        Route::put('profile', [ProfileController::class, 'update'])->name('profile.update');

        Route::get('projects', [ProjectController::class, 'index'])->name('projects.index');
        Route::get('projects/create', [ProjectController::class, 'create'])->name('projects.create');
        Route::post('projects', [ProjectController::class, 'store'])->name('projects.store');
        Route::get('projects/{project}/edit', [ProjectController::class, 'edit'])->name('projects.edit');
        Route::put('projects/{project}', [ProjectController::class, 'update'])->name('projects.update');
        Route::delete('projects/{project}', [ProjectController::class, 'destroy'])->name('projects.destroy');

        Route::get('skills', [SkillController::class, 'index'])->name('skills.index');
        Route::get('skills/create', [SkillController::class, 'create'])->name('skills.create');
        Route::post('skills', [SkillController::class, 'store'])->name('skills.store');
        Route::get('skills/{skill}/edit', [SkillController::class, 'edit'])->name('skills.edit');
        Route::put('skills/{skill}', [SkillController::class, 'update'])->name('skills.update');
        Route::delete('skills/{skill}', [SkillController::class, 'destroy'])->name('skills.destroy');

        Route::get('experiences', [ExperienceController::class, 'index'])->name('experiences.index');
        Route::get('experiences/create', [ExperienceController::class, 'create'])->name('experiences.create');
        Route::post('experiences', [ExperienceController::class, 'store'])->name('experiences.store');
        Route::get('experiences/{experience}/edit', [ExperienceController::class, 'edit'])->name('experiences.edit');
        Route::put('experiences/{experience}', [ExperienceController::class, 'update'])->name('experiences.update');
        Route::delete('experiences/{experience}', [ExperienceController::class, 'destroy'])->name('experiences.destroy');

        Route::get('educations', [EducationController::class, 'index'])->name('educations.index');
        Route::get('educations/create', [EducationController::class, 'create'])->name('educations.create');
        Route::post('educations', [EducationController::class, 'store'])->name('educations.store');
        Route::get('educations/{education}/edit', [EducationController::class, 'edit'])->name('educations.edit');
        Route::put('educations/{education}', [EducationController::class, 'update'])->name('educations.update');
        Route::delete('educations/{education}', [EducationController::class, 'destroy'])->name('educations.destroy');
    });

require __DIR__.'/auth.php';
