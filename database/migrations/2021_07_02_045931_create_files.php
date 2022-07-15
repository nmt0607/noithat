<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateFiles extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('files', function(Blueprint $table)
        {
            $table->bigIncrements('id')->comment('luu tru dia chi file');
            $table->string('url', 255)->nullable()->comment('luu tru dia chi file');
            $table->string('file_name', 255)->nullable()->comment('Ten file');
            $table->string('model_name')->nullable()->comment();
            $table->bigInteger('model_id')->nullable()->comment('map voi id bang');
            $table->string('size_file', 255)->nullable();
            $table->tinyInteger('type')->nullable()->comment('1: working, 2..');
            $table->tinyInteger('status')->nullable()->comment('0; luu nhap, 1 da luu');
            $table->bigInteger('admin_id')->nullable()->comment('Nguoi tao');
            $table->string('note',1000)->nullable()->comment('ghi chu file');
            $table->string('note_en')->nullable();
            $table->softDeletes();
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
        Schema::dropIfExists('files');
    }
}
