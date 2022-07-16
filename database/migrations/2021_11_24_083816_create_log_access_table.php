<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateLogAccessTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('log_access', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->ipAddress('ip_address')->nullable()->comment('dia chi ip');
            $table->string('url_previous')->nullable()->comment('url');
            $table->string('device')->nullable()->comment('thiet bi');
            $table->string('browser')->nullable()->comment('trinh duyet');
            $table->string('cookies')->nullable();
            $table->string('note')->nullable();
            $table->string('user_agent', 1023)->nullable();
            $table->string('url_current')->nullable()->comment('url dang truy cap');
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
        Schema::dropIfExists('log_access');
    }
}
