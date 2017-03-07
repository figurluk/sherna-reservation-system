<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTableLanguages extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('languages', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name')->nullable();
            $table->string('code')->nullable();
            $table->softDeletes();
        });


        DB::table('languages')->insert([
            'id'   => 1,
            'code' => 'sk',
            'name' => 'slovenský'
        ]);

        DB::table('languages')->insert([
            'id'   => 2,
            'code' => 'cz',
            'name' => 'český'
        ]);

        DB::table('languages')->insert([
            'id'   => 3,
            'code' => 'en',
            'name' => 'anglický'
        ]);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        \Schema::drop('languages');
    }
}
