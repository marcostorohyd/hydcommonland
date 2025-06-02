<?php

use App\Http\Controllers\Auth;
use App\Http\Controllers\Backend;
use App\Http\Controllers\backend\CountryController;
use App\Http\Controllers\backend\DirectoryChangeController;
use App\Http\Controllers\DemoCaseStudyController;
use App\Http\Controllers\DirectoryController;
use App\Http\Controllers\EventController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\LanguageController;
use App\Http\Controllers\MediaLibraryController;
use App\Http\Controllers\NewsController;
use App\Http\Controllers\PageController;
use App\Http\Controllers\ToolController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

// Auth::routes();

// Authentication Routes...
Route::get('login', [Auth\LoginController::class, 'showLoginForm'])->name('login');
Route::post('login', [Auth\LoginController::class, 'login']);
Route::post('logout', [Auth\LoginController::class, 'logout'])->name('logout');
Route::get('approval', [Auth\LoginController::class, 'showApproval'])->name('login.approval');

// Registration Routes...
Route::get('register', [Auth\RegisterController::class, 'showRegistrationForm'])->name('register');
Route::post('register', [Auth\RegisterController::class, 'register']);
Route::get('thanks', [Auth\RegisterController::class, 'showThanks'])->name('register.thanks');

// Password Reset Routes...
Route::get('password/reset', [Auth\ForgotPasswordController::class, 'showLinkRequestForm'])->name('password.request');
Route::post('password/email', [Auth\ForgotPasswordController::class, 'sendResetLinkEmail'])->name('password.email');
Route::get('password/reset/{token}', [Auth\ResetPasswordController::class, 'showResetForm'])->name('password.reset');
Route::post('password/reset', [Auth\ResetPasswordController::class, 'reset'])->name('password.update');

// Email Verification Routes
// Route::get('email/verify', 'Auth\VerificationController@show')->name('verification.notice');
// Route::get('email/verify/{id}', 'Auth\VerificationController@verify')->name('verification.verify');
// Route::get('email/resend', 'Auth\VerificationController@resend')->name('verification.resend');

Route::get('/', [HomeController::class, 'index'])->name('home');

Route::resource('directory', DirectoryController::class)->only('show');
Route::post('directory/list', [DirectoryController::class, 'index'])->name('directory.list');
Route::post('directory/map', [DirectoryController::class, 'map'])->name('directory.map');

Route::get('about', [HomeController::class, 'about'])->name('about');
Route::get('contact', [HomeController::class, 'contact'])->name('contact');

Route::get('legal-notice', [PageController::class, 'legalNotice'])->name('legal_notice');
Route::get('cookies-policy', [PageController::class, 'cookiesPolicy'])->name('cookies_policy');
Route::get('privacy-policy', [PageController::class, 'privacyPolicy'])->name('privacy_policy');
Route::get('terms', [PageController::class, 'terms'])->name('terms');

// Event
Route::resource('event', EventController::class)->only(['index', 'show']);
Route::post('event/datatable', [EventController::class, 'datatable'])->name('event.datatable');

// News
Route::resource('news', NewsController::class)->only(['index', 'show']);
Route::post('news/list', [NewsController::class, 'list'])->name('news.list');

// Demo case study
Route::resource('demo', DemoCaseStudyController::class)->only(['index', 'show']);
Route::post('demo/list', [DemoCaseStudyController::class, 'list'])->name('demo.list');

// Media library
Route::resource('media', MediaLibraryController::class)->only(['index', 'show'])->parameters([
    'media' => 'media',
]);
Route::post('media/list', [MediaLibraryController::class, 'list'])->name('media.list');
Route::get('media/download/{media}', [MediaLibraryController::class, 'download'])->name('media.download');

// Language
Route::get('lang/{lang}', [LanguageController::class, 'switchLang'])->name('lang.switch');

