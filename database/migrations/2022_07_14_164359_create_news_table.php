<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateNewsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('news', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('name_vi')->comment('Vietnames name');
            $table->string('name_en')->nullable()->comment('English name');
            $table->text('intro_vi')->nullable()->comment('Vietnames description');
            $table->text('intro_en')->nullable()->comment('English description');
            $table->text('content_vi')->nullable()->comment('Vietnames content');
            $table->text('content_en')->nullable()->comment('English content');
            $table->string('meta_title_vi')->nullable()->comment('Vietnames meta data title');
            $table->string('meta_title_en')->nullable()->comment('English meta data title');
            $table->string('meta_des_vi')->nullable()->comment('Vietnames meta data description');
            $table->string('meta_des_en')->nullable()->comment('English meta data description');
            $table->string('image')->comment('Meta data image');
            $table->string('slug')->nullable();
            $table->string('slug_en')->nullable();
            $table->integer('status')->default(0);
            $table->integer('type')->default(1)->comment('1: include category, 2: exclude category');
            $table->string('category')->nullable()->comment('-1 - Ẩn, 1 - Nổi bật');
            $table->date('date_submit')->nullable();
            $table->string('author')->nullable()->comment('Tác giả');
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
        Schema::dropIfExists('news');
    }
}
