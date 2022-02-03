<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateInformationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('informations', function (Blueprint $table) {
            $table->id();
            $table->integer("perpage")->default(10);
            $table->integer("currentPage")->default(1);
            $table->string("first_category")->nullable();
            $table->string("second_category")->nullable();
            $table->string("third_category")->nullable();
            $table->string("first_search")->nullable();
            $table->string("second_search")->nullable();
            $table->unsignedInteger('user_id')->nullable();
            $table->string('admin_pass');
            $table->string('link_name')->default('purchase');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('informations');
    }
}
