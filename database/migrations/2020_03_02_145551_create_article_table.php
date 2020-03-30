<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateArticleTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('articles', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('title');
            $table->unsignedBigInteger('category_id');
            $table->unsignedBigInteger('layout_id')->default(1);
            $table->unsignedBigInteger('visibility_id')->default(1);
            $table->longText('content');
            $table->unsignedBigInteger('user_id');
            $table->unsignedBigInteger('view')->default(0);

            $table->foreign('category_id')->references('id')->on('categorys')->onDelete('cascade');
            $table->foreign('layout_id')->references('id')->on('sis_layout')->onDelete('cascade');
            $table->foreign('visibility_id')->references('id')->on('sis_visibility')->onDelete('cascade');
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');

            $table->timestamp('created_at')->default(DB::raw('CURRENT_TIMESTAMP'));
            $table->timestamp('updated_at')->default(DB::raw('CURRENT_TIMESTAMP'));
            // $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('articles');
    }
}
