<?php

use App\Http\Controllers\Admin\Menu\MenuAdminController;
use Illuminate\Support\Facades\Route;

Route::prefix(config("adminer.route.admin"))->middleware(config("adminer.middleware.admin"))->group(function () {

    /**
     * Menus.
     */
    Route::apiResource("menus", MenuAdminController::class)->parameters([ "menus" => "menu", ]);
    Route::match([ "put", "patch", ], "menus/activate/{menu}", [ MenuAdminController::class, "activate", ]);
    Route::match([ "put", "patch", ], "menus/deactivate/{menu}", [ MenuAdminController::class, "deactivate", ]);
    Route::post("menus-import", [ MenuAdminController::class, "import", ]);
    Route::get("menus-export", [ MenuAdminController::class, "export", ]);
});
