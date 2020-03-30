<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCategoryTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('categorys', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('name');
            $table->string('color')->nullable();
            $table->unsignedBigInteger('layout_id')->default(1);
            $table->unsignedBigInteger('visibility_id')->default(1);
            $table->string('icon')->nullable();
            $table->unsignedBigInteger('user_id');
            $table->boolean('isMenu')->default(true);
            $table->boolean('protect')->default(false);

            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('layout_id')->references('id')->on('sis_layout')->onDelete('cascade');
            $table->foreign('visibility_id')->references('id')->on('sis_visibility')->onDelete('cascade');

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
        Schema::dropIfExists('categorys');
    }
}
