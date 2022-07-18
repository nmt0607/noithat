<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSiteConfigsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('site_configs', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('key', 255)->nullable()->comment('khóa');
            $table->string('value',1000)->nullable()->comment('gia tri');
            $table->string('value_en',1000)->nullable()->comment('gia tri');
            $table->integer('order_number')->nullable()->comment('sắp xếp thứ tự');
            $table->tinyInteger('type')->nullable()->comment('Kiểu');
            $table->string('image', 1000)->nullable()->comment('duong dan anh');
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
        Schema::dropIfExists('site_configs');
    }
}
