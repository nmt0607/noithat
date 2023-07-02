<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProductsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('products', function (Blueprint $table) {
            $table->id();
            $table->string('name')->nullable();
            $table->string('price')->nullable();
            $table->string('code')->nullable();
            $table->string('material')->nullable();
            $table->string('guarantee')->nullable();
            $table->string('description')->nullable();
            $table->string('status')->nullable();
            $table->tinyInteger('type')->nullable();
            $table->integer('pd_type_lv1')->nullable();
            $table->integer('pd_type_lv2')->nullable();
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
        Schema::dropIfExists('products');
    }
}
