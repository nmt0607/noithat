<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateFaqsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('faqs', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('question', 1000)->nullable()->comment('Câu hỏi'); // Câu hỏi
            $table->longText('answer')->nullable()->comment('Câu trả lời');
            $table->string('category')->nullable()->comment('Sản phẩm áp dụng');
            $table->integer('order_number')->nullable()->comment('Thứ tự câu hỏi xuất hiện');
            $table->tinyInteger('type')->nullable('1: về sp, 2: về hạn nộp hs vay');
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
        Schema::dropIfExists('faqs');
    }
}
