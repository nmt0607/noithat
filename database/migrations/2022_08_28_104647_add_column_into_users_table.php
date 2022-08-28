<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddColumnIntoUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->string('username')->nullable()->comment('Mã số thuế');
            $table->string('address')->nullable()->comment('Địa chỉ công ty');
            $table->string('company_email')->nullable()->comment('Email công ty');
            $table->string('company_name')->nullable()->comment('Tên công ty');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn('username');
            $table->dropColumn('address');
            $table->dropColumn('company_email');
            $table->dropColumn('company_name');
        });
    }
}
