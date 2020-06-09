<?php

Route::prefix('ecpay')->group(function(){
    Route::post('notify', 'ChadPeng\ECPay\Http\Controllers\ECPayController@notifyUrl')
        ->name('ecpay.notify');
    Route::post('return', 'ChadPeng\ECPay\Http\Controllers\ECPayController@returnUrl')
        ->name('ecpay.return');
});