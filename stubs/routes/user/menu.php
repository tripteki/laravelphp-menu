<?php

use App\Http\Controllers\Menu\MenuController;
use Illuminate\Support\Facades\Route;

Route::prefix(config("adminer.route.user"))->middleware(config("adminer.middleware.user"))->group(function () {

    /**
     * Menus.
     */
    Route::apiResource("menus.routes.ids", MenuController::class)->only([ "index", "show", ])->parameters([ "menus" => "platform", ]);
});
