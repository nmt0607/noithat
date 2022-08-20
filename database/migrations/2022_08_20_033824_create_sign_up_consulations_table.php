<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSignUpConsulationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('sign_up_consulations', function (Blueprint $table) {
            $table->id();
            $table->string('name')->comment('Họ và tên');
            $table->string('email')->unique();
            $table->string('phone')->unique();
            $table->string('position')->unique();
            $table->string('tax_code')->unique();
            $table->string('IP');
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
        Schema::dropIfExists('sign_up_consulations');
    }
}
