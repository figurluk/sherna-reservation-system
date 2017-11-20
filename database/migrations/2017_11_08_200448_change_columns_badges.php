<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class ChangeColumnsBadges extends Migration
{
	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		\Schema::table('sherna_badges', function ( Blueprint $table ) {
			$table->dropColumn(['user_uid']);
			$table->dropColumn(['image']);
			
			$table->string('name');
		});
		
		\Schema::create('sherna_badges_users', function ( Blueprint $table ) {
			$table->increments('id');
			$table->unsignedInteger('badge_id');
			$table->unsignedInteger('user_id');
		});
	}
	
	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		\Schema::dropIfExists('sherna_badges_users');
	}
}
