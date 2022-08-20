<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMenusTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('menus', function (Blueprint $table) {
            $table->bigIncrements('id')->comment('Danh sach url');
            // $table->string('name', 500)->unique()->comment('ten chuc nang');
            // $table->string('code', 255)->unique()->comment('ma chuc nang');
            // $table->string('permission_name')->unique()->comment('tuong ung voi ten quyen han base');
            $table->string('alias')->unique()->comment('alias url trong router');
            // $table->string('note',1000)->comment('Mo ta chuc nang');
            // $table->bigInteger('admin_id')->nullable()->comment('Nguoi tao');

            // $table->string('meta')->nullable();
            // $table->string('meta_en')->nullable();
            // $table->string('title')->nullable();
            // $table->string('title_en')->nullable();
            // $table->string('description')->nullable();
            // $table->string('description_en')->nullable();
            // $table->string('keywords')->nullable();
            // $table->string('keywords_en')->nullable();

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
        Schema::dropIfExists('menus');
    }
}