Route::middleware('auth')->prefix('backend')->name('backend.')->group(function () {

    // Dashboard
    Route::get('/', [Backend\DashboardController::class, 'index'])->name('dashboard');

    // Account
    Route::get('account', [Backend\AccountController::class, 'show'])->name('account.show');
    Route::get('account/edit-directory', [Backend\AccountController::class, 'editDirectory'])->name('account.edit_directory');
    Route::match(['put', 'patch'], 'account', [Backend\AccountController::class, 'updateDirectory'])->name('account.update_directory');
    Route::match(['put', 'patch'], 'account/update-communication', [Backend\AccountController::class, 'updateCommunication'])
        ->name('account.update_communication');
    Route::match(['put', 'patch'], 'account/update-user', [Backend\AccountController::class, 'updateUser'])->name('account.update_user');
    Route::delete('account', [Backend\AccountController::class, 'requestDestroy'])->name('account.request_destroy');
    Route::get('account/destroy/{user}', [Backend\AccountController::class, 'destroy'])->name('account.destroy')->middleware('signed');

    // Directory
    Route::get('directory/{directory}/delete', [Backend\DirectoryController::class, 'destroy'])->name('directory.delete');
    Route::resource('directory', DirectoryController::class);
    Route::get('directory/{directory}/approve', [Backend\DirectoryController::class, 'approve'])->name('directory.approve');
    Route::get('directory/{directory}/refuse', [Backend\DirectoryController::class, 'refuse'])->name('directory.refuse');
    Route::post('directory/datatable', [Backend\DirectoryController::class, 'datatable'])->name('directory.datatable');
    Route::match(['GET', 'POST'], 'directory/search', [Backend\DirectoryController::class, 'search'])->name('directory.search');

    // Directory change
    Route::resource('directory-change', DirectoryChangeController::class);
    Route::get('directory-change/{directory_change}/approve', [Backend\DirectoryChangeController::class, 'approve'])->name('directory-change.approve');
    Route::get('directory-change/{directory_change}/refuse', [Backend\DirectoryChangeController::class, 'refuse'])->name('directory-change.refuse');

    // Event
    Route::resource('event', EventController::class);
    Route::get('event/{event}/approve', [Backend\EventController::class, 'approve'])->name('event.approve');
    Route::get('event/{event}/refuse', [Backend\EventController::class, 'refuse'])->name('event.refuse');
    Route::post('event/datatable', [Backend\EventController::class, 'datatable'])->name('event.datatable');

    // News
    Route::resource('news', NewsController::class);
    Route::get('news/{news}/approve', [Backend\NewsController::class, 'approve'])->name('news.approve');
    Route::get('news/{news}/refuse', [Backend\NewsController::class, 'refuse'])->name('news.refuse');
    Route::post('news/datatable', [Backend\NewsController::class, 'datatable'])->name('news.datatable');

    // Demo case study
    Route::resource('demo', DemoCaseStudyController::class);
    Route::get('demo/{demo}/approve', [Backend\DemoCaseStudyController::class, 'approve'])->name('demo.approve');
    Route::get('demo/{demo}/refuse', [Backend\DemoCaseStudyController::class, 'refuse'])->name('demo.refuse');
    Route::post('demo/datatable', [Backend\DemoCaseStudyController::class, 'datatable'])->name('demo.datatable');

    // Media library
    Route::resource('media', MediaLibraryController::class)->parameters([
        'media' => 'media',
    ]);
    Route::get('media/{media}/approve', [Backend\MediaLibraryController::class, 'approve'])->name('media.approve');
    Route::get('media/{media}/refuse', [Backend\MediaLibraryController::class, 'refuse'])->name('media.refuse');
    Route::post('media/datatable', [Backend\MediaLibraryController::class, 'datatable'])->name('media.datatable');

    Route::middleware('isAdmin')->group(function () {
        // Country
        Route::resource('country', CountryController::class)->except('show');
        Route::post('country/datatable', [Backend\CountryController::class, 'datatable'])->name('country.datatable');
        Route::match(['GET', 'POST'], 'country/search', [Backend\CountryController::class, 'search'])->name('country.search');
        Route::get('country/{country}/unassign-contact', [Backend\CountryController::class, 'unassignContact'])
            ->name('country.unassign_contact');

        // About
        Route::get('about', [Backend\AboutController::class, 'edit'])->name('about.edit');
        Route::put('about', [Backend\AboutController::class, 'update'])->name('about.update');

        // Contact
        Route::get('contact', [Backend\ContactController::class, 'edit'])->name('contact.edit');
        Route::put('contact', [Backend\ContactController::class, 'update'])->name('contact.update');
    });
});

// Tool
Route::post('tool/image-upload', [ToolController::class, 'imageUpload'])->name('tool.image-upload');
Route::post('tool/file-upload', [ToolController::class, 'fileUpload'])->name('tool.file_upload');
Route::post('tool/map-search', [ToolController::class, 'mapSearch'])->name('tool.map_search');

// Route::get('generate-locations', function () {
//     $directories = \App\Directory::withoutGlobalScopes()->get();
//     $faker = \Faker\Factory::create();
//     foreach ($directories as $directory) {
//         $directory->latitude = $faker->latitude(35, 70);
//         $directory->longitude = $faker->longitude(-30, 40);
//         $directory->save();
//     }
// });

// Route::get('queue', function () {
//     $user = \App\User::where('email', 'example@colectivoverbena.info')->first();
//     \Illuminate\Support\Facades\Mail::to($user->email)->send(new \App\Mail\AccountRequestDeleteMail($user));
// });
