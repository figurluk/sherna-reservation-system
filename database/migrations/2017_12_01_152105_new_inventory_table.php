<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class NewInventoryTable extends Migration
{
	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		\Schema::table('sherna_inventory_items', function ( Blueprint $table ) {
			$table->text('note')->nullable()->default(null)->change();
			
			$table->unsignedInteger('inventory_category_id');
			
			$table->boolean('console')->default(false);
			$table->boolean('vr')->default(false);
			$table->boolean('game_pad')->default(false);
			$table->boolean('move')->default(false);
			$table->unsignedSmallInteger('players')->nullable()->default(null);
		});
		
		\Schema::create('inventory_categories', function ( Blueprint $table ) {
			$table->increments('id');
			
			$table->nullableTimestamps();
			$table->softDeletes();
		});
		
		\Schema::create('inventory_categories_texts', function ( Blueprint $table ) {
			$table->increments('id');
			
			$table->unsignedInteger('inventory_category_id');
			$table->unsignedInteger('language_id');
			
			
			$table->string('name');
			
			$table->nullableTimestamps();
			$table->softDeletes();
		});
	}
	
	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		\Schema::dropIfExists('inventory_categories');
		\Schema::dropIfExists('inventory_categories_texts');
		
		\Schema::table('sherna_inventory_items', function ( Blueprint $table ) {
			$table->dropColumn(['inventory_category_id', 'console', 'vr', 'game_pad', 'move', 'players']);
		});
	}
}
