<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTempitemsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tempitems', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('url');
            $table->string('model');
            $table->text('comment')->nullable();
            $table->string('img_path')->default("/image/no_image.png");
            $table->integer('price');
            $table->integer('stocks');
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
        Schema::dropIfExists('tempitems');
    }
}
