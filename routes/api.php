<?php

use Illuminate\Support\Facades\Route;

Route::prefix('v1')->middleware('operation')->group(function () {

});
