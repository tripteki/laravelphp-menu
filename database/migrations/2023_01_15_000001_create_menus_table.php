<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMenusTable extends Migration
{
    /**
     * @return void
     */
    public function up()
    {
        Schema::create("menus", function (Blueprint $table) {

            $table->uuid("id");

            $table->string("platform");
            $table->string("route");
            $table->integer("nth")->default(0);
            $table->string("title");
            $table->json("metadata")->nullable(true);
            $table->text("description")->nullable(true);
            $table->timestamps();
            $table->softDeletes();

            $table->primary("id");
            $table->unique([ "platform", "route", "title", ]);
        });
    }

    /**
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists("menus");
    }
};
