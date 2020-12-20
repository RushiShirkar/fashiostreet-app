<?php
Route::prefix('api/auth')->group(function(){

    Route::post(
        'login',
        'fashiostreet\api_auth\Controllers\LoginController@login'
    );

    Route::post(
        'register',
        'fashiostreet\api_auth\Controllers\RegisterController@Register'
    );

    Route::post(
        'completeRegister',
        'fashiostreet\api_auth\Controllers\RegisterController@CompleteRegistration'
    );

    Route::post(
        'forgetpassword',
        'fashiostreet\api_auth\Controllers\ForgetPasswordController@forgetpassword'
    );

    Route::post(
        'completeForgetpassword',
        'fashiostreet\api_auth\Controllers\ForgetPasswordController@CompletedForgetPassword'
    );
});
