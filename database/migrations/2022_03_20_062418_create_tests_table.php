<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTestsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('test', function (Blueprint $table) {
            $table->id();
            $table->string('name',1000)->nullable()->comment('tên');
            $table->string('contract_number',1000)->nullable()->comment('hợp đồng');
            $table->string('actor_name',1000)->nullable()->comment('Diễn viên');
			$table->string('director',1000)->nullable()->comment('Đạo diễn');
            $table->smallInteger('status')->nullable()->comment('trạng thái');
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
        Schema::dropIfExists('test');
    }
}
