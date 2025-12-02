<?php

use App\Livewire\Settings\Appearance;
use App\Livewire\Settings\Password;
use App\Livewire\Settings\Profile;
use App\Livewire\Users;
use App\Livewire\News;
use App\Livewire\Announcement;
use App\Livewire\PublicNews;
use App\Livewire\PublicAnnouncement;
use Illuminate\Support\Facades\Route;
use Laravel\Fortify\Features;

Route::get('/', function () {
    return view('welcome');
})->name('home');

// Public routes (no authentication required)
Route::get('/news-list', PublicNews::class)->name('public.news');
Route::get('/announcements-list', PublicAnnouncement::class)->name('public.announcements');

Route::view('dashboard', 'dashboard')
    ->middleware(['auth', 'verified'])
    ->name('dashboard');

Route::middleware(['auth'])->group(function () {
    Route::get('users', Users::class)->name('users.index');
    Route::get('news', News::class)->name('news.index');
    Route::get('announcements', Announcement::class)->name('announcements.index');

    Route::redirect('settings', 'settings/profile');

    Route::get('settings/profile', Profile::class)->name('profile.edit');
    Route::get('settings/password', Password::class)->name('user-password.edit');
    Route::get('settings/appearance', Appearance::class)->name('appearance.edit');
});
