<?php

use Illuminate\Support\Facades\Route;
use Spatie\Honeypot\ProtectAgainstSpam;
use App\Http\Controllers\ProfileController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', [App\Http\Controllers\HomeController::class, 'index'])->name('fehome');
Route::post('/submit-form/{form}', [App\Http\Controllers\HomeController::class, 'formSubmit'])->middleware(ProtectAgainstSpam::class)->name('form.submit');
Route::middleware('doNotCacheResponse')->get('/b', [App\Http\Controllers\SearchController::class, 'blog'])->name('search.blog');
Route::middleware('doNotCacheResponse')->get('/s', [App\Http\Controllers\SearchController::class, 'content'])->name('search.content');
Route::middleware('doNotCacheResponse')->get('sitemap.xml', [App\Http\Controllers\SitemapController::class, 'index'])->name('sitemap');
Route::middleware('doNotCacheResponse')->get('adclick/{commercial_ad}', [App\Http\Controllers\CommercialAdController::class, 'click'])->name('adclick');

foreach (config('languages.active') as $key => $lang) {
    if ($lang != config('languages.default')) {
        Route::get($lang, [App\Http\Controllers\HomeController::class, 'indexLang'])->name('fehome.lang');
    }
}

Route::middleware('doNotCacheResponse')->get('robots.txt', function() {


    $data = [
        'sitemaps' => [],
        'disallows' => [],
    ];

    if (app()->environment() == 'production') {
        
        $data = [
            'sitemaps' => [route('sitemap')],
            'disallows' => config('robots.disallows'),
        ];

    } else {
        $data = [
            'sitemaps' => [route('sitemap')],
            'disallows' => [
                '*'
            ],
        ];
    }

    return response(view('robots',[
        'data' => $data
    ]), 200, [
        'Content-Type' => 'text/plain'
    ]);
});

//Country, states, city
Route::get('/countries', App\Http\Controllers\CountryController::class)->name('countries');
Route::get('/countries/states/{country_id}', [App\Http\Controllers\CountryController::class, 'states'])->name('countries.states');
Route::get('/states/cities/{state_id}', [App\Http\Controllers\StateController::class, 'cities'])->name('states.cities');

//newsletter
Route::resource('newsletter-members', App\Http\Controllers\NewsletterMemberController::class);

//Ajax
Route::prefix('fetch')->group(function () {

    Route::get('offcanvas-content/{uuid}/{language}', [App\Http\Controllers\HomeController::class, 'fetchOffcanvasContent'])->name('fetch.offcanvas.content');

});

//kalan hersey tek yerde.
Route::fallback([App\Http\Controllers\HomeController::class, 'handleFe']);