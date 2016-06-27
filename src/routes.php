<?php
Route::group(
    ['prefix' => 'backend/setting/{zone}', 'as' => 'backend.setting.', 'namespace' => 'Minhbang\Setting', 'middleware' => config('setting.middleware')],
    function () {
        Route::get('/', ['as' => 'index', 'uses' => 'Controller@index']);
        Route::get('{section}', ['as' => 'show', 'uses' => 'Controller@show']);
        Route::get('{section}/edit', ['as' => 'edit', 'uses' => 'Controller@edit']);
        Route::post('{section}', ['as' => 'update', 'uses' => 'Controller@update']);
        Route::post('restore/default', ['as' => 'restore', 'uses' => 'Controller@restore']);
    }
);
