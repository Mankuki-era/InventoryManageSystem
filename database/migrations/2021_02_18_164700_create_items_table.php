<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateItemsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('items', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->text('url')->nullable();
            $table->string('model')->nullable();
            $table->text('comment')->nullable();
            $table->string('img_path')->default("/image/no_image.png");
            $table->integer('price')->nullable();
            $table->string('unit')->default("");
            $table->string('require_count')->default("");
            $table->integer('stocks');
            $table->string('first_category');
            $table->string('second_category');
            $table->string('third_category');
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
        Schema::dropIfExists('items');
    }
}
