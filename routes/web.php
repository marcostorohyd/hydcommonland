<?php

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
Route::get('login', 'Auth\LoginController@showLoginForm')->name('login');
Route::post('login', 'Auth\LoginController@login');
Route::post('logout', 'Auth\LoginController@logout')->name('logout');
Route::get('approval', 'Auth\LoginController@showApproval')->name('login.approval');

// Registration Routes...
Route::get('register', 'Auth\RegisterController@showRegistrationForm')->name('register');
Route::post('register', 'Auth\RegisterController@register');
Route::get('thanks', 'Auth\RegisterController@showThanks')->name('register.thanks');

// Password Reset Routes...
Route::get('password/reset', 'Auth\ForgotPasswordController@showLinkRequestForm')->name('password.request');
Route::post('password/email', 'Auth\ForgotPasswordController@sendResetLinkEmail')->name('password.email');
Route::get('password/reset/{token}', 'Auth\ResetPasswordController@showResetForm')->name('password.reset');
Route::post('password/reset', 'Auth\ResetPasswordController@reset')->name('password.update');

// Email Verification Routes
// Route::get('email/verify', 'Auth\VerificationController@show')->name('verification.notice');
// Route::get('email/verify/{id}', 'Auth\VerificationController@verify')->name('verification.verify');
// Route::get('email/resend', 'Auth\VerificationController@resend')->name('verification.resend');

Route::get('/', 'HomeController@index')->name('home');

Route::resource('directory', 'DirectoryController')->only('show');
Route::post('directory/list', 'DirectoryController@index')->name('directory.list');
Route::post('directory/map', 'DirectoryController@map')->name('directory.map');

Route::get('about', 'HomeController@about')->name('about');
Route::get('contact', 'HomeController@contact')->name('contact');

Route::get('legal-notice', 'PageController@legalNotice')->name('legal_notice');
Route::get('cookies-policy', 'PageController@cookiesPolicy')->name('cookies_policy');
Route::get('privacy-policy', 'PageController@privacyPolicy')->name('privacy_policy');
Route::get('terms', 'PageController@terms')->name('terms');

// Event
Route::resource('event', 'EventController')->only(['index', 'show']);
Route::post('event/datatable', 'EventController@datatable')->name('event.datatable');

// News
Route::resource('news', 'NewsController')->only(['index', 'show']);
Route::post('news/list', 'NewsController@list')->name('news.list');

// Demo case study
Route::resource('demo', 'DemoCaseStudyController')->only(['index', 'show']);
Route::post('demo/list', 'DemoCaseStudyController@list')->name('demo.list');

// Media library
Route::resource('media', 'MediaLibraryController')->only(['index', 'show'])->parameters([
    'media' => 'media',
]);
Route::post('media/list', 'MediaLibraryController@list')->name('media.list');
Route::get('media/download/{media}', 'MediaLibraryController@download')->name('media.download');

// Language
Route::get('lang/{lang}', 'LanguageController@switchLang')->name('lang.switch');

Route::middleware('auth')->prefix('backend')->namespace('Backend')->name('backend.')->group(function () {

    // Dashboard
    Route::get('/', 'DashboardController@index')->name('dashboard');

    // Account
    Route::get('account', 'AccountController@show')->name('account.show');
    Route::get('account/edit-directory', 'AccountController@editDirectory')->name('account.edit_directory');
    Route::match(['put', 'patch'], 'account', 'AccountController@updateDirectory')->name('account.update_directory');
    Route::match(['put', 'patch'], 'account/update-communication', 'AccountController@updateCommunication')
        ->name('account.update_communication');
    Route::match(['put', 'patch'], 'account/update-user', 'AccountController@updateUser')->name('account.update_user');
    Route::delete('account', 'AccountController@requestDestroy')->name('account.request_destroy');
    Route::get('account/destroy/{user}', 'AccountController@destroy')->name('account.destroy')->middleware('signed');

    // Directory
    Route::get('directory/{directory}/delete', 'DirectoryController@destroy')->name('directory.delete');
    Route::resource('directory', 'DirectoryController');
    Route::get('directory/{directory}/approve', 'DirectoryController@approve')->name('directory.approve');
    Route::get('directory/{directory}/refuse', 'DirectoryController@refuse')->name('directory.refuse');
    Route::post('directory/datatable', 'DirectoryController@datatable')->name('directory.datatable');
    Route::match(['GET', 'POST'], 'directory/search', 'DirectoryController@search')->name('directory.search');

    // Directory change
    Route::resource('directory-change', 'DirectoryChangeController');
    Route::get('directory-change/{directory_change}/approve', 'DirectoryChangeController@approve')->name('directory-change.approve');
    Route::get('directory-change/{directory_change}/refuse', 'DirectoryChangeController@refuse')->name('directory-change.refuse');

    // Event
    Route::resource('event', 'EventController');
    Route::get('event/{event}/approve', 'EventController@approve')->name('event.approve');
    Route::get('event/{event}/refuse', 'EventController@refuse')->name('event.refuse');
    Route::post('event/datatable', 'EventController@datatable')->name('event.datatable');

    // News
    Route::resource('news', 'NewsController');
    Route::get('news/{news}/approve', 'NewsController@approve')->name('news.approve');
    Route::get('news/{news}/refuse', 'NewsController@refuse')->name('news.refuse');
    Route::post('news/datatable', 'NewsController@datatable')->name('news.datatable');

    // Demo case study
    Route::resource('demo', 'DemoCaseStudyController');
    Route::get('demo/{demo}/approve', 'DemoCaseStudyController@approve')->name('demo.approve');
    Route::get('demo/{demo}/refuse', 'DemoCaseStudyController@refuse')->name('demo.refuse');
    Route::post('demo/datatable', 'DemoCaseStudyController@datatable')->name('demo.datatable');

    // Media library
    Route::resource('media', 'MediaLibraryController')->parameters([
        'media' => 'media',
    ]);
    Route::get('media/{media}/approve', 'MediaLibraryController@approve')->name('media.approve');
    Route::get('media/{media}/refuse', 'MediaLibraryController@refuse')->name('media.refuse');
    Route::post('media/datatable', 'MediaLibraryController@datatable')->name('media.datatable');

    Route::group(['middleware' => ['isAdmin']], function () {
        // Country
        Route::resource('country', 'CountryController')->except('show');
        Route::post('country/datatable', 'CountryController@datatable')->name('country.datatable');
        Route::match(['GET', 'POST'], 'country/search', 'CountryController@search')->name('country.search');
        Route::get('country/{country}/unassign-contact', 'CountryController@unassignContact')
            ->name('country.unassign_contact');

        // About
        Route::get('about', 'AboutController@edit')->name('about.edit');
        Route::put('about', 'AboutController@update')->name('about.update');

        // Contact
        Route::get('contact', 'ContactController@edit')->name('contact.edit');
        Route::put('contact', 'ContactController@update')->name('contact.update');
    });
});

// Tool
Route::post('tool/image-upload', 'ToolController@imageUpload')->name('tool.image-upload');
Route::post('tool/file-upload', 'ToolController@fileUpload')->name('tool.file_upload');
Route::post('tool/map-search', 'ToolController@mapSearch')->name('tool.map_search');

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
