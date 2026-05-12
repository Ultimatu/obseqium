<?php

use App\Http\Controllers\AboutController;
use App\Http\Controllers\BlogController;
use App\Http\Controllers\FormationController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\QuotePdfController;
use App\Http\Controllers\ReferenceController;
use App\Http\Controllers\ServiceController;
use App\Http\Controllers\SitemapController;
use App\Livewire\AppointmentBooking;
use App\Livewire\ContactPage;
use App\Livewire\FormationCalendar;
use App\Livewire\LegalPage;
use App\Livewire\PrivacyPage;
use App\Livewire\QuotePortal;
use App\Livewire\QuoteRequest;
use Illuminate\Support\Facades\Route;

// Home
Route::get('/', HomeController::class)->name('home');

// Services
Route::get('/services', [ServiceController::class, 'index'])->name('services.index');
Route::get('/services/{slug}', [ServiceController::class, 'show'])->name('services.show');

// Formations
Route::get('/formations', [FormationController::class, 'index'])->name('formations.index');
Route::get('/formations/calendrier', FormationCalendar::class)->name('formations.calendar');
Route::get('/formations/{slug}', [FormationController::class, 'show'])->name('formations.show');

// À propos
Route::get('/a-propos', AboutController::class)->name('about');

// Références
Route::get('/references', ReferenceController::class)->name('references');

// Blog
Route::get('/blog', [BlogController::class, 'index'])->name('blog.index');
Route::get('/blog/{slug}', [BlogController::class, 'show'])->name('blog.show');
Route::get('/blog/categorie/{slug}', [BlogController::class, 'category'])->name('blog.category');

// Contact
Route::get('/contact', ContactPage::class)->name('contact');

// Devis
Route::get('/devis', QuoteRequest::class)->name('quotes.request');
Route::get('/devis/portail/{token}', QuotePortal::class)->name('quotes.portal');
Route::get('/devis/portail/{token}/pdf', [QuotePdfController::class, 'download'])->name('quotes.portal.pdf');

// Rendez-vous
Route::get('/rendez-vous', AppointmentBooking::class)->name('appointments.book');

// Mentions légales & confidentialité
Route::get('/mentions-legales', LegalPage::class)->name('legal');
Route::get('/confidentialite', PrivacyPage::class)->name('privacy');

// Sitemap
Route::get('/sitemap.xml', SitemapController::class)->name('sitemap');
