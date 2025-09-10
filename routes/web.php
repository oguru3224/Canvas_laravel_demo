<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CanvasAuthController;

Route::get('/', function () {
    return view('welcome');
});


Route::post('/lti/login', [CanvasAuthController::class, 'redirectToCanvas']);
Route::post('/lti/launch', [CanvasAuthController::class, 'handleLtiCallback'])->name('canvas.login.redirect');

Route::get('/lti/login', function () {
    return view('auth.canvas-login');
})->name('canvas.login');




Route::get('/lti/launch', function () {
    return redirect()->route('canvas.login');
});


Route::get('/.well-known/jwks.json', function () {
    $publicKey = file_get_contents(storage_path('lti_public.key'));
    $keyDetails = openssl_pkey_get_details(openssl_pkey_get_public($publicKey));

    return response()->json([
        'keys' => [[
            'kty' => 'RSA',
            'kid' => env('LTI_TOOL_KID'),
            'use' => 'sig',
            'alg' => 'RS256',
            'n' => rtrim(strtr(base64_encode($keyDetails['rsa']['n']), '+/', '-_'), '='),
            'e' => rtrim(strtr(base64_encode($keyDetails['rsa']['e']), '+/', '-_'), '='),
        ]]
    ]);
});
