<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('phone')->nullable()->comment('Số điện thoại');
            $table->string('email')->nullable()->comment('email');
            $table->string('image',1000)->nullable()->comment('Ảnh đại diện');
            $table->date('date')->nullable()->comment('Ngày sinh');
            $table->tinyInteger('sex')->nullable()->comment('Giới tính');
            $table->string('password')->nullable()->comment('Mật khẩu');
            $table->string('sender_id')->nullable()->comment('sender_id chat messenger');
            $table->rememberToken();
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
        Schema::dropIfExists('users');
    }
}
