<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePagesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('sherna_pages', function (Blueprint $table) {
            $table->increments('id');
            $table->string('code')->nullable();
            $table->boolean('public')->default(false);
            $table->nullableTimestamps();
        });

        Schema::create('sherna_pages_texts', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('page_id')->nullable();
            $table->unsignedInteger('language_id')->nullable();
            $table->string('name');
            $table->text('content')->nullable();
            $table->nullableTimestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        \Schema::drop('sherna_pages');
        Schema::drop('sherna_pages_texts');
    }
}
