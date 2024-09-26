<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::get('/', function () {
    return "Hello API";
});



//Store front API
Route::post('save-details', [\App\Http\Controllers\DunBuilderController::class, 'BuilderDetailSave']);
Route::get('get-details', [\App\Http\Controllers\DunBuilderController::class, 'BuilderDetailsRetrieve']);


Route::get('test-mail', [\App\Http\Controllers\DunBuilderController::class, 'testmail']);

Route::group(['middleware' => ['shopify.auth']], function () {
    //index page
    Route::get('builder-details', [\App\Http\Controllers\DunBuilderController::class, 'index']);

    //Mail Smtp
    Route::get('mail-smtp-setting',[\App\Http\Controllers\DunBuilderController::class,'MailSmtp']);
    Route::post('mail-smtp-setting-save',[\App\Http\Controllers\DunBuilderController::class,'MailSmtpSettingSave']);
});


Route::post('/webhooks/app-uninstall', function (Request $request) {
    try {
        $shop=$request->header('x-shopify-shop-domain');
        $shop=\App\Models\Session::where('shop',$shop)->first();

        $shop->forceDelete();

    } catch (\Exception $e) {
    }
});
